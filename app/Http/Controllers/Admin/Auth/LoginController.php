<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\PasswordReset;
use App\Models\SiteInformation;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function showLoginForm()
    {
        
        return view('Admin.auth.login');
    }

    public function login(Request $request)
    {
        if (is_numeric($request->get('username'))) {
            $field = 'phone';
        } elseif (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'username';
        }
        if (auth()->guard('admin')->attempt([$field => $request->username, 'password' => $request->password, 'user_type' => 'Admin'])) {
            if (Auth::guard('admin')->user()->status == 'Inactive') {
                Auth::guard('admin')->logout();
                return back()->withInput()->withErrors(['Account is inactive, Please contact your site owner']);
            } else {
                
                return redirect()->to('admin/dashboard')->with('success', 'Welcome Admin!');
            }
        } else {
            return back()->withInput()->withErrors(['Invalid credentials']);
        }
    }

    public function forgot_password(Request $request)
    {
        $user = User::where('email', $request->email)->where('user_type', 'Admin')->first();
        if ($user) {
            $token = Str::random(64);
            DB::beginTransaction();
            $password_reset = PasswordReset::insert([
                'email' => $request->email,
                'token' => $token,
                'created_at' => now()
            ]);
            if ($password_reset) {
                $link = url('admin/reset-password/' . $token);
                if (Helper::forgotPassword($user, $user->admin->name, $link)) {
                    DB::commit();
                    return response()->json([
                        'status' => true,
                        'message' => 'We have e-mailed your password reset link! Please check your email'
                    ]);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'status' => false,
                        'message' => 'Some error occurred while sending email, Please try after some time..!'
                    ]);
                }
            } else {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => "Some error occurred, Please try after some time..!"
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => "Email '" . $request->email . "' doesn't match with our records"
            ]);
        }
    }

    public function reset_password($token)
    {
        $title = 'Reset Password';
        $password_reset = PasswordReset::where('token', $token)->first();
        if ($password_reset) {
            if ((now()->diffInMinutes($password_reset->created_at)) > 15) {
                $link_expired = 'true';
            } else {
                $link_expired = 'false';
            }
            return view('Admin.auth.reset-password', compact('title', 'token', 'link_expired'));
        } else {
            return view('Admin.auth.reset-password', ['status' => 'invalid', 'title' => $title, 'message' => 'Invalid token!']);
        }
    }

    public function reset_password_store(Request $request, $token)
    {
        $password_reset = PasswordReset::where('token', $request->token)->first();
        if ($password_reset) {
            $request->validate([
                'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
                'password_confirmation' => 'required_if:password,!=,null|same:password',
            ]);

            $user = User::where('email', $password_reset->email)->first();
            if ($user) {
                $reset_password = $user->update([
                    'password' => Hash::make($request->password),
                ]);
                if ($reset_password) {
                    PasswordReset::where(['email' => $password_reset->email])->delete();
                    Helper::sendCredentials($user, $user->admin->name, $request->password);
                    return response()->json([
                        'status' => true,
                        'message' => 'Password has been reset successfully, Please sign-in using your new password'
                    ]);
                } else {
                    return response()->json(['status' => false, 'message' => "Some error occurred, Please try after some time..!"]);
                }
            } else {
                return response()->json(['status' => false, 'message' => "Invalid Email"]);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Invalid token!']);
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect(Helper::sitePrefix());
    }
}
