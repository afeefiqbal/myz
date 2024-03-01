<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\SiteInformation;
use App\Models\User;
use App\Models\Vendor;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rules\Password;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    /**
     * Show the Admins List
     *
     * @return Renderable
     */
    public function admin()
    {
        if ((Auth::user()->admin->role) == "Super Admin") {
            $adminList = Vendor::with('user')->latest()->get();
            return view('Admin.vendor.list', compact('adminList'));
        } else {
            return view('backend.error.403');
        }
    }

    public function create()
    {
        if ((Auth::user()->admin->role) == "Super Admin") {
            $title = "Create";
            return view('Admin.vendor.form', compact('title'));
        } else {
            return view('backend.error.403');
        }
    }

    public function store(Request $request)
    {
        // dd(User::get());
      
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'phone' => 'required|min:7|max:15|unique:users,phone',
            'address' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
      
            'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
        ]);
        DB::beginTransaction();
   
        $user = new User;
        $user->user_type = 'Vendor';
        $user->email = $request->email;
        $user->username = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->created_by = Auth::id();
        if ($request->hasFile('profile_image')) {
            $user->profile_image_webp = Helper::uploadWebpImage($request->profile_image, 'uploads/Admin/profile_image/webp/', $request->username);
            $user->profile_image = Helper::uploadFile($request->profile_image, 'uploads/Admin/profile_image/', $request->username);
        }
        $user->image_attribute = $request->image_attribute;
        if ($user->save()) {
            $admin = new Admin;
            $admin->name = $request->name;
            $admin->user_id = $user->id;
            $admin->more_info = $request->more_info;
            $admin->role = 'Vendor';
            if ($admin->save()) {
                $vendor = new Vendor;
                $vendor->name = $request->name;
                $vendor->phone_number = $request->phone;
                $vendor->password = $request->password;
                $vendor->admin_id = $admin->id;
                $vendor->user_id = $user->id;
                $vendor->password = $request->password;
                $vendor->email = $request->email;
                $vendor->address = $request->address;
                $vendor->about_us = $request->more_info;
                $vendor->save();
                DB::commit();
                if (Helper::sendCredentials($user, $request->name, $request->password)) {
                    $message = $request->role . " '" . $request->name . "' has been added and credential mail has been sent successfully";
                } else {
                    $message = $request->role . " '" . $request->name . "' has been added successfully and error while sending credential mail";
                }
                return redirect(Helper::sitePrefix() . 'vendor')->with('success', $message);
            } else {
                DB::rollBack();
                return back()->with('message', 'Error while creating the ' . $request->role);
            }
        } else {
            DB::rollBack();
            return back()->with('message', 'Error while creating the admin');
        }
    }

    public function edit($id)
    {
        if ((Auth::user()->admin->role) == "Super Admin") {
            $title = "Edit";
            $admin = Vendor::with('user')->find($id);
            if ($admin) {
                return view('Admin.vendor.form', compact('admin', 'title'));
            } else {
                return view('backend.error.404');
            }
        } else {
            return view('backend.error.403');
        }
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::with('user')->find($id);
        $admin = Admin::with('user')->find($vendor->admin_id);

        $user = $admin->user;
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|min:7|max:15|unique:users,phone,' . $user->id,
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
         
        ]);
        DB::beginTransaction();
        $admin->name = $request->name;
        $admin->more_info = $request->more_info ?? '';
        $admin->updated_at = now();
        if ($admin->save()) {
            $user->username = $request->username;
            $user->phone = $request->phone;
            $user->email = $request->email;

            if ($request->hasFile('profile_image')) {
                if (File::exists(public_path($user->profile_image))) {
                    File::delete(public_path($user->profile_image));
                }
                if (File::exists(public_path($user->profile_image_webp))) {
                    File::delete(public_path($user->profile_image_webp));
                }
                $user->profile_image_webp = Helper::uploadWebpImage($request->profile_image, 'uploads/Admin/profile_image/webp/', $request->username);
                $user->profile_image = Helper::uploadFile($request->profile_image, 'uploads/Admin/profile_image/', $request->username);
            }
            $user->image_attribute = $request->image_attribute;
            $user->updated_by = Auth::id();
            $user->updated_at = now();
            if ($user->save()) {
                $vendor->name = $request->name;
                $vendor->phone_number = $request->phone;
                $vendor->password = $request->password;
                $vendor->admin_id = $admin->id;
                $vendor->user_id = $user->id;
                $vendor->password = $request->password;
                $vendor->email = $request->email;
                $vendor->address = $request->address;
                $vendor->about_us = $request->more_info;
                $vendor->save();
                DB::commit();
                return redirect(Helper::sitePrefix() . 'vendor')->with('success', $request->role . " '" . $request->name . "' has been updated successfully");
            } else {
                DB::rollBack();
                return back()->with('message', 'Error while updating the ' . $request->role);
            }
        } else {
            DB::rollBack();
            return back()->with('message', 'Error while updating the admin');
        }
    }

    public function delete(Request $request)
    {
        if ((Auth::user()->admin->role) == "Super Admin") {
            if (isset($request->id) && $request->id != NULL) {
                $admin = Admin::find($request->id);
                if ($admin) {
                    $user = $admin->user;
                    if ($user) {
                        $adminTagged = User::where('user_type', 'Admin')->where('created_by', $request->id)->first();
                        $customerTagged = User::where('user_type', 'Customer')->where('created_by', $request->id)->first();
                        if ($adminTagged) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Not Permitted : ' . $admin->name . ' tagged with created by section'
                            ]);
                        } else if ($customerTagged) {
                            return response()->json([
                                'status' => false,
                                'message' => 'Not Permitted : ' . $admin->name . ' tagged with customer'
                            ]);
                        } else {
                            DB::beginTransaction();
                            if (File::exists(public_path($user->profile_image))) {
                                File::delete(public_path($user->profile_image));
                            }
                            if (File::exists(public_path($user->profile_image_webp))) {
                                File::delete(public_path($user->profile_image_webp));
                            }
                            $user->profile_image = null;
                            $user->profile_image_webp = null;
                            $user->save();
                            if ($user->delete() && $admin->delete()) {
                                DB::commit();
                                return response()->json(['status' => true,]);
                            } else {
                                DB::rollBack();
                                return response()->json(['status' => false, 'message' => 'Error while deleting admin']);
                            }
                        }
                    } else {
                        return response()->json(['status' => false, 'message' => 'Record not found']);
                    }
                } else {
                    return response()->json(['status' => false, 'message' => 'Model class not found']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Empty value submitted']);
            }
        } else {
            return view('backend.error.403');
        }
    }

    public function reset_password($id)
    {
        if (Auth::user()->admin->role == "Super Admin") {
            if ($id) {
                $admin = Vendor::find($id);
                return view('Admin.vendor.reset_password', compact('admin'));
            } else {
                return view('backend.error.404');
            }
        } else {
            return view('backend.error.403');
        }
    }

    public function reset_password_store(Request $request, $id)
    {
        $request->validate([
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
        $admin = Vendor::find($id);
        if ($admin) {
            $admin->user->password = Hash::make($request->confirm_password);
           
            $admin->user->updated_at = now();
            if ($admin->user->save()) {
                return redirect(Helper::sitePrefix() . 'vendor')->with('success', $admin->role . " '" . $admin->name . "' password has been changed successfully");
            } else {
                return redirect(Helper::sitePrefix() . 'vendor/reset-password/' . $id)->with('error', " Error while changing the password");
            }
        } else {
            return view('backend.error.404');
        }
    }

    public function profile()
    {
        $adminData = Auth::user()->admin;
        if ($adminData) {
            return view('Admin.vendor.profile', compact('adminData'));
        } else {
            return view('backend.error.404');
        }
    }

    public function profile_store(Request $request)
    {
        $user_id = Auth::id();
        $admin = Auth::user()->admin;
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user_id,
            'phone' => 'required|max:255|unique:users,phone,' . $user_id,
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);
        DB::beginTransaction();
        $admin->name = $request->name;
        $admin->more_info = $request->more_info;
        $admin->updated_at = now();
        if ($admin->save()) {
            if ($request->hasFile('profile_image')) {
                if (File::exists(public_path($admin->user->profile_image))) {
                    File::delete(public_path($admin->user->profile_image));
                }
                if (File::exists(public_path($admin->user->profile_image_webp))) {
                    File::delete(public_path($admin->user->profile_image_webp));
                }
                $admin->user->profile_image_webp = Helper::uploadWebpImage($request->profile_image, 'uploads/Admin/profile_image/webp/', $request->username);
                $admin->user->profile_image = Helper::uploadFile($request->profile_image, 'uploads/Admin/profile_image/', $request->username);
            }
            $admin->user->image_attribute = $request->image_attribute;
            $admin->user->username = $request->username;
            $admin->user->phone = $request->phone;
            $admin->user->updated_by = Auth::id();
            $admin->user->updated_at = now();
            if ($admin->user->save()) {
                DB::commit();
                return redirect(Helper::sitePrefix() . 'vendor/profile')->with('success', "Profile has been updated successfully");
            } else {
                DB::rollBack();
                return back()->with('message', 'Error while updating the profile');
            }
        } else {
            DB::rollBack();
            return back()->with('message', 'Error while updating the profile');
        }
    }
}
