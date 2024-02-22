<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Helper;
use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
class SitemapController extends Controller
{
    public function __construct()
    {
        return Helper::commonData();
    }
    public function index(){
        return view('Admin.sitemap.form');
    }
    public function generate()
    {
        $type = 'contact';
       
        //create all the pages
        SitemapGenerator::create(url($type))->writeToFile(public_path('sitemap.xml'));
  

        return redirect()->back()->with('success','Sitemap Generated Successfully');

        // Return the sitemap as an XML response
    
    }

    
}
