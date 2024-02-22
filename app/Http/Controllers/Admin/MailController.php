<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Customer;
use App\Models\DatabaseStorageModel;
use App\Models\MailTemplate;
use App\Models\Order;
use App\Models\Product;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class MailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function list()
    {
        $title = "Mail Template List";
        $itemList = MailTemplate::get();
        return view('Admin.mail_template.mail_template_list', compact('itemList', 'title'));
    }

    public function create()
    {
        $key = "Create";
        $title = "Create Mail Template";
        return view('Admin.mail_template.mail_template_form', compact('key', 'title'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'description' => 'required',
        ]);
        $mail_templateItem = MailTemplate::where('title', '=', $request->title)->count();
        if ($mail_templateItem > 0) {
            return back()->withInput($request->input())->withErrors("'" . $request->title . "' already added");
        } else {
            $item = new MailTemplate;
            $item->title = $validatedData['title'];
            $item->description = $validatedData['description'];
            if ($item->save()) {
                session()->flash('success', "Template '" . $request->title . "' has been added successfully");
                return redirect(Helper::sitePrefix() . 'mail/list');
            } else {
                return back()->with('error', 'Error while creating the item');
            }
        }
    }

    public function set_default(Request $request)
    {
        if ($request->id) {
            $template = MailTemplate::find($request->id);
            if ($request->state == "true") {
                DB::beginTransaction();
                $wholeTemplate = MailTemplate::get();
                foreach ($wholeTemplate as $cur) {
                    $currentOne = MailTemplate::find($cur->id);
                    $currentOne->is_default = "No";
                    $currentOne->save();
                }
                $template->is_default = "Yes";
                if ($template->save()) {
                    DB::commit();
                    return response()->json(['status' => true, 'message' => 'Template "' . $template->title . '" now changed to default']);
                } else {
                    DB::rollBack();
                    return response()->json(['status' => false, 'message' => 'Error while setting "' . $template->title . '" as default template, Please try after sometime']);
                }
            } else {
                return response()->json(['status' => true, 'message' => 'Template "' . $template->title . '" status changed']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    public function edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Mail Template";
        $item = MailTemplate::find($id);
        if ($item) {
            return view('Admin.mail_template.mail_template_form', compact('key', 'item', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function update(Request $request, $id)
    {
        $item = MailTemplate::find($id);
        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'description' => 'required',
        ]);
        $mail_templateItem = MailTemplate::where([['title', '=', $request->title], ['id', '!=', $id]])->count();
        if ($mail_templateItem > 0) {
            return back()->withInput($request->input())->withErrors("'" . $request->title . "' already added");
        } else {
            $item->title = $validatedData['title'];
            $item->description = $validatedData['description'];
            $item->updated_at = date('Y-m-d h:i:s');
            if ($item->save()) {
                session()->flash('success', "Template '" . $request->title . "' has been updated successfully");
                return redirect(Helper::sitePrefix() . 'mail/list');
            } else {
                return back()->with('error', 'Error while updating the item');
            }
        }
    }

    public function delete(Request $request)
    {
        if (isset($request->id) && $request->id != NULL) {
            $item = MailTemplate::find($request->id);
            if ($item) {
                if ($item->is_default == "Yes") {
                    return response()->json(['status' => false, 'message' => 'Error : "' . $item->title . '" is the default template']);
                } else {
                    $deleted = $item->delete();
                    if ($deleted == true) {
                        return response()->json(['status' => true]);
                    } else {
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }

    public function cart()
    {
        $title = "Cart List";
        $cartItem = DatabaseStorageModel::get();
     
        $customerList = Customer::get();
        $productList = Product::where('status', 'Active')->oldest('title')->get();
        return view('Admin.cart.cart_list', compact('cartItem', 'title', 'customerList', 'productList'));
    }

    public function cart_notify(Request $request)
    {
        $customerId = $request->customer_id;
        $customerData = Customer::find($customerId);
        $cartItem = DatabaseStorageModel::find($customerId . '_cart_items');
        $cartData = unserialize($cartItem->cart_data);
        $sendContactMail = Order::SendCartNotifyMail($cartData, $customerData, $request);
        if ($sendContactMail == true) {
            return response()->json(['status' => 'true', 'message' => 'Cart details notification has been sent successfully']);
        } else {
            return response()->json(['status' => 'false', 'message' => 'Error while notify cart details']);
        }
    }

    public function send_multi_contact(Request $request)
    {
        $customerId = explode(',', $request->id);
        $send = $failed = [];
        foreach ($customerId as $id) {
            $customerData = Customer::find($id);
            $cartItem = DatabaseStorageModel::find($id . '_cart_items');
            $cartData = unserialize($cartItem->cart_data);
            $sendContactMail = Order::SendCartNotifyMail($cartData, $customerData);
            if ($sendContactMail == true) {
                $send[] = 1;
            } else {
                $failed[] = $customerData->email;
            }
        }
        if ($send != NULL) {
            $failedText = '';
            if (!empty($failed)) {
                $failedText = 'Failed to send mail to "' . implode($failed) . '"';
            }
            $succesText = 'Mail sent successfully ' . $failedText;
            return response()->json(['status' => 'true', 'message' => $succesText]);
        } else {
            return response()->json(['status' => 'true', 'message' => 'Error while sent the notification']);
        }
    }

    public function cart_list_filter(Request $request)
    {
        $date_range = $request->date_range;
        $product = $request->cart_list_product;
        $customer = $request->cart_list_customer;
        $dateExploded = explode('-', $date_range);
        $startDate = date("Y-m-d", strtotime($dateExploded[0]));
        $endDate = date("Y-m-d", strtotime($dateExploded[1]));
        $start = $startDate . ' 00:00:00';
        $end = $endDate . ' 23:59:59';
        $cartItem = DatabaseStorageModel::whereBetween('created_at', [$start, $end])->get();
        if ($product != NULL) {
            $cartItems = [];
            foreach ($cartItem as $item) {
                $cartData = unserialize($item->cart_data);
                foreach ($cartData as $key => $cart) {
                    if ($key == $product) {
                        $cartItems[] = $item->id;
                    }
                }
                $cartItem = DatabaseStorageModel::whereIn('id', $cartItems)->get();
            }
        }
        if ($customer) {
            $cartItems = [];
            // $cartItem = DatabaseStorageModel::whereIn('id',$cartItem->pluck('id')->toArray());
            foreach ($cartItem as $item) {
                if ($item->id == $customer) {
                    $cartItems[] = $item->id;
                }
            }
            $cartItem = DatabaseStorageModel::whereIn('id', $cartItems)->get();
        }
        return view('Admin.cart.cart_list_filter', compact('cartItem'));
    }
}
