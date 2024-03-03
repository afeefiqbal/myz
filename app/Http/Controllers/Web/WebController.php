<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Helper;
use App\Models\About;
use App\Models\AboutFeature;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Homecollection;
use App\Models\Color;
use App\Models\Latest;
use App\Models\ContactAddress;
use App\Models\Deal;
use App\Models\Enquiry;
use App\Models\Frame;
use App\Models\CurrencyRate;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use App\Models\History;
use App\Models\HomeAdvertisement;
use App\Models\HomeBanner;
use App\Models\HomeGetQuote;
use App\Models\HomeHeading;
use App\Models\HotDeal;
use App\Models\KeyFeature;
use App\Models\Newsletter;
use App\Models\Offer;
use App\Models\OfferStrip;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductReview;
use App\Models\ProductSpecificationHead;
use App\Models\ProductType;
use App\Models\Size;
use App\Models\SeoData;
use App\Models\SiteInformation;
use App\Models\Tag;
use App\Models\Shape;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class WebController extends Controller
{
    public function __construct()
    {
     return $site = Helper::commonData();
        
    }

    public function seo_content($page)
    {
        $seo_data = SeoData::page($page)->first();
        return $seo_data;
    }


    public function home()
    {
        
        $prdts = Category::active()->oldest('sort_order')->where('display_to_home','Yes')->get();

        $catIds = $prdts->pluck('id')->toArray();
        $prs =  Product::whereIn('category_id',$catIds)->where('copy','no')->get();

        $categories =  Category::active()->oldest('sort_order')->where('display_to_home','Yes')->get();


        $testimonials = Testimonial::active()->take(10)->get();
        $recentlyViewedProducts = Helper::getRecentProducts();

        $catHomeHeadings = HomeHeading::where('type','category')->first();
        $products = Product::active()->where('display_to_home','Yes')->where('copy','no')->get();
        $ourSelectionProducts = DB::table('our_selection')->orderBy('sort_order')->pluck('product_id')->toArray();

        $ourSelectionProducts = [];


    return view('web.home', compact('categories','recentlyViewedProducts','products'));
    }


    public function about()
    {


        $seo_data = $this->seo_content('About');
        
        $about = About::first();
        $homeHeadings = HomeHeading::get();
        $aboutFeatures = AboutFeature::active()->take(4)->oldest('sort_order')->get();
        $histories = History::active()->oldest('sort_order')->get();
        $banner = Banner::type('about')->first();
        $catHomeHeadings = HomeHeading::where('type','category')->first();

        $prdts = Category::active()->oldest('sort_order')->where('display_to_home','Yes')->get();

        $catIds = $prdts->pluck('id')->toArray();
       $prs =  Product::whereIn('category_id',$catIds)->where('copy','no')->get();
       $catIdss = $prs->pluck('category_id')->toArray();
  
       $themes =  Category::whereIn('id',$catIdss)->get();
       $testimonials = Testimonial::get();
   

        return view('web.about', compact('seo_data', 'about', 'aboutFeatures', 'banner', 'histories', 'homeHeadings','catHomeHeadings','themes','testimonials'));
    }



    public function contact()
    {
        $seo_data = $this->seo_content('Contact');
        $contact = SiteInformation::first();
        $contactAddresses = ContactAddress::active()->get();
        $banner = Banner::type('contact')->first();
        return view('web.contact', compact('seo_data', 'contact', 'banner', 'contactAddresses'));
    }

    //enquiry and bulk enquiry storing
    public function enquiry_store(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'name' => 'required|regex:/^[\pL\s]+$/u|min:2|max:60',
            'email' => 'required|max:255|regex:/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/',
            'phone' => 'required|regex:/^([0-9\+]*)$/|min:7|max:20',
            // 'subject' => 'required',
            'message' => 'required',
        ]);

        $contact = new Enquiry();


        $contact->type = $request->type;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->message = $request->message;
        $contact->product_id = $request->product_id ?? NULL;
        $contact->product_type_id = $request->product_type_id ?? NULL;
        $contact->size_id = $request->size_id ?? NULL;
        $contact->frame_id = $request->frame_id ?? NULL;
        $contact->mount = $request->mount ?? NULL;

        $contact->request_url = url()->previous();

 
        if ($request->type == 'get_a_quote') {
            $type = " Get A Quote";
        } elseif ($request->type == 'product') {
            $type = ' Product Enquiry';
        }
        elseif ($request->type == 'bulk') {
            $type = ' Bulk  Enquiry';
        }
         else {
            $type = ' Contact request';
        }
       
        if ($contact->save()) {

            $sendContactMail = Helper::sendContactMail($contact, $type);
            if ($sendContactMail) {

                return response()->json(['status' => 'success',
                    'message' => $type . ' has been submitted successfully']);
            } else {
                return response()->json(['status' => 'success',
                    'message' => "Contact request has been submitted successfully,Can't sent the mail right now"]);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Error : Error while submitting the request']);
        }
    }


    public function blogs()
    {
        $banner = Banner::type('blogs')->first();
         $heading = HomeHeading::type('blog')->first();
        $seo_data = $this->seo_content('Blogs');
        $latestBlog = Blog::active()->latest('posted_date')->first();

        // $latestThreeBlogs = Blog::active()->skip(1)->take(3)->latest('posted_date')->get();

        $totalBlog = Blog::active()->count();

        $condition = Blog::active();

        $blogs = $condition->orderBy('id','asc')->take(3)->get();
      
        $offset = $blogs->count();
        $loading_limit = 3;
        return view('web.blogs', compact('seo_data', 'banner', 'latestBlog', 'heading',
            'blogs', 'totalBlog', 'offset', 'loading_limit'));
    }

    public function blogLoadMore(Request $request)
    {
        $offset = $request->offset;
        $loading_limit = $request->loading_limit;
        $condition = Blog::active();
        $totalBlog = $condition->count();
        $blogs = $condition->skip($offset)->take($loading_limit)->get();
        $offset += $blogs->count();

        return view('web._blog_list', compact('blogs', 'loading_limit', 'totalBlog', 'offset', 'blogs'));
    }

    public function blog_detail($short_url)
    {
         $blog = Blog::active()->shortUrl($short_url)->first();
      
        if ($blog) {
            $banner = $seo_data = $blog;
            $type = $short_url;
            $recentBlogs = Blog::active()->latest('posted_date')->where('id', '!=', $blog->id)->get();
            $previousBlog = Blog::active()->latest('posted_date')->where('id', '<', $blog->id)->first();
            $nextBlog = Blog::active()->latest('posted_date')->where('id', '>', $blog->id)->first();
            return view('web.blog', compact('blog', 'recentBlogs', 'banner', 'seo_data',
                'previousBlog', 'nextBlog','type'));
        } else {
            return view('web.404');
        }
    }


    public function products()
    {



        $banner = Banner::type('product')->first();
        $seo_data = $this->seo_content('Products');
       $parentCategories = Category::active()->with('activeChildren')->orderBy('sort_order')->get();
        $condition = Product::active()->where('copy','no');

         $totalProducts = $condition->count();
         $products = $condition->latest()->take(12)->where('status',"active")->get();
        $colors = Color::active()->oldest('title')->get();
     
        $offset = $products->count();
    
        $loading_limit = 15;
        $type = "product";
        $typeValue = 'all';
        $sort_value = 'latest';
        $title = 'Products';
        $latestProducts = Product::active()->take(5)->latest()->get();
        return view('web.products', compact('seo_data', 'products', 'totalProducts', 'offset', 'loading_limit',
            'parentCategories', 'colors', 'banner', 'type', 'typeValue', 'latestProducts',
            'title', 'sort_value'));
    }


    public function category($short_url)
    {
        $category = Category::active()->shortUrl($short_url)->first();
        if ($category) {
            $seo_data = $category;
            if(@$seo_data->meta_title == '')
            $seo_data->meta_title = $category->title;


            if(@$seo_data->meta_description == '')
                $seo_data->meta_description = $category->title;
            if(@$seo_data->meta_keyword == '')
                $seo_data->meta_keyword = $category->title;
            $parentCategories = Category::active()->isParent()->orderBy('sort_order')->get();
            $banner = Banner::type('product')->first();
            $subCategoryIds = implode('|', ((collect($category->id)->merge(Helper::getAllSubCategories($category->id)->pluck('id')))->toArray()));
            $condition = Product::active()->whereRaw("(FIND_IN_SET('" . $category->id . "',category_id)")->orwhereRaw('CONCAT(",", `sub_category_id`, ",") REGEXP ",(' . $subCategoryIds . '),")')
            ->where('copy','no');
            $totalProducts = $condition->count();
            $products = $condition->where('copy','no')->latest()->take(12)->get();

            $colors = Color::active()->oldest('title')->get();
            $offset = $products->count();
            $loading_limit = 15;
            $type = "category";
            $colors = Color::active()->oldest('title')->get();
            // $shapes = Shape::active()->orderBy('sort_order','asc')->get();totalRatin
            $tags = Tag::orderBy('sort_order')->get();
            // $shapescount = count($shapes);
            $typeValue = $short_url;
            $sort_value = 'latest';
            $title = ucfirst($category->title);
            $latestProducts = Product::active()->whereRaw("find_in_set('" . $category->id . "',category_id)")->take(5)->latest()->get();
            return view('web.products', compact('seo_data', 'products', 'totalProducts', 'offset', 'loading_limit','tags',
                'parentCategories', 'colors', 'category', 'banner', 'type', 'typeValue', 'latestProducts',
                'title', 'sort_value'));
        } else {
            return view('web.404');
        }
    }
    public function color($short_url)
    {
        $color = Color::active()->where('title',$short_url)->first();

        if ($color) {
            $seo_data = $color;

                    if(@$seo_data->meta_title == '')
                    $seo_data->meta_title = $color->title;


        if(@$seo_data->meta_description == '')
            $seo_data->meta_description = $color->title;
        if(@$seo_data->meta_keyword == '')
            $seo_data->meta_keyword = $color->title;

            $allProducts = Product::active()->first();
            $banner = Banner::type('product')->first();
            $subCategoryIds = implode('|', ((collect($color->id))->toArray()));
            $condition = Product::active()->whereRaw("(FIND_IN_SET('" . $color->id . "',color_id)")->orwhereRaw('CONCAT(",", `color_id`, ",") REGEXP ",(' . $subCategoryIds . '),")')
            ->where('copy','no');
            $totalProducts = $condition->count();
         
            $products = $condition->where('copy','no')->latest()->take(12)->get();

            $colors = Color::active()->oldest('title')->get();
            $offset = $products->count();
            $loading_limit = 15;
            $type = "color";
            $colors = Color::active()->oldest('title')->get();
            $shapes = Shape::active()->orderBy('sort_order','asc')->get();
            $tags = Tag::orderBy('sort_order')->get();
            $shapescount = count($shapes);
            $typeValue =  $color->title;
            $sort_value = 'latest';
            $title = ucfirst($color->title);
            $latestProducts = Product::active()->whereRaw("find_in_set('" . $color->id . "',color_id)")->take(5)->latest()->get();
            return view('web.products', compact('seo_data', 'products', 'totalProducts', 'offset', 'loading_limit','shapes','tags','shapescount', 'colors', 'color', 'banner', 'type', 'typeValue', 'latestProducts',
                'title', 'sort_value'));
        } else {
            return view('web.404');
        }
    }
    public function latest_products(){
        
        $banner = Banner::type('product')->first();
        $seo_data = $this->seo_content('Products');
       $parentCategories = Category::active()->isParent()->with('activeChildren')->orderBy('sort_order')->get();
        $condition = Product::active()->where('copy','no')->where('new_arrival','Yes');
      
         $totalProducts = $condition->count();
         $products = $condition->latest()->get();
       
        $colors = Color::active()->oldest('title')->get();
        $shapes = Shape::active()->orderBy('sort_order','asc')->get();
        $tags = Tag::orderBy('sort_order')->get();
        $shapescount = count($shapes);
        $offset = $products->count();
        $loading_limit = 15;
        $type = "product";
        $typeValue = 'latest';
        $sort_value = 'latest';
        $title = 'Products';
        
        $latestProducts = Product::active()->take(5)->latest()->get();
        return view('web.products', compact('seo_data', 'products', 'totalProducts', 'offset', 'loading_limit',
            'parentCategories', 'colors', 'banner', 'type', 'typeValue', 'latestProducts',
            'title', 'sort_value','shapes','tags','shapescount'));
    }
    public function popular_products(){
        
        $banner = Banner::type('product')->first();
        $seo_data = $this->seo_content('Products');
       $parentCategories = Category::active()->isParent()->with('activeChildren')->orderBy('sort_order')->get();
        $condition = Product::active()->where('copy','no')->where('best_seller','Yes');
      
         $totalProducts = $condition->count();
         $products = $condition->latest()->get();
       
        $colors = Color::active()->oldest('title')->get();
        $shapes = Shape::active()->orderBy('sort_order','asc')->get();
        $tags = Tag::orderBy('sort_order')->get();
        $shapescount = count($shapes);
        $offset = $products->count();
        $loading_limit = 15;
        $type = "product";
        $typeValue = 'popular';
        $sort_value = 'latest';
        $title = 'Products';
        
        $latestProducts = Product::active()->take(5)->latest()->get();
        return view('web.products', compact('seo_data', 'products', 'totalProducts', 'offset', 'loading_limit',
            'parentCategories', 'colors', 'banner', 'type', 'typeValue', 'latestProducts',
            'title', 'sort_value','shapes','tags','shapescount'));
    }
    public function most_relevent_products(){
        
        $banner = Banner::type('product')->first();
        $seo_data = $this->seo_content('Products');
       $parentCategories = Category::active()->isParent()->with('activeChildren')->orderBy('sort_order')->get();
        $condition = Product::active()->where('copy','no')->where('is_featured','Yes');
      
         $totalProducts = $condition->count();
         $products = $condition->latest()->get();
       
        $colors = Color::active()->oldest('title')->get();
        $shapes = Shape::active()->orderBy('sort_order','asc')->get();
        $tags = Tag::orderBy('sort_order')->get();
        $shapescount = count($shapes);
        $offset = $products->count();
        $loading_limit = 15;
        $type = "product";
        $typeValue = 'Most Relevent';
        $sort_value = 'latest';
        $title = 'Products';
        
        $latestProducts = Product::active()->take(5)->latest()->get();
        return view('web.products', compact('seo_data', 'products', 'totalProducts', 'offset', 'loading_limit',
            'parentCategories', 'colors', 'banner', 'type', 'typeValue', 'latestProducts',
            'title', 'sort_value','shapes','tags','shapescount'));
    }
    public function shape($short_url)
    {
        $shape = Shape::active()->where('title',$short_url)->first();

        if ($shape) {
            $seo_data = $shape;

            if(@$seo_data->meta_title == '')
            $seo_data->meta_title = $shape->title;
            if(@$seo_data->meta_description == '')
                $seo_data->meta_description = $shape->title;
            if(@$seo_data->meta_keyword == '')
                $seo_data->meta_keyword = $shape->title;
            // $parentCategories = Category::active()->isParent()->get();
            $allProducts = Product::active()->first();
            $banner = Banner::type('product')->first();
            $subCategoryIds = implode('|', ((collect($shape->id))->toArray()));
            $condition = Product::active()->whereRaw("(FIND_IN_SET('" . $shape->id . "',shape_id)")->orwhereRaw('CONCAT(",", `shape_id`, ",") REGEXP ",(' . $subCategoryIds . '),")')
            ->where('copy','no');
            $totalProducts = $condition->count();
            $products = $condition->where('copy','no')->latest()->take(12)->get();

            $colors = Color::active()->oldest('title')->get();
            $offset = $products->count();
            $loading_limit = 15;
            $type = "shape";
            $colors = Color::active()->oldest('title')->get();
            $shapes = Shape::active()->orderBy('sort_order','asc')->get();
            $tags = Tag::orderBy('sort_order')->get();
            $shapescount = count($shapes);
            $typeValue =  $shape->title;
            $sort_value = 'latest';
            $title = ucfirst($shape->title);
            $latestProducts = Product::active()->whereRaw("find_in_set('" . $shape->id . "',shape_id)")->take(5)->latest()->get();
            return view('web.products', compact('seo_data', 'products', 'totalProducts', 'offset', 'loading_limit','shapes','tags','shapescount',
                'colors', 'shape', 'banner', 'type', 'typeValue', 'latestProducts',
                'title', 'sort_value'));
        } else {
            return view('web.404');
        }
    }
    public function deal($short_url)
    {
        if ($short_url) {
            $deal = Deal::active()->shortUrl($short_url)->first();
            if ($deal) {
                $seo_data = $deal;
                $banner = $deal;
                $parentCategories = Category::active()->isParent()->orderBy('sort_order')->get();
                $condition = Product::active()->whereIn('id', explode(',', $deal->products))->where('copy','no');
                $totalProducts = $condition->count();
                $products = $condition->latest()->take(12)->get();
                $colors = Color::active()->get();
                $offset = $products->count();
                $loading_limit = 15;
                $type = "deal";
                $typeId = $deal->id;
                $typeValue = $short_url;
                $sort_value = 'latest';
                $title = ucfirst($deal->title);
                $latestProducts = Product::active()->whereIn('id', explode(',', $deal->products))->take(5)->latest()->get();
                return view('web.products', compact('products', 'totalProducts', 'offset',
                    'loading_limit', 'parentCategories', 'colors', 'seo_data', 'banner',
                    'type', 'typeValue', 'latestProducts', 'sort_value', 'title'));
            } else {
                return view('web.404');
            }
        } else {
            return view('web.404');
        }
    }

    public function main_search(Request $request)
    {
        // $searchResult = array();
        // $products = Product::active()->where('title', 'LIKE', "%{$request->search_param}%")->get();


        $searchResult = array();

                $categories = Category::active()->where('title', 'LIKE', "%{$request->search_param}%")->get();
                $tags = Tag::active()->where('title', 'LIKE', "%{$request->search_param}%")->get();
                $shapes = Shape::active()->where('title', 'LIKE', "%{$request->search_param}%")->get();
                $colors = Color::active()->where('title', 'LIKE', "%{$request->search_param}%")->get();
                $categoryIds = implode('', $categories->pluck('id')->toArray());
                $tagIds = implode('', $tags->pluck('id')->toArray());
                $shapeIds = implode('', $shapes->pluck('id')->toArray());
                $colorIds = implode('', $colors->pluck('id')->toArray());
                $products = Product::active()->where('copy','no')
                    ->where(function ($query) use ($categoryIds, $tagIds,$shapeIds,$colorIds,$request) {
                        $query->orWhere('title', 'LIKE', "%{$request->search_param}%");
                        if ($categoryIds) {
                            $query->orWhereRaw('CONCAT(",", `category_id`, ",") REGEXP ",(' . $categoryIds . '),"');
                            $query->orWhereRaw('CONCAT(",", `sub_category_id`, ",") REGEXP ",(' . $categoryIds . '),"');
                        }
                        if ($tagIds) {

                            $query->orWhereRaw('CONCAT(",", `tag_id`, ",") REGEXP ",(' . $tagIds . '),"');
                        }
                        if ($shapeIds) {

                            $query->orWhereRaw('CONCAT(",", `tag_id`, ",") REGEXP ",(' . $shapeIds . '),"');
                        }
                        if ($colorIds) {

                            $query->orWhereRaw('CONCAT(",", `tag_id`, ",") REGEXP ",(' . $colorIds . '),"');
                        }
                    })->get();
        if ($products->isNotEmpty()) {
            foreach ($products as $product) {
                if (Helper::offerPrice($product->id) != '') {
                    $offerPrice = Helper::offerPrice($product->id);
                    $price = Helper::defaultCurrency() . ' ' . Helper::defaultCurrencyRate() * $product->productprice->id;
                } else {
                    $price = Helper::defaultCurrency() . ' ' . Helper::defaultCurrencyRate() * $product->productprice->price;
                }
                $searchResult[] = array("id" => $product->id, "title" => $product->title, 'price' => $price, 'offer_price' => $offerPrice ?? '', 'image' => ($product->thumbnail_image != NULL && File::exists(public_path($product->thumbnail_image))) ? asset($product->thumbnail_image) : asset('frontend/images/default-image.jpg'), 'link' => url('product/' . $product->short_url));
            }
        }
        return response()->json(['status' => true, 'message' => $searchResult]);
    }


    public function main_search_products($search_param)
    {
       
        //if $search_param have slash remove it
        $search_param = str_replace('/', '', $search_param);
   
        $condition = Product::active()->where('title', 'LIKE', "%{$search_param}%")->where('copy','no');
        $totalProducts = $condition->count();
        $products = $condition->latest()->take(30)->get();
        $parentCategories = Category::active()->isParent()->get();
        $colors = Color::active()->oldest('title')->get();
        $colors = Color::active()->get();
        $offset = $products->count();
        $loading_limit = 15;
        $type = "search_result";
        $typeValue = $search_param;
        
        $shapes = Shape::active()->orderBy('sort_order','asc')->get();
      
        $shapescount = count($shapes);
        $tags = Tag::orderBy('sort_order')->get();
        $banner = Banner::type('search')->first();
        $sort_value = 'latest';
        $title = 'Search result of ' . $search_param;
        $latestProducts = Product::active()->take(5)->latest()->get();
        return view('web.products', compact('products', 'totalProducts', 'offset',
            'loading_limit', 'parentCategories', 'colors', 'colors',
            'type', 'typeValue', 'latestProducts', 'sort_value', 'title', 'banner','shapes','tags','shapescount'));
    }

    public function product_detail($short_url)
    {
        $product = Product::active()->shortUrl($short_url)->with('activeGalleries')->first();
        if ($product) {
            Helper::addRecentProduct($product);
            $products = Product::active()->where('title',$product->title)->with('activeGalleries')->get();
            $productTypeIds = $products->pluck('product_type_id')->toArray();
            $productTypes = ProductType::whereIn('id',$productTypeIds)->active()->get();

       
            $banner = $seo_data = $product;
            $addOns = Product::active()->whereIn('id', explode(',', $product->add_on_id))->latest()->get();
            $similarProducts = Product::active()->whereIn('id', explode(',', $product->similar_product_id))
            ->where('copy','no')->latest()->get();
            
            if($similarProducts->isNotEmpty()){
                $similarProducts = Product::active()->whereIn('id', explode(',', $product->similar_product_id))
                ->where('copy','no')->latest()->get();
            }else{
                $product = Product::active()->where('short_url', $short_url)->first();
                $productTags = Tag::active()->whereIn('id', explode(',', $product->tag_id))->latest()->get();
               $tagIDs = $productTags->pluck('id')->toArray();
                $similarProducts = Product::active()->whereIn('tag_id',  $tagIDs)->where('copy','no')->whereNotIn('id',[$product->id])->latest()->get();
          
 

                    // $similarProducts = Product::active()->whereIn('tag_id',  [1])->where('copy','no')->whereNotIn('id',[$product->id])->latest()->get();
            }
          
            $relatedProducts = Product::active()->whereIn('id', explode(',', $product->related_product_id))
            ->where('copy','no')
            ->latest()->get();
            if($relatedProducts->isNotEmpty()){
                $relatedProducts = Product::active()->whereIn('id', explode(',', $product->related_product_id))->whereNotIn('id',[$product->id])->where('copy','no')->latest()->get();
            }else{
                $product = Product::active()->where('short_url', $short_url)->first();
                $cateid = explode(',', $product->category_id);

                    $relatedProducts = Product::active()->whereIn('category_id', $cateid)->where('copy','no')->whereNotIn('id',[$product->id])->latest()->get();
            }
            
            $productTags = Tag::active()->whereIn('id', explode(',', $product->tag_id))->latest()->get();
            $specifications = ProductSpecificationHead::active()->with('specifications')
                ->where('product_id', $product->id)->orderby('sort_order')->get();
            $averageRatings = Helper::averageRating($product->id);
           
            $totalRatings = Helper::ratingCount($product->id);
         
            $totalReviews = Helper::reviewCount($product->id);
            $reviews = $product->activeReviews->take(100);
            $review_offset = $reviews->count();
            $starPercent1 = $totalReviews > 0 ? round(Helper::ratingCount($product->id, 1) * 100 / $totalReviews) : 0;
            $starPercent2 = $totalReviews > 0 ? round(Helper::ratingCount($product->id, 2) * 100 / $totalReviews) : 0;
            $starPercent3 = $totalReviews > 0 ? round(Helper::ratingCount($product->id, 3) * 100 / $totalReviews) : 0;
            $starPercent4 = $totalReviews > 0 ? round(Helper::ratingCount($product->id, 4) * 100 / $totalReviews) : 0;
            $starPercent5 = $totalReviews > 0 ? round(Helper::ratingCount($product->id, 5) * 100 / $totalReviews) : 0;
                $ratings = ProductReview::where('product_id',$product->id)->get();
                $bestRating = $ratings->max("rating");

                return view('web.product-detail', compact('seo_data', 'product', 'addOns', 'similarProducts','productTypes','products',
                'relatedProducts', 'productTags', 'starPercent1', 'starPercent2', 'starPercent3', 'starPercent4','totalRatings', 'reviews', 'review_offset',
                'starPercent5', 'totalReviews', 'averageRatings', 'banner', 'specifications','bestRating'));


        } else {
            return view('web.404');
        }


    }

    public function check_price(){
        $size = request()->id;
        $product_id = request()->product_id;

        $productOffer = Offer::where([['status', 'Active'], ['product_id', $product_id], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
        if($productOffer){
            $productPrice = ProductPrice::where('product_id',$product_id)->where('size_id',$size)->first();
            $productPrice =  Helper::defaultCurrency().' '.number_format($productPrice->price * Helper::defaultCurrencyRate(), 2);
            if(Helper::offerPriceSize($product_id,$size,$productOffer->id)){
                $offerPrice =   Helper::defaultCurrency().' '.Helper::offerPriceSize($product_id,$size,$productOffer->id);
            }
            else
            {
                $offerPrice = null;
            }
        //return` offer price and product price
        $product = ProductPrice::where('product_id',$product_id)->where('size_id',$size)->first();
        return response(array('offerPrice' => $offerPrice, 'productPrice' => $productPrice,'availabilty' => $product->availability));

        }
        else{
               $product_price = ProductPrice::where('product_id',request()->product_id)->where('size_id',request()->id)->first();

              $productPrice =  Helper::defaultCurrency().' '.number_format($product_price->price * Helper::defaultCurrencyRate(), 2);

              $product = ProductPrice::where('product_id',$product_id)->where('size_id',$size)->first();
              return response(array('productPrice' => $productPrice,'availabilty' => $product->availability));
        }

    }
    public function filter_product(Request $request)
    {



        $condition = $this->filterCondition($request);
        $condition = $this->sortCondition($request, $condition);
        $totalProducts = $condition->count();
        $sort_value = $request->sort_value;
        if (isset($sort_value) && $sort_value == 'none') {
            $products = $condition->take(12)->orderBy('id','desc')->get();
        } else {
            $products = $condition->take(12)->orderBy('id','desc')->get();



        }
        $offset = $products->count();
        $title = 'Filtered Products';
        $type = $request->pageType;
       $typeValue = $request->typeValue;
       $shapes = Shape::latest()->get();
       $shapescount = count($shapes);


        return view('web.includes.product_list', compact('products', 'totalProducts', 'offset',
            'title', 'type', 'typeValue', 'sort_value','shapescount'));
    }

    public function filterCondition(Request $request)
    {

     $currency = Helper::defaultCurrency();

    //    return $request->my_range;

        //  $price_range = explode('-', str_replace('AED', '', $request->my_range));

        $price_range = explode('-', str_replace('AED', '', $request->my_range));




 


         if (!empty($price_range)) {


    //      $dcurrencyrate = Helper::defaultCurrencyRate();
        

    //    $initialvalue =  $price_range[0];
      

    //     $finalvalue=  $price_range[1];

    //     $a =  $initialvalue/$dcurrencyrate;

    //     $b = $finalvalue/$dcurrencyrate;

    //    $firstprice = (round($a));

    //    $secondprice = (round($b));


    //    $priceranges=[$firstprice,$secondprice];
      
   


     
      
             $condition = Product::active()->whereHas('productprices', function($query) use($price_range){
                $query->whereBetween('products_size_price.price', [$price_range[0], $price_range[1]]);
               
                
             })->where('products.copy','no');
         }

         else{

            $condition = Product::active()->where('copy','no');



         }




        $inputs = [];
        if ($request->input_field != NULL) {
            $inputs = explode(',', $request->input_field);
        }



        if ($request->pageType == "category" && !in_array('category_id', $inputs)) {
            $category = Category::active()->where('short_url', $request->typeValue)->first();
            if ($category) {

  

                if($request->category_id){
                    if(in_array($category->id, $request->category_id)) {
                        $subCategoryIds = implode('|', ((collect($category->id)->merge(Helper::get_all_sub_categories($category->id)->pluck('id')))->toArray()));
                        $condition = $condition->whereRaw("(FIND_IN_SET('" . $category->id . "',products.category_id)")->orwhereRaw('CONCAT(",", products.sub_category_id, ",") REGEXP ",(' . $subCategoryIds . '),")');
                    }
                }
                if($request->sub_category_id){
                    if(in_array($category->id, $request->sub_category_id)) {
                        $subCategoryIds = implode('|', ((collect($category->id)->merge(Helper::get_all_sub_categories($category->id)->pluck('id')))->toArray()));
                        $condition = $condition->whereRaw("(FIND_IN_SET('" . $category->id . "',products.category_id)")->orwhereRaw('CONCAT(",", products.sub_category_id, ",") REGEXP ",(' . $subCategoryIds . '),")');
                    }
                }
          

        }
        } elseif ($request->pageType == "search_result") {
            $condition = $condition->Where('title', 'like', '%' . $request->typeValue . '%');
        } elseif ($request->pageType == "deal") {
            $deal = Deal::where([['short_url', $request->typeValue], ['status', 'Active']])->first();
            if ($deal) {
                $condition = $condition->whereIn('id', explode(',', $deal->products));
            }
        }


        //color filtering
        if ($request->input_field != NULL) {
            $condition = $condition->where(function ($mainquery) use ($inputs, $request) {
                {
                    foreach ($inputs as $input) {
                        if ($input == "category_id" || $input == "sub_category_id") {
                            $mainquery->where(function ($query) use ($inputs, $request, $input) {
                                foreach ($request[$input] as $key => $reIn) {
                                    $query->OrwhereRaw("find_in_set('" . $reIn . "', products." . "$input)");
                                }
                            });
                         }
                        //  (and(category=portrait or category=landscape)and(color=green or color=red))
                         else if ($input == "color_id") {
                            $mainquery->where(function ($query) use ($inputs, $request, $input) {
                               
                                foreach ($request[$input] as $key => $reIn) {
                                    $query->OrwhereRaw("find_in_set('" . $reIn . "', products." . "$input)");
                                }
                            });
                         }
                         else if ($input == "shape_id") {
                            $mainquery->where(function ($query) use ($inputs, $request, $input) {
                                foreach ($request[$input] as $key => $reIn) {
                                    $query->OrwhereRaw("find_in_set('" . $reIn . "', products." . "$input)");
                                }
                            });
                         }
                         else if ($input == "tag_id") {
                            $mainquery->where(function ($query) use ($inputs, $request, $input) {
                                foreach ($request[$input] as $key => $reIn) {
                                    $query->OrwhereRaw("find_in_set('" . $reIn . "', products." . "$input)");
                                }
                            });
                         }
                         else {
                            $query->whereIn($input, $request[$input]);
                        }
                    }
                }
            });
        }
        return $condition;
    }

    public function sortCondition(Request $request, $condition)
    {
        //Sorting
        $sort_value = $request->sort_value;
        if ($sort_value == "new") {
            $condition = $condition->where('new_arrival','Yes');
        } elseif ($sort_value == "featured") {
            $condition = $condition->where('is_featured','Yes');
        } elseif ($sort_value == "best") {
            $condition = $condition->where('best_seller','Yes');
        } elseif ($sort_value == "asc") {
            $condition = $condition->oldest('title');
        } elseif ($sort_value == "desc") {
            $condition = $condition->latest('title');
        }
        return $condition;
    }

    public function productLoadMore(Request $request)
    {
        dd($request->all());
        $offset = $request->loading_offset;
       
        $loading_limit = $request->loading_limit;
        $condition = $this->filterCondition($request);
        $condition = $this->sortCondition($request, $condition);
        $totalProducts = $condition->count();
        $products = $condition->latest()->skip($offset)->take($loading_limit)->get();
        $offset += $products->count();
        $offset1 = $offset;
        $title = $request->title;
        $type = $request->pageType;
        $typeValue = $request->typeValue;
        $sort_value = $request->sort_value;
        $latestProducts = Product::active()->take(6)->latest()->get();
        return view('web.includes.product_list_inner', compact('products', 'totalProducts', 'offset',
            'title', 'type', 'typeValue', 'sort_value', 'latestProducts'));
    }
    public function reviewLoadMore(Request $request)
    {
        $product = Product::active()->where('id', $request->product_id)->first();
        $review_offset = $request->review_offset;
        $reviews = $product->activeReviews;
        $totalRatings = $reviews->count();
        $reviews = $reviews->skip($review_offset)->take(3);
        $review_offset += $reviews->count();

        return view('web.includes._review_inner', compact('reviews', 'totalRatings', 'review_offset'));
    }


    public function add_compare_product(Request $request)
    {
        $compare = Helper::addCompareProduct($request->product_id);
        if ($compare == 'added') {
            $message = 'Product Added to Compare.';
        } else {
            $message = 'Product Removed form compare.';
        }
        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function compare_products()
    {
        $banner = Banner::type('compare')->first();
        $seo_data = $this->seo_content('compare');
        $products = collect();
        if (Session::has('compare_products')) {
            $compare_products = Session::get('compare_products');
            $products = Product::whereIn('id', $compare_products)->get();

        }
        return view('web.compare-products', compact('seo_data', 'banner', 'products'));
    }

    // public function submit_review(Request $request)
    // {
    //     if (Auth::guard('customer')->check()) {
    //         $request->validate([
    //             'rating' => 'required',
    //         ]);
    //         $email = Auth::guard('customer')->user()->email;
    //         $name = Helper::loggedCustomerName();
    //     } else {
    //         $request->validate([
    //             'rating' => 'required',
    //             'email' => 'required|email',
    //             'designation' => 'required',
    //             'name' => 'required',
    //             'message' => 'required',
    //         ]);
    //         $email = $request->email;
    //         $name = $request->name;
    //     }
    //     $review = new ProductReview();
    //     $review->email = $email;
    //     $review->name = $name;
    //     $review->rating = round($request->rating);
    //     $review->review = $request->review;
    //     $review->product_id = $request->product_id;
    //     if ($review->save()) {
    //         return response()->json(['status' => 'success-reload', 'message' => 'Review successfully posted']);
    //     } else {
    //         return response()->json(['status' => 'error', 'type' => 'error', 'message' => 'Error while submit the review']);
    //     }
    // }

    public function product_review(Request $request)
    {

       
        if (Auth::guard('customer')->check()) {
            $request->validate([
                
                'rating' => 'required',
                'message' => 'required',
            ]);
            $email = Auth::guard('customer')->user()->email;
            $name = Helper::loggedCustomerName();
        } else {

            $request->validate([
                'rating' => 'required',
                'email' => 'required|email:rfc,dns',
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'message' => 'required',
            ]);
            $email = $request->email;
            $name = $request->name;
        }
        $review = new ProductReview();
        $review->email = $email;
        $review->name = $name;
        $review->rating = round($request->rating);
        $review->review = $request->message;
        $review->product_id = $request->product_id;
        if ($review->save()) {
            return response()->json(['status' => 'success-reload', 'message' => 'Review successfully posted']);
        } else {
            return response()->json(['status' => 'error', 'type' => 'error', 'message' => 'Error while submit the review']);
        }
    }
    public function submit_review(Request $request)
    {
        // dd($request->all());
        if (Auth::guard('customer')->check()) {
            $request->validate([
                'rating' => 'required',
            ]);
            $email = Auth::guard('customer')->user()->email;
            $name = Helper::loggedCustomerName();
        } else {
            $request->validate([
                'rating' => 'required',
                'email' => 'required|email',
                // 'designation' => 'required',
                'name' => 'required',
                'message' => 'required',
            ]);
            $email = $request->email;
            $name = $request->name;
        }
        $testimonial = new Testimonial();
        $testimonial->email = $email;
        $testimonial->name = $name;
        $testimonial->rating = round($request->rating);
        $testimonial->designation = $request->designation;
        $testimonial->message = '<p>'.$request->message.'</p>';
        $testimonial->user_type = "Customer";
        $testimonial->status = "Inactive";
        //$testimonial->review = $request->review;
        // $testimonial->product_id = $request->product_id;
        if ($testimonial->save()) {
            return response()->json(['status' => 'true', 'message' => 'Review successfully posted']);
        } else {
            return response()->json(['status' => 'error', 'type' => 'error', 'message' => 'Error while submit the review']);
        }
    }

    public function newsletter(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email',
        ]);
        $existEntry = Newsletter::where('email', $validatedData['email'])->count();
        if ($existEntry == 0) {
            $contact = new Newsletter;
            $contact->email = $validatedData['email'];
            if ($contact->save()) {
                return response()->json(['status' => 'success', 'message' => 'Newsletter subscribed successfully']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Error while submit the request']);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => '"' . $request->email . '" already subscribed']);
        }
    }

    public function disclaimer()
    {
        $seo_data = $this->seo_content('Disclaimer');
        $banner = Banner::type('disclaimer')->first();
        $field = 'disclaimer';
        return view('web.policy', compact('banner', 'seo_data', 'field'));
    }

    public function privacy_policy()
    {
        $seo_data = $this->seo_content('Privacy Policy');
        $banner = Banner::type('privacy-policy')->first();
        $field = 'privacy_policy';
        $title = 'Privacy Policy';
        return view('web.policy', compact('banner', 'seo_data', 'field', 'title'));
    }

    public function return_policy()
    {
        $seo_data = $this->seo_content('Return Policy');
        $banner = Banner::type('return-policy')->first();
        $field = 'return_policy';
        $title = 'return policy';
        return view('web.policy', compact('banner', 'seo_data', 'field','title'));
    }

    public function shipping_policy()
    {
        $seo_data = $this->seo_content('Shipping Policy');
        $banner = Banner::type('shipping-policy')->first();
        $field = 'shipping_policy';
        $title = 'shipping policy';
        return view('web.policy', compact('banner', 'seo_data', 'field','title'));
    }
    public function payment_policy()
    {
        $seo_data = $this->seo_content('payment Policy');
        $banner = Banner::type('payment-policy')->first();
        $field = 'payment_policy';
        $title = 'Payment Policy';
        return view('web.policy', compact('banner', 'seo_data', 'field','title'));
    }
    public function terms_and_conditions()
    {
        $seo_data = $this->seo_content('Terms and Conditions');

        $banner = Banner::type('terms-and-conditions')->first();
        $field = 'terms_and_conditions';
        $title = 'Terms and Conditions';
        return view('web.policy', compact('banner', 'seo_data', 'field', 'title'));
    }

    public function faq()
    {
        $seo_data = $this->seo_content('faq');

         $banner = Banner::type('faq')->first();
        $field = 'faq';
        $title = 'faq';
        return view('web.policy', compact('banner', 'seo_data', 'field', 'title'));
    }
    public function currency_set(Request $request)
    {
        if ($request->currency) {
            $changed = false;
            $currency = Currency::where('code', $request->currency)->first();
            $defaultCurrency = Currency::where('is_default', 1)->first();
            $currencyRate = CurrencyRate::where([['other_currency_id', $currency->id], ['currency_id', $defaultCurrency->id]])->first();
            if ($request->currency == $defaultCurrency->code) {
                session(['currency_rate' => '1']);
                session(['currency' => $defaultCurrency->code]);
                $currencyRate = 1;
                $changed = true;
            } else {
                if ($currencyRate != NULL) {
                    session(['currency_rate' => $currencyRate->conversion_rate]);
                    session(['currency' => $currency->code]);
                    $currencyRate = $currencyRate->conversion_rate;
                    $changed = true;


                    $updatecurrency = Currency::where('id',$currency->id)
                      ->update(['is_default' =>1
                    ]);

                   $data[]= $currency->id;

                    $updatecurrencys = Currency::whereNotIn('id',$data)
                    ->update(['is_default' =>0
                  ]);



                } else {
                    return response(array(
                        'status' => false,
                        'message' => 'Currency rate not fixed yet..!',
                    ), 200, []);
                }
            }
            if ($changed == true) {
                if (Session::has('session_key')) {
                    $sessionKey = session('session_key');
                    if (!Cart::session($sessionKey)->isEmpty()) {
                        
                        if (Session::has('currency')) {
                            $currency_rate = session('currency_rate');
                        } else {
                            $currency_rate = 1;
                        }
                        foreach (Cart::session($sessionKey)->getContent() as $row) {
                        
                            $product = Product::find($row->attributes['product_id']);
                            if (Helper::offerPrice($product->id) != '') {
                                $productOffer = Offer::where('product_id',$product->id)->where('status','Active')->first();
                                $offer_amount = Helper::offerPriceSize($product->id,$product->size,$productOffer->id);
                                if($offer_amount != null){
                                   
                                    $offer_id = Helper::offerId($product->id);
                                    $product_price =  $offer_amount;
                                }
                                else{
                                    $offer_amount = '0.00';
                                    $offer_id = '0';
                                    $product_price = $product->price;
                                }
                            } else {
                                $offer_amount = '0.00';
                                $offer_id = '0';
                                $product_price = $product->price;
                            }
                            \Cart::session(session('session_key'))->update($row->id, [
                                'price' => $currencyRate * $product_price,
                            ]);
                            // echo $row->attributes->base_price*$currencyRate."<br/>";
                        }
                    }
                        if (Session::has('currency')) {
                            $currency_rate = session('currency_rate');
                        } else {
                            $currency_rate = 1;
                        }


                }
                // if (Session::has('coupon_base_value')) {
                //     $coupon_value = session('coupon_base_value') * $currencyRate;
                //     session(['coupon_value' => $coupon_value]);
                // }
                return response(array(
                    'status' => true,
                    'message' => "Currency changed to '" . $currency->code . "'",
                ), 200, []);
            } else {
                return response(array(
                    'status' => false,
                    'message' => 'Error while changing the currency',
                ), 200, []);
            }
        } else {
            return response(array(
                'status' => false,
                'message' => 'Currency input not found',
            ), 200, []);
        }
    }

}
