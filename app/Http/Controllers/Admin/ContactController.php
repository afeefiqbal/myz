<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use App\Models\ContactAddress;
use Illuminate\Support\Facades\View;
use Termwind\Components\Dd;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function contact_page()
    {
        $key = "Update";
        $title = "Contact Page";
        $contact = SiteInformation::first();
        return view('Admin.contact.form', compact('key', 'title', 'contact'));
    }

    public function contact_page_store(Request $request)
    {
        
        
       
        $validatedData = $request->validate([
          
          
            'email' => 'required|min:3|max:50',
            'email_recipient' => 'required|min:3|max:50',
            'phone' => 'regex:/^([0-9\+ ]*)$/|min:7|max:15',
            'payment_query' => 'regex:/^([0-9\+ ]*)$/|min:7|max:15',
            'alternate_phone' => 'nullable|regex:/^([0-9\+ ]*)$/|min:7|max:15',
            'whatsapp_number' => 'regex:/^([0-9\+ ]*)$/|min:7|max:15',
        ]);
        if ($request->id == 0) {
            $contact = new SiteInformation;
        } else {
            $contact = SiteInformation::find($request->id);
            $contact->updated_at = now();
        }
        if ($request->hasFile('phone_image')) {
            Helper::deleteFile($contact, 'phone_image');
            Helper::deleteFile($contact, 'phone_image_webp');

            $contact->phone_image_webp = Helper::uploadWebpImage($request->phone_image, 'uploads/image/webp/', $request->title);
            $contact->phone_image = Helper::uploadFile($request->phone_image, 'uploads/image/', $request->title);
        }
        if ($request->hasFile('address_image')) {
            Helper::deleteFile($contact, 'address_image');
            Helper::deleteFile($contact, 'address_image_webp');

            $contact->address_image_webp = Helper::uploadWebpImage($request->address_image, 'uploads/image/webp/', $request->title);
            $contact->address_image = Helper::uploadFile($request->address_image, 'uploads/image/', $request->title);
        }
        if ($request->hasFile('email_image')) {
            Helper::deleteFile($contact, 'email_image');
            Helper::deleteFile($contact, 'email_image_webp');

            $contact->email_image_webp = Helper::uploadWebpImage($request->email_image, 'uploads/image/webp/', $request->title);
            $contact->email_image = Helper::uploadFile($request->email_image, 'uploads/image/', $request->title);
        }
        $contact->contact_page_title = $request->contact_page_title;
        $contact->contact_request_title = $request->contact_request_title;
        $contact->description = $request->description;
        $contact->enquiry_emails = $request->enquiry_emails;
        $contact->order_emails = $request->order_emails;
        $contact->google_map = $request->google_map;
        $contact->phone = $request->phone;
        $contact->alternate_phone = $request->alternate_phone;
        $contact->whatsapp_number = $request->whatsapp_number;
        $contact->payment_query = $request->payment_query;
        $contact->address = $request->address;
        $contact->email = $request->email;
        $contact->alternate_email = $request->alternate_email;
        $contact->email_recipient = $request->email_recipient;
        $contact->working_hours = $request->working_hours;
        $contact->google_review     = $request->google_review_url;
        $contact->follow_title = $request->follow_title;
        $contact->facebook_url = $request->facebook_url;
        $contact->instagram_url = $request->instagram_url;
        $contact->snapchat_url = $request->snapchat_url;
        $contact->pinterest_url = $request->pinterest_url;
        $contact->linkedin_url = $request->linkedin_url;
        $contact->youtube_url = $request->youtube_url;
        $contact->twitter_url = $request->twitter_url;

        if ($contact->save()) {
            session()->flash('success', 'Contact page details has been updated successfully');
            return redirect(Helper::sitePrefix() . 'contact');
        } else {
            return back()->with('error', 'Error while updating the contact page details');
        }
    }

    public function contact_address()
    {
        $key = "Update";
        $title = "Update Contact Address";
        $contact = ContactAddress::find(1);
        if ($contact) {
            return view('Admin.contact_address.form', compact('key', 'contact', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function contact_address_create()
    {
        $key = "Create";
        $title = "Create Contact Addres";
        return view('Admin.contact_address.form', compact('key', 'title'));
    }


    public function contact_address_store(Request $request)
    {

        $validatedData = $request->validate([
            'location' => 'required|min:2|max:230',
            'email' => 'required|email|min:3|max:50',
            'email_recipient' => 'required|min:3|max:50',
            'phone' => 'nullable|regex:/^([0-9\+ ]*)$/|min:7|max:15',
            'alternate_phone' => 'nullable|regex:/^([0-9\+ ]*)$/|min:7|max:15',
            'whatsapp_number' => 'nullable|regex:/^([0-9\+ ]*)$/|min:7|max:15',
        ]);
        $address = new ContactAddress();
        $address->location = $request->location;
        $address->google_map = $request->google_map;
        $address->phone = $request->phone;
        $address->alternate_phone = $request->alternate_phone;
        $address->whatsapp_number = $request->whatsapp_number;
        $address->address = $request->address;
        $address->email = $request->email;
        $address->alternate_email = $request->alternate_email;
        $address->email_recipient = $request->email_recipient;
        $address->working_time = $request->working_hours;

        $address->facebook_url = $request->facebook_url;
        $address->instagram_url = $request->instagram_url;
        $address->snapchat_url = $request->snapchat_url;
        $address->pinterest_url = $request->pinterest_url;
        $address->linkedin_url = $request->linkedin_url;
        $address->youtube_url = $request->youtube_url;
        $address->twitter_url = $request->twitter_url;
        $sort_order = ContactAddress::latest('sort_order')->first();
        if ($sort_order) {
            $sort_number = ($sort_order->sort_order + 1);
        } else {
            $sort_number = 1;
        }
        $address->sort_order = $sort_number;
        if ($address->save()) {
            session()->flash('success', "Contact Address ". $address->location." has been added successfully");
            return redirect(Helper::sitePrefix() . 'contact-address');
        } else {
            return back()->with('error', 'Error while creating the Contact Address');
        }
    }

    public function contact_address_edit(Request $request, $id)
    {
        $key = "Update";
        $title = "Update Contact Address";
        $contact = ContactAddress::find($id);
        if ($contact) {
            return view('Admin.contact_address.form', compact('key', 'contact', 'title'));
        } else {
            return view('Admin.error.404');
        }
    }

    public function contact_address_update(Request $request)
    {
        $address = ContactAddress::find(1);
        $validatedData = $request->validate([
            'location' => 'required|min:2|max:230',
            'email' => 'required|email|min:3|max:50',
            'email_recipient' => 'required|min:3|max:50',
            'phone' => 'nullable|regex:/^([0-9\+ ]*)$/|min:7|max:15',
            'alternate_phone' => 'nullable|regex:/^([0-9\+ ]*)$/|min:7|max:15',
            'whatsapp_number' => 'nullable|regex:/^([0-9\+ ]*)$/|min:7|max:15',
        ]);
        $address->location = $request->location;
        $address->google_map = $request->google_map;
        $address->phone = $request->phone;
        $address->alternate_phone = $request->alternate_phone;
        $address->whatsapp_number = $request->whatsapp_number;
        $address->address = $request->address;
        $address->email = $request->email;
        $address->alternate_email = $request->alternate_email;
        $address->email_recipient = $request->email_recipient;
        $address->working_time = $request->working_hours;

        $address->facebook_url = $request->facebook_url;
        $address->instagram_url = $request->instagram_url;
        $address->snapchat_url = $request->snapchat_url;
        $address->pinterest_url = $request->pinterest_url;
        $address->linkedin_url = $request->linkedin_url;
        $address->youtube_url = $request->youtube_url;
        $address->twitter_url = $request->twitter_url;
        $address->updated_at = now();
        if ($address->save()) {
            session()->flash('success', "Contact Address ".$address->location." has been updated successfully");
            return redirect(Helper::sitePrefix() . 'contact-address');
        } else {
            return back()->with('error', 'Error while updating the Contact Address');
        }
    }

    public function delete_contact_address(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $address = ContactAddress::find($request->id);
            if ($address) {
                if ($address->delete()) {
                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
            return response()->json(['status' => false, 'message' => 'Empty value submitted']);
        }
    }



}
