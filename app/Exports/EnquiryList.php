<?php

namespace App\Exports;

use App\Models\Enquiry;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Termwind\Components\Dd;

class EnquiryList implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $type = request()->type;
        if($type == 'contact'){
            $enquiries = Enquiry::whereNull('product_id')->where('type','contact')->latest();
            $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
            $to_date = request()->to_date!=null ? request()->to_date. " 23:59:59" : null;
            $condition =  Enquiry::whereNull('product_id')->where('type','contact')->latest();
            if($from_date!=null && $to_date!=null){
                $condition->whereBetween('created_at', [$from_date, $to_date]);
            }
            $enquiries = $condition->latest()->get();
         
            $enquiryList =[];
            foreach($enquiries as $key=>$value){
                $enquiryList[$key]['name'] = $value->name;
                $enquiryList[$key]['email'] = $value->email ??'';
                $enquiryList[$key]['phone'] = $value->phone;
                $enquiryList[$key]['message'] = $value->message;
                $enquiryList[$key]['reply'] = $value->reply;
                $enquiryList[$key]['request_url'] = $value->request_url;
                $enquiryList[$key]['created_at'] = date('d-m-Y', strtotime($value->created_at));

            }
          
            return view('Admin/enquiry/enquiry_list_excel', [
                'enquiryList' => $enquiryList,
                'type' => request()->type,
            ]);
        }
        else{

            $enquiries = Enquiry::whereNotNull('product_id')->where('type','product')->latest();
            $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
            $to_date = request()->to_date!=null ? request()->to_date. " 23:59:59" : null;
            $condition =  Enquiry::whereNotNull('product_id')->where('type','product')->latest();
            if($from_date!=null && $to_date!=null){
                $condition->whereBetween('created_at', [$from_date, $to_date]);
            }
            $enquiries = $condition->latest()->get();
            $enquiryList =[];
            foreach($enquiries as $key=>$value){
              if($value->product != null){

                  $enquiryList[$key]['name'] = $value->name;
                  $enquiryList[$key]['type'] = $value->product->productType->title ?? '';
                  $enquiryList[$key]['product'] = $value->product->title ;
                  $enquiryList[$key]['frame'] = $value->Frame->title ?? 'Nil';
                  $enquiryList[$key]['size'] = $value->Size->title;
                  if($value->productType->id == '4'){
                      $mount = $value->mount;
                  }
                  else{
                      $mount = '';
                  }
                  $enquiryList[$key]['mount'] = $mount;
           
                  $enquiryList[$key]['email'] = $value->email ??'';
                  $enquiryList[$key]['phone'] = $value->phone;
                  $enquiryList[$key]['message'] = $value->message;
                  $enquiryList[$key]['reply'] = $value->reply;
                  $enquiryList[$key]['request_url'] = $value->request_url;
                  $enquiryList[$key]['created_at'] = date('d-m-Y', strtotime($value->created_at));
              }
            }
            return view('Admin/enquiry/enquiry_list_excel', [
                'enquiryList' => $enquiryList,
                'type' => request()->type,
            ]);
        }


    }
}
