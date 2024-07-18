<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Affiliate;
use App\Models\AffiliateCommision;
use App\Models\AffiliateCommission;
use App\Models\SiteInformation;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class AffiliateCommissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function index()
    {
     
        $key = "Update";
        $title = "Update  Affiliiate";
        $affiliate = AffiliateCommision::first();

        return view('Admin.affiliate.form', compact('key', 'title', 'affiliate'));
    }
    public function store(Request $request)
    {
      

        $validatedData = $request->validate([
            'title' => 'required|min:2|max:255',
            'commision_amount' => 'required|min:2|max:255',
        ]);

        if ($request->id == 0) {
            $affiliate = new AffiliateCommision(); 
        } else {
            $affiliate = AffiliateCommision::find($request->id);
            $affiliate->updated_at = now();
        }
        $affiliate->title = $validatedData['title'];
        $affiliate->commision_amount = $validatedData['commision_amount'];

        if ($affiliate->save()) {
            session()->flash('success', "Affiliate '" . $request->title . "' has been added successfully");
            return redirect(Helper::sitePrefix() . 'affiliate');
        } else {
            return back()->with('error', 'Error while creating the about Feature');
        }
    }
        
        public function customers()
        {
        
            $key = "Update";
            $title = "Update  Affiliiate";
            $affiliates = AffiliateCommission::get();

            return view('Admin.affiliate.customers.list', compact('key', 'title', 'affiliates'));
        }
    
}
