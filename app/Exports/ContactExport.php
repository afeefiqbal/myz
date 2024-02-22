<?php

namespace App\Exports;

use App\Models\ContactRequest;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Session;

class ContactExport implements FromView
{

    public function view(): View
    {
        $contactList = ContactRequest::get();
        return view('Admin/contact_us/contact_excel', [
            'contactList' => $contactList
        ]);
    }
}
