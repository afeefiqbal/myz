<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EnquiryList;
use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\Enquiry;
use App\Models\Newsletter;
use App\Models\SiteInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Termwind\Components\Dd;
use Yajra\DataTables\DataTables;

class EnquiryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $siteInformation = SiteInformation::first();
        return View::share(compact('siteInformation'));
    }

    public function enquiry_list(Request $request)
    {
       
        $title = "Enquiries List";
        $type = "contact";
        if ($request->ajax()) {
            $enquiryList =Enquiry::whereNull('product_id')->where('type','contact')->latest()->latest();
            $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
            $to_date = request()->to_date!=null ?  request()->to_date. " 23:59:59" : null;
            if(!empty($request->from_date) && !empty($request->to_date)){
                $enquiryList->whereBetween('created_at', [$from_date, $to_date]);
            }
            return DataTables::of($enquiryList)
            ->addIndexColumn()
            ->addColumn('created_at', function($row){
                $created_at = date('d-m-Y', strtotime($row->created_at));
                return $created_at;
            })
            ->addColumn('action', function($row) use($type){
                $btn = '';
                $btn .=  '<a class="mr-2 btn btn-primary" href="'.url(Helper::sitePrefix().'enquiry/'.($type == 'bulk'?'bulk/':'').'view/'.$row->id).'"><i
                     class="fa fa-eye fa-lg"></i></a>';
                $btn .= ' <a href="#" class="btn btn-danger mr-2 delete_entry tooltips" title="Delete Enquiry" data-url="enquiry/delete" data-id="'.$row->id.'"><i class="fas fa-trash"></i></a>';
                            if($type == 'bulk'){
                                $type = 'bulk';
                            }
                            else
                            {
                                $type = '';
                            }
                            if($row->reply==NULL){
                                $btn .= ' <a class="btn btn-success mr-2 reply_modal" title="Reply to Contact"  href="javascript:void(0)"" 
                                data-url="enquiry/'.$type.'reply" data-toggle="modal" data-reply="'. $row->reply.'" data-id="'.$row->id.'" 
                                 data-request="'.$row->email.'"   data-enquiry="'.$row->message.'">
                                 <i class="fa fa-reply fa-lg" style="color:red""></i></a>';

                            }
                            else{
                                $btn .= ' <a class="btn btn-success mr-2 reply_modal" title="Reply to Contact"  href="javascript:void(0)"" 
                                data-url="enquiry/'.$type.'reply" data-toggle="modal" data-reply="'. $row->reply.'" data-id="'.$row->id.'" 
                                 data-request="'.$row->email.'"   data-enquiry="'.$row->message.'">
                                 <i class="fa fa-reply fa-lg"style="color:green""></i></a>';
                            }
                return $btn;
            })  ->rawColumns([ 'action'])
            ->make(true);
        }
       
        return view('Admin.enquiry.list', compact( 'title', 'type'));
    }

    public function enquiry_view($id)
    {
        $title = "View Enquiry";
        $type = "contact";
        $enquiry = Enquiry::find($id);
        return view('Admin.enquiry.view', compact('enquiry', 'title', 'type'));
    }

    public function reply_to_enquiry(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        if (isset($request->reply) && $request->reply != null) {
            $enquiry = Enquiry::find($request->id);
            if ($enquiry) {
                DB::beginTransaction();
                $enquiry->reply = $request->reply;
                $enquiry->reply_date = now();
                if ($enquiry->save()) {
                    if (Helper::sendReply($enquiry)) {
                        DB::commit();
                        return response()->json(['status' => true, 'message' => 'Reply saved successfully']);
                    } else {
                        DB::rollBack();
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
            return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_enquiry(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $enquiry = Enquiry::find($request->id);
            if ($enquiry) {
                $deleted = $enquiry->delete();
                if ($deleted == true) {
                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_multi_enquiry(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $enquiryArray = explode(',', $request->id);
            $successArray = array();
            foreach ($enquiryArray as $con) {
                $enquiry = Enquiry::find($con);
                $deleted = $enquiry->delete();
                if ($deleted == true) {
                    $successArray[] = '1';
                }
            }
            if ($successArray) {
                return response()->json(['status' => true]);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function newsletter()
    {
        $title = "Newsletter Subscribers";
        $newsletterList = Newsletter::latest('id')->get();
        return view('Admin.newsletter.list', compact('newsletterList', 'title'));

    }

    public function delete_multi_newsletter(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $newsletterArray = explode(',', $request->id);
            $successArray = array();
            foreach ($newsletterArray as $item_id) {
                $newsletter = Newsletter::find($item_id);
                $deleted = $newsletter->delete();
                if ($deleted == true) {
                    $successArray[] = '1';
                }
            }
            if ($successArray) {
                return response()->json(['status' => true]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Some error occurred while deleting elements.,please try after sometime'
                ]);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_newsletter(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $newsletter = Newsletter::find($request->id);
            if ($newsletter) {
                $deleted = $newsletter->delete();
                if ($deleted == true) {
                    return response()->json(['status' => true]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Some error occurred,please try after sometime'
                    ]);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    /******************************** Bulk Enquiry ************************************/
    public function bulk_list(Request $request)
    {
        $title = "Bulk List";
        $type = "bulk";
        if ($request->ajax()) {
            $from_date = request()->from_date!=null ?  request()->from_date. " 00:00:00" : null;
            $to_date = request()->to_date!=null ?  request()->to_date. " 23:59:59" : null;
            $enquiryList = Enquiry::whereNotNull('product_id')->where('type','product')->latest();
            if(!empty($request->from_date) && !empty($request->to_date)){
                $enquiryList->whereBetween('created_at', [$from_date, $to_date]);
            }
            return DataTables::of($enquiryList)
            ->addIndexColumn()
            ->addColumn('created_at', function($row){
                $created_at = date('d-m-Y', strtotime($row->created_at));
                return $created_at;
            })
            ->addColumn('product', function($row){
               
                return $row->product->title ?? '';
            })
            ->addColumn('type', function($row){
               
                return $row->product->productType->title ?? '';
            })
            ->addColumn('frame', function($row){
               
                return $row->Frame->title ?? '';
            })
            ->addColumn('size', function($row){
               
                return $row->Size->title ?? '';
            })
            ->addColumn('mount', function($row){
                $mount = '';
                if($row->productType->id == '4'){
                    $mount = $row->mount;
                }
                else{
                    $mount = '';
                }
                return $mount;
            })
            ->addColumn('action', function($row) use($type){
                $btn = '';
                $btn .=  '<a class="mr-2 btn btn-primary" href="'.url(Helper::sitePrefix().'enquiry/'.($type == 'bulk'?'bulk/':'').'view/'.$row->id).'"><i
                     class="fa fa-eye fa-lg"></i></a>';
                $btn .= ' <a href="#" class="btn btn-danger mr-2 delete_entry tooltips" title="Delete Enquiry" data-url="enquiry/delete" data-id="'.$row->id.'"><i class="fas fa-trash"></i></a>';
                            if($type == 'bulk'){
                                $type = 'bulk';
                            }
                            else
                            {
                                $type = '';
                            }
                            if($row->reply==NULL){
                                $btn .= ' <a class="btn btn-success mr-2 reply_modal" title="Reply to Contact"  href="javascript:void(0)"" 
                                data-url="enquiry/'.$type.'reply" data-toggle="modal" data-reply="'. $row->reply.'" data-id="'.$row->id.'" 
                                 data-request="'.$row->email.'"   data-enquiry="'.$row->message.'">
                                 <i class="fa fa-reply fa-lg" style="color:red""></i></a>';

                            }
                            else{
                                $btn .= ' <a class="btn btn-success mr-2 reply_modal" title="Reply to Contact"  href="javascript:void(0)"" 
                                data-url="enquiry/'.$type.'reply" data-toggle="modal" data-reply="'. $row->reply.'" data-id="'.$row->id.'" 
                                 data-request="'.$row->email.'"   data-enquiry="'.$row->message.'">
                                 <i class="fa fa-reply fa-lg"style="color:green""></i></a>';
                            }
                return $btn;
            })  ->rawColumns([ 'action'])
        ->make(true);

        }
     
        return view('Admin.enquiry.list', compact( 'title', 'type'));
    }

    public function bulk_view($id)
    {
        $title = "View Bulk";
        $type = "bulk";
       
        $enquiry = Enquiry::whereNotNull('product_id')->with('product')->find($id);
        return view('Admin.enquiry.view', compact('enquiry', 'title', 'type'));
    }

    public function reply_to_bulk(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        if (isset($request->reply) && $request->reply != null) {
            $bulk = Enquiry::find($request->id);
            if ($bulk) {
                DB::beginTransaction();
                $bulk->reply = $request->reply;
                $bulk->reply_date = now();
                if ($bulk->save()) {
                    if (Helper::sendReply($bulk)) {
                        DB::commit();
                        return response()->json(['status' => true, 'message' => 'Reply saved successfully']);
                    } else {
                        DB::rollBack();
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_bulk(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $bulk = Enquiry::find($request->id);
            if ($bulk) {
                if (File::exists($bulk->file)) {
                    File::delete($bulk->file);
                }
                $bulk->file = '';
                $bulk->save();
                if ($bulk->delete()) {
                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_multiple_bulk(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $bulkArray = explode(',', $request->id);
            $successArray = array();
            foreach ($bulkArray as $item_id) {
                $bulk = Enquiry::find($item_id);
                if (File::exists($bulk->file)) {
                    File::delete($bulk->file);
                }
                $bulk->file = '';
                $bulk->save();
                if ($bulk->delete()) {
                    $successArray[] = '1';
                }
            }
            if ($successArray) {
                return response()->json(['status' => true]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Some error occurred while deleting elements.,please try after sometime'
                ]);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }


    /******************************** Get Quote Enquiry ************************************/
    public function get_quote_list()
    {
        $title = "Get A Quote List";
        $type = "get-quote";
        $enquiryList = Enquiry::where('type','get_a_quote')->latest()->get();
//     dd($enquiryList);
        return view('Admin.enquiry.list', compact('enquiryList', 'title', 'type'));
    }

    public function get_quote_view($id)
    {
        $title = "View Get A Quote";
        $type = "get-quote";
        $enquiry = Enquiry::where('type','get_a_quote')->find($id);
        return view('Admin.enquiry.view', compact('enquiry', 'title', 'type'));
    }

    public function reply_to_get_quote(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        if (isset($request->reply) && $request->reply != null) {
            $bulk = Enquiry::find($request->id);
            if ($bulk) {
                DB::beginTransaction();
                $bulk->reply = $request->reply;
                $bulk->reply_date = now();
                if ($bulk->save()) {
                    if (Helper::sendReply($bulk)) {
                        DB::commit();
                        return response()->json(['status' => true, 'message' => 'Reply saved successfully']);
                    } else {
                        DB::rollBack();
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_get_quote(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $bulk = Enquiry::find($request->id);
            if ($bulk) {
                if (File::exists($bulk->file)) {
                    File::delete($bulk->file);
                }
                $bulk->file = '';
                $bulk->save();
                if ($bulk->delete()) {
                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_multiple_get_quote(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $bulkArray = explode(',', $request->id);
            $successArray = array();
            foreach ($bulkArray as $item_id) {
                $bulk = Enquiry::find($item_id);
                if (File::exists($bulk->file)) {
                    File::delete($bulk->file);
                }
                $bulk->file = '';
                $bulk->save();
                if ($bulk->delete()) {
                    $successArray[] = '1';
                }
            }
            if ($successArray) {
                return response()->json(['status' => true]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Some error occurred while deleting elements.,please try after sometime'
                ]);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    /******************************** product Enquiry ************************************/
    public function product_list()
    {
        $title = "Product Enquiry List";
        $type = "product";
        $enquiryList = Enquiry::whereNotNull('product_id')->where('type','product')->latest()->get();

        return view('Admin.enquiry.list', compact('enquiryList', 'title', 'type'));
    }

    public function product_view($id)
    {
        $title = "View Get A Quote";
        $type = "product";
        $enquiry = Enquiry::whereNotNull('product_id')->where('type','get_a_quote')->find($id);
        return view('Admin.enquiry.view', compact('enquiry', 'title', 'type'));
    }

    public function reply_to_product(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        if (isset($request->reply) && $request->reply != null) {
            $bulk = Enquiry::find($request->id);
            if ($bulk) {
                DB::beginTransaction();
                $bulk->reply = $request->reply;
                $bulk->reply_date = now();
                if ($bulk->save()) {
                    if (Helper::sendReply($bulk)) {
                        DB::commit();
                        return response()->json(['status' => true, 'message' => 'Reply saved successfully']);
                    } else {
                        DB::rollBack();
                        return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                    }
                } else {
                    DB::rollBack();
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_product(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $bulk = Enquiry::find($request->id);
            if ($bulk) {
                if (File::exists($bulk->file)) {
                    File::delete($bulk->file);
                }
                $bulk->file = '';
                $bulk->save();
                if ($bulk->delete()) {
                    return response()->json(['status' => true]);
                } else {
                    return response()->json(['status' => false, 'message' => 'Some error occurred,please try after sometime']);
                }
            } else {
                return response()->json(['status' => false, 'message' => 'Model class not found']);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }

    public function delete_multiple_product(Request $request)
    {
        if (isset($request->id) && $request->id != null) {
            $bulkArray = explode(',', $request->id);
            $successArray = array();
            foreach ($bulkArray as $item_id) {
                $bulk = Enquiry::find($item_id);
                if (File::exists($bulk->file)) {
                    File::delete($bulk->file);
                }
                $bulk->file = '';
                $bulk->save();
                if ($bulk->delete()) {
                    $successArray[] = '1';
                }
            }
            if ($successArray) {
                return response()->json(['status' => true]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Some error occurred while deleting elements.,please try after sometime'
                ]);
            }
        } else {
             return response()->json(['status' => "", 'message' => 'Empty value submitted']);
        }
    }
    public function export()
    {
       
       
        //pass the from and to date to the query
    
        return Excel::download(new EnquiryList, 'enquiry-list.xlsx');
        // return Excel::download(new OrderList, 'order-list.xlsx');
    }

}
