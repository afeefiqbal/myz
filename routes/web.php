<?php

use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\AdministrationController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CurrencyController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DealController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\OfferStripController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SiteInformationController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Web\Auth\LoginController as CustomerLoginController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\CustomerController as CustomerWebController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\VendorController;
use App\Http\Helpers\Helper;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Route;
use PHPUnit\TextUI\Help;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['web'])->group(function () {
    Route::get('/', [WebController::class, 'home'])->name('/');

    Route::get('product-details',function(){
        return view('web.product-details');
    });
    Route::get('/invoice',function(){
        $order = \App\Models\Order::find(1);
       Helper::sendOrderPlacedMail($order,'0');
    });

    Route::post('sitemap', [SitemapController::class, 'generate'])->name('sitemap.generate');

    Route::get('handle-payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment-success');
    Route::get('handle-payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment-cancel');
    Route::get('handle-payment/declined', [PaymentController::class, 'paymentDeclined'])->name('payment-declined');

    Route::get('about', [WebController::class, 'about']);
    Route::post('currency_set', [WebController::class, 'currency_set']);
    Route::get('testimonials', [WebController::class, 'testimonials']);
    Route::post('testimonial-load-more', [WebController::class, 'testimonialLoadMore']);
    Route::get('blogs', [WebController::class, 'blogs']);
    Route::post('blog-load-more', [WebController::class, 'blogLoadMore']);
    Route::get('blog/{short_url}', [WebController::class, 'blog_detail']);
    Route::post('booking', [WebController::class, 'booking']);
    Route::get('contact', [WebController::class, 'contact']);
    Route::post('enquiry', [WebController::class, 'enquiry_store']);
    Route::get('faq', [WebController::class, 'faq']);
    Route::get('brand/{url}', [WebController::class, 'brand']);
    Route::get('deal/{url}', [WebController::class, 'deal']);
    Route::get('products', [WebController::class, 'products']);
    Route::get('product/{short_url}', [WebController::class, 'product_detail']);
    // Route::get('product/{short_url}/{type_id}', [WebController::class, 'product_detail_type']);
    Route::post('product/check-price', [WebController::class, 'check_price']);

    Route::get('category/{short_url}', [WebController::class, 'category']);
    Route::get('shape/{short_url}', [WebController::class, 'shape']);
    Route::get('color/{short_url}', [WebController::class, 'color']);
    Route::get('latest-products', [WebController::class, 'latest_products']);
    Route::get('popular-products', [WebController::class, 'popular_products']);
    Route::get('most-relevent-products', [WebController::class, 'most_relevent_products']);
    Route::post('newsletter', [WebController::class, 'newsletter']);
    Route::post('filter-product', [WebController::class, 'filter_product']);
    Route::post('product-load-more', [WebController::class, 'productLoadMore']);
    Route::post('review-load-more', [WebController::class, 'reviewLoadMore']);
    Route::post('main-search', [WebController::class, 'main_search']);
    Route::get('search/{search_param}', [WebController::class, 'main_search_products'])->where('search_param', '.*');;
    Route::post('submit-review', [WebController::class, 'submit_review']);
    Route::post('product-review', [WebController::class, 'product_review']);
    Route::get('service/{short_url}', [WebController::class, 'service_detail']);
    Route::get('team', [WebController::class, 'team']);
    Route::get('payment-failed/{order_id}', [CartController::class,'payment_failed']);
    Route::get('payment-cancelled/{order_id}', [CartController::class,'payment_cancelled']);
    Route::post('team-load-more', [WebController::class, 'teamLoadMore']);
    Route::get('team-detail/{id}', [WebController::class, 'teamDetail']);
    Route::get('events', [WebController::class, 'events']);
    Route::post('update-customer-shipping-address',[CartController::class,'update_customer_shipping_address']);

    /********************* Policies *******************/
    Route::get('disclaimer', [WebController::class, 'disclaimer']);
    Route::get('privacy-policy', [WebController::class, 'privacy_policy']);
    Route::get('return-policy', [WebController::class, 'return_policy']);
    Route::get('shipping-policy', [WebController::class, 'shipping_policy']);
    Route::get('terms-and-conditions', [WebController::class, 'terms_and_conditions']);
    Route::get('faq', [WebController::class, 'faq']);
    Route::get('payment-policy', [WebController::class, 'payment_policy']);


    /********************* Authentication URLs *******************/
    Route::get('login', [CustomerLoginController::class, 'login_form']);
    Route::post('login', [CustomerLoginController::class, 'login']);
    Route::get('logout', [CustomerLoginController::class, 'logout']);
    Route::get('register', [CustomerLoginController::class, 'register_form']);
    Route::post('register', [CustomerLoginController::class, 'register']);
    Route::get('forgot-password', [CustomerLoginController::class, 'forgot_password_form']);
    Route::post('forgot-password', [CustomerLoginController::class, 'forgot_password']);
    Route::get('reset-password/{token}', [CustomerLoginController::class, 'reset_password']);
    Route::post('reset-password/{token}', [CustomerLoginController::class, 'reset_password_store']);
    Route::get('email-verification/{token}', [CustomerLoginController::class, 'email_verification']);
    // Route::get('email-verification-success/{token}', [CustomerLoginController::class, 'email_verification_store']);
    Route::post('resend', [CustomerLoginController::class, 'resend']);



    /********************* Social Authentication URLs *******************/
    Route::prefix('auth')->group(function () {
        Route::get('google', [CustomerLoginController::class, 'redirectToGoogle']);
        Route::get('google/callback', [CustomerLoginController::class, 'handleGoogleCallback']);
        Route::get('facebook', [CustomerLoginController::class, 'redirectToFacebook']);
        Route::get('facebook/callback', [CustomerLoginController::class, 'handleFacebookCallback']);
    });


    /******************************* Cart functions *************************************/
    Route::get('cart', [CartController::class, 'cart']);
    Route::post('add-wishlist', [CartController::class, 'add_to_wish_list']);
    Route::post('add-cart', [CartController::class, 'add_to_cart']);
    Route::get('side-cart', [CartController::class, 'side_cart']);
    Route::post('open-cart-modal', [CartController::class, 'open_cart_modal']);
    Route::post('open-cart-modal', [CartController::class, 'open_cart_modal']);
    Route::post('update-item-quantity', [CartController::class, 'update_item_quantity']);
    Route::post('apply-coupon', [CartController::class, 'apply_coupon']);
    Route::post('get-calc-value', [CartController::class, 'get_calc_value']);
    Route::get('checkout', [CartController::class, 'checkout']);
    Route::post('select-customer-address', [CartController::class, 'select_customer_address']);
    Route::post('select-customer-billing-address', [CartController::class,'select_customer_billing_address']);
    Route::post('different-shipping-address', [CartController::class, 'different_shipping_address']);
    Route::post('billing-address-store', [CartController::class, 'billing_address_store']);
    Route::post('customer/state-list', [CountryController::class,'state_list']);
    Route::post('add-order-remarks', [CartController::class, 'add_order_remarks']);
    Route::post('change-location', [CartController::class, 'change_location']);
    Route::post('remove-cart-item', [CartController::class, 'remove_cart_item']);
    Route::get('check-out-button', [CartController::class, 'check_out_button']);
    Route::post('cancel_all', [OrderController::class, 'cancel_all']);

    Route::post('submit-order-by-cod',[CartController::class,'submit_order_by_cod']);
    Route::post('state-list', [CartController::class, 'state_list']);
    Route::post('b-state-list', [CartController::class, 'b_state_list']);
    Route::post('submit-order', [CartController::class, 'submit_order']);
    Route::post('cod-charge-apply', [CartController::class, 'cod_charge_apply']);
    Route::post('cancel-order', [CartController::class, 'cancel_order']);
    Route::post('return-order', [CartController::class, 'return_order']);
    Route::post('apply-coupon', [CartController::class, 'apply_coupon']);
    Route::post('remove-coupon', [CartController::class, 'remove_coupon']);
    Route::get('response/{order_id}', [CartController::class, 'response']);
    Route::get('order/{order_code}', [CartController::class, 'order_detail']);
});
/******************************* Cart functions *************************************/

Route::get('/product-main-contents-excel', [ProductController::class,'product_main_content_excel']);
Route::get('/default-product-main-contents-excel', [ProductController::class,'default_product_main_content_excel']);
/******************************** Customer Routes ************************************/
Route::group(['prefix' => 'customer', 'middleware' => 'auth:customer'], function () {
    Route::get('account/{tab}', [CustomerWebController::class, 'account']);
    Route::post('update-profile', [CustomerWebController::class, 'update_profile']);
    Route::post('change-password', [CustomerWebController::class, 'change_password_store']);
    Route::post('profile-image', [CustomerWebController::class, 'profile_image_upload']);

    Route::post('address-form', [CustomerWebController::class, 'address_form']);
    Route::post('update-customer-address', [CustomerWebController::class, 'createAddress']);
    Route::post('delete-address', [CustomerWebController::class, 'delete_address']);

    Route::post('set-default-address', [CustomerWebController::class, 'set_default_address']);


});
Route::group(['prefix' => 'customer'], function () {
    Route::post('add-address', [CustomerWebController::class, 'createAddress']);
});

/******************************** Payment Routes ************************************/
Route::group(['prefix' => 'payment'], function () {
    Route::get('/success',  [PaymentController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/failure',  [PaymentController::class, 'paymentDeclined'])->name('payment.failure');    
    // Route::get('/{order}', [PaymentController::class, 'charge'])->name('goToPayment');
    Route::post('/process', [PaymentController::class, 'processPayment'])->name('processPayment');
    // Route::get('/payment/process', 'Web\PaymentController@processPayment')->name('payment.process');
});

/******************************** Admin Panel Routes ************************************/

//if route is admin redirect to external website admin panel
Route::get('admin', function () {
    return redirect('http://admin.example.com');
});


Route::prefix('admin')->group(function () {


    //redirect to another website

    Route::get('/', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
    Route::post('/', [LoginController::class, 'login']);
    Route::post('forgot-password', [LoginController::class, 'forgot_password']);
    Route::get('reset-password/{token}', [LoginController::class, 'reset_password']);
    Route::post('reset-password/{token}', [LoginController::class, 'reset_password_store']);

});


Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [HomeController::class, 'admin_dashboard']);
    Route::get('logout', [LoginController::class, 'logout']);


    /******************************** Common Routes ************************************/
    Route::post('home-heading', [HomeController::class, 'update_home_heading']);
    Route::get('home-heading', [HomeController::class, 'create_home_heading']);
    Route::post('status-change', [HomeController::class, 'status_change']);
    Route::post('change-bool-status', [HomeController::class, 'change_bool_status']); 
    Route::post('change-order-status', [HomeController::class, 'change_order_status']);
    Route::post('sort_order/', [HomeController::class, 'sort_order']);
    Route::post('sub-category', [HomeController::class, 'sub_categories']);
    Route::post('sub-category', [HomeController::class, 'sub_categories']);
    Route::post('kv-delete-file', [HomeController::class, 'delete_file']);



    Route::prefix('about')->group(function () {
        Route::get('/', [AboutController::class, 'about']);
        Route::post('/', [AboutController::class, 'about_store']);

        Route::prefix('feature')->group(function () {
            Route::get('/', [AboutController::class, 'feature']);
            Route::get('create', [AboutController::class, 'feature_create']);
            Route::post('create', [AboutController::class, 'feature_store']);
            Route::get('edit/{id}', [AboutController::class, 'feature_edit']);
            Route::post('edit/{id}', [AboutController::class, 'feature_update']);
            Route::post('delete', [AboutController::class, 'delete_feature']);
        });
    });
    Route::prefix('home')->group(function(){
        Route::post('image_process', [HomeController::class, 'imageProcess']);
    });
    Route::prefix('vendor')->group(function () {
        Route::get('/', [VendorController::class, 'admin']);
        Route::get('create', [VendorController::class, 'create']);
        Route::post('create', [VendorController::class, 'store']);
        Route::get('edit/{id}', [VendorController::class, 'edit']);
        Route::post('edit/{id}', [VendorController::class, 'update']);
        Route::post('delete/', [VendorController::class, 'delete']);
        Route::get('reset-password/{id}', [VendorController::class, 'reset_password']);
        Route::post('reset-password/{id}', [VendorController::class, 'reset_password_store']);
        Route::get('profile', [VendorController::class, 'profile']);
        Route::post('profile', [VendorController::class, 'profile_store']);
    });
    Route::prefix('administration')->group(function () {
        Route::get('/', [AdministrationController::class, 'admin']);
        Route::get('create', [AdministrationController::class, 'create']);
        Route::post('create', [AdministrationController::class, 'store']);
        Route::get('edit/{id}', [AdministrationController::class, 'edit']);
        Route::post('edit/{id}', [AdministrationController::class, 'update']);
        Route::post('delete/', [AdministrationController::class, 'delete']);
        Route::get('reset-password/{id}', [AdministrationController::class, 'reset_password']);
        Route::post('reset-password/{id}', [AdministrationController::class, 'reset_password_store']);
        Route::get('profile', [AdministrationController::class, 'profile']);
        Route::post('profile', [AdministrationController::class, 'profile_store']);
    });

    Route::prefix('advertisement')->group(function () {
        Route::get('/{type}', [AdvertisementController::class, 'advertisement']);
        Route::get('create/{type}', [AdvertisementController::class, 'advertisement_create']);
        Route::post('create/{type}', [AdvertisementController::class, 'advertisement_store']);
        Route::get('edit/{id}', [AdvertisementController::class, 'advertisement_edit']);
        Route::post('edit/{id}', [AdvertisementController::class, 'advertisement_update']);
        Route::post('delete', [AdvertisementController::class, 'delete_advertisement']);
    });

    Route::prefix('banner')->group(function () {
        Route::get('/{type}', [BannerController::class, 'banner']);
        Route::post('{type}', [BannerController::class, 'banner_store']);
    });

    Route::prefix('blog')->group(function () {
        Route::get('/', [BlogController::class, 'blog']);
        Route::get('create', [BlogController::class, 'blog_create']);
        Route::post('create', [BlogController::class, 'blog_store']);
        Route::get('edit/{id}', [BlogController::class, 'blog_edit']);
        Route::post('edit/{id}', [BlogController::class, 'blog_update']);
        Route::post('delete', [BlogController::class, 'delete_blog']);
    });

    Route::prefix('bookings')->group(function () {
        Route::get('/', [BookingController::class, 'bookings']);
        Route::get('view/{id}', [BookingController::class, 'bookings_view']);

        Route::prefix('holidays')->group(function () {
            Route::get('/', [BookingController::class, 'holiday_list']);
            Route::get('create', [BookingController::class, 'holiday_create']);
            Route::post('create', [BookingController::class, 'holiday_store']);
            Route::get('edit/{id}', [BookingController::class, 'holiday_edit']);
            Route::post('edit/{id}', [BookingController::class, 'holiday_update']);
            Route::post('delete', [BookingController::class, 'delete_holiday']);
        });

        Route::prefix('questions')->group(function () {
            Route::get('/', [BookingController::class, 'questions_list']);
            Route::get('create', [BookingController::class, 'questions_create']);
            Route::post('create', [BookingController::class, 'questions_store']);
            Route::get('edit/{id}', [BookingController::class, 'questions_edit']);
            Route::post('edit/{id}', [BookingController::class, 'questions_update']);
            Route::post('delete', [BookingController::class, 'delete_questions']);
            Route::post('choice/extra_row', [BookingController::class, 'choice_row']);
            Route::post('choice/remove_extra_row', [BookingController::class, 'remove_choice_row']);

        });

        Route::prefix('time-slots')->group(function () {
            Route::get('/', [BookingController::class, 'time_slot_list']);
            Route::get('create', [BookingController::class, 'time_slot_create']);
            Route::post('create', [BookingController::class, 'time_slot_store']);
            Route::get('edit/{id}', [BookingController::class, 'time_slot_edit']);
            Route::post('edit/{id}', [BookingController::class, 'time_slot_update']);
            Route::post('delete', [BookingController::class, 'delete_time_slot']);
        });
    });

    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', [ContactController::class, 'contact_page']);
        Route::post('/', [ContactController::class, 'contact_page_store']);
    });

    Route::prefix('country')->group(function () {
        Route::get('/', [CountryController::class, 'country']);
        Route::get('create', [CountryController::class, 'country_create']);
        Route::post('create', [CountryController::class, 'country_store']);
        Route::get('edit/{id}', [CountryController::class, 'country_edit']);
        Route::post('edit/{id}', [CountryController::class, 'country_update']);
        Route::post('delete', [CountryController::class, 'delete_country']);

        Route::prefix('state')->group(function () {
            Route::get('{country_id}', [CountryController::class, 'state']);
            Route::get('create/{country_id}', [CountryController::class, 'state_create']);
            Route::post('create/{country_id}', [CountryController::class, 'state_store']);
            Route::get('edit/{id}', [CountryController::class, 'state_edit']);
            Route::post('edit/{id}', [CountryController::class, 'state_update']);
            Route::post('delete', [CountryController::class, 'delete_state']);
            Route::post('state_list', [CountryController::class, 'state_list']);
        });

        Route::prefix('shipping-charge')->group(function () {
            Route::get('/', [CountryController::class, 'shipping_list']);
            Route::get('create', [CountryController::class, 'shipping_create']);
            Route::post('create', [CountryController::class, 'shipping_store']);
            Route::get('edit/{id}', [CountryController::class, 'shipping_edit']);
            Route::post('edit/{id}', [CountryController::class, 'shipping_update']);
            Route::post('delete', [CountryController::class, 'delete_shipping']);
        });
    });


    Route::prefix('coupon')->group(function () {
        Route::get('/', [CouponController::class, 'coupon']);
        Route::get('create', [CouponController::class, 'coupon_create']);
        Route::post('create', [CouponController::class, 'coupon_store']);
        Route::get('edit/{id}', [CouponController::class, 'coupon_edit']);
        Route::post('edit/{id}', [CouponController::class, 'coupon_update']);
        Route::post('delete', [CouponController::class, 'delete_coupon']);

        Route::post('category-products', [CouponController::class, 'category_products']);
    });

    Route::prefix('currency')->group(function () {
        Route::get('/', [CurrencyController::class, 'currency']);
        Route::get('create', [CurrencyController::class, 'currency_create']);
        Route::post('create', [CurrencyController::class, 'currency_store']);
        Route::get('edit/{id}', [CurrencyController::class, 'currency_edit']);
        Route::post('edit/{id}', [CurrencyController::class, 'currency_update']);
        Route::post('delete', [CurrencyController::class, 'delete_currency']);

        Route::prefix('rate')->group(function () {
            Route::get('create/{currency_id}', [CurrencyController::class, 'currency_rate_create']);
            Route::post('create/{currency_id}', [CurrencyController::class, 'currency_rate_store']);
        });
    });

    Route::prefix('customer')->group(function () {
        Route::get('/', [CustomerController::class, 'customer']);
        Route::get('create', [CustomerController::class, 'customer_create']);
        Route::post('create', [CustomerController::class, 'customer_store']);
        Route::get('edit/{id}', [CustomerController::class, 'customer_edit']);
        Route::post('edit/{id}', [CustomerController::class, 'customer_update']);
        Route::post('delete', [CustomerController::class, 'delete_customer']);

        Route::prefix('address')->group(function () {
            Route::get('{customer_id}', [CustomerController::class, 'address']);
            Route::get('create/{customer_id}', [CustomerController::class, 'address_create']);
            Route::post('create/{customer_id}', [CustomerController::class, 'address_store']);
            Route::get('edit/{id}', [CustomerController::class, 'address_edit']);
            Route::post('edit/{id}', [CustomerController::class, 'address_update']);
            Route::post('delete', [CustomerController::class, 'delete_address']);
        });
    });

    Route::prefix('deal')->group(function () {
        Route::get('/', [DealController::class, 'deal']);
        Route::get('create', [DealController::class, 'deal_create']);
        Route::post('create', [DealController::class, 'deal_store']);
        Route::get('edit/{id}', [DealController::class, 'deal_edit']);
        Route::post('edit/{id}', [DealController::class, 'deal_update']);
        Route::post('delete', [DealController::class, 'delete_deal']);
        Route::post('sub-category', [DealController::class, 'sub_categories']);
        Route::post('product-by-type', [DealController::class, 'product_by_type']);
    });

    Route::prefix('enquiry')->group(function () {
        
        Route::get('/', [EnquiryController::class, 'enquiry_list']);
        Route::get('view/{id}', [EnquiryController::class, 'enquiry_view']);
        Route::post('reply', [EnquiryController::class, 'reply_to_enquiry']);
        Route::post('delete', [EnquiryController::class, 'delete_enquiry']);
        Route::post('delete-multiple', [EnquiryController::class, 'delete_multi_enquiry']);

        Route::prefix('bulk')->group(function () {
            Route::get('/', [EnquiryController::class, 'bulk_list']);
            Route::get('view/{id}', [EnquiryController::class, 'bulk_view']);
            Route::post('reply', [EnquiryController::class, 'reply_to_bulk']);
            Route::post('delete', [EnquiryController::class, 'delete_bulk']);
            Route::post('delete-multiple', [EnquiryController::class, 'delete_multiple_bulk']);
        });
        Route::prefix('product')->group(function () {
            Route::get('/', [EnquiryController::class, 'product_list']);
            Route::get('view/{id}', [EnquiryController::class, 'product_view']);
            Route::post('reply', [EnquiryController::class, 'reply_to_product']);

            Route::post('delete', [EnquiryController::class, 'delete_product']);
            Route::post('delete-multiple', [EnquiryController::class, 'delete_multiple_product']);
        });

        Route::prefix('newsletter')->group(function () {
            Route::get('/', [EnquiryController::class, 'newsletter']);
            Route::post('delete', [EnquiryController::class, 'delete_newsletter']);
            Route::post('delete-multiple', [EnquiryController::class, 'delete_multi_newsletter']);
        });
        Route::post('export', [EnquiryController::class, 'export']);
    });


    Route::prefix('event')->group(function () {

        Route::get('/', [EventController::class, 'event']);
        Route::get('create', [EventController::class, 'event_create']);
        Route::post('create', [EventController::class, 'event_store']);
        Route::get('edit/{id}', [EventController::class, 'event_edit']);
        Route::post('edit/{id}', [EventController::class, 'event_update']);
        Route::post('delete/', [EventController::class, 'delete_event']);

        Route::prefix('type')->group(function () {
            Route::get('/', [EventController::class, 'event_type']);
            Route::get('create', [EventController::class, 'event_type_create']);
            Route::post('create', [EventController::class, 'event_type_store']);
            Route::get('edit/{id}', [EventController::class, 'event_type_edit']);
            Route::post('edit/{id}', [EventController::class, 'event_type_update']);
            Route::post('delete', [EventController::class, 'delete_event_type']);
        });

    });


    Route::prefix('faq')->group(function () {
        Route::get('/', [FAQController::class, 'faq']);
        Route::get('create', [FAQController::class, 'faq_create']);
        Route::post('create', [FAQController::class, 'faq_store']);
        Route::get('edit/{id}', [FAQController::class, 'faq_edit']);
        Route::post('edit/{id}', [FAQController::class, 'faq_update']);
        Route::post('delete/', [FAQController::class, 'delete_faq']);
        Route::post('delete_multiple', [FAQController::class, 'delete_multiple_faq']);
    });

    Route::prefix('guests')->group(function () {
        Route::get('/', [CustomerController::class, 'guests']);
    });

    Route::prefix('home')->group(function () {

        Route::get('/about-us', [AboutController::class, 'home_about_us']);
        Route::post('/about-us', [AboutController::class, 'home_about_us_store']);
        Route::get('/our-collection/create', [HomeController::class, 'ourcollection_create']);
        Route::post('/our-collection/create', [HomeController::class, 'ourcollection_store']);

       

        Route::get('/our-selection/create', [HomeController::class, 'ourselection_create']);
        Route::post('/our-selection/create', [HomeController::class, 'selection_update']);
        Route::post('update', [HomeController::class, 'selection_update'])->name('selection.update');

      

        Route::prefix('banner')->group(function () {
            Route::get('/', [HomeController::class, 'banner']);
            Route::get('create', [HomeController::class, 'banner_create']);
            Route::post('create', [HomeController::class, 'banner_store']);
            Route::get('edit/{id}', [HomeController::class, 'banner_edit']);
            Route::post('edit/{id}', [HomeController::class, 'banner_update']);
            Route::post('delete', [HomeController::class, 'delete_banner']);
            Route::post('banner-type-store', [HomeController::class, 'banner_type_store']);
        });

        Route::prefix('hot-deal')->group(function () {
            Route::get('/', [HomeController::class, 'hot_deals']);
            Route::get('create', [HomeController::class, 'hot_deal_create']);
            Route::post('create', [HomeController::class, 'hot_deal_store']);
            Route::get('edit/{id}', [HomeController::class, 'hot_deal_edit']);
            Route::post('edit/{id}', [HomeController::class, 'hot_deal_update']);
            Route::post('delete/', [HomeController::class, 'delete_hot_deal']);
        });



        Route::prefix('testimonial')->group(function () {
            Route::get('/', [HomeController::class, 'testimonial']);
            Route::get('create', [HomeController::class, 'testimonial_create']);
            Route::post('create', [HomeController::class, 'testimonial_store']);
            Route::get('edit/{id}', [HomeController::class, 'testimonial_edit']);
            Route::post('edit/{id}', [HomeController::class, 'testimonial_update']);
            Route::post('delete', [HomeController::class, 'delete_testimonial']);
        });

        Route::prefix('usertestimonial')->group(function () {
            Route::get('/', [HomeController::class, 'usertestimonial']);
            // Route::get('create', [HomeController::class, 'testimonial_create']);
            // Route::post('create', [HomeController::class, 'testimonial_store']);
            // Route::get('edit/{id}', [HomeController::class, 'testimonial_edit']);
            // Route::post('edit/{id}', [HomeController::class, 'testimonial_update']);
            Route::post('delete', [HomeController::class, 'delete_usertestimonial']);
        });
    });

    Route::prefix('mail')->group(function () {
        Route::get('list', [MailController::class, 'list']);
        Route::get('create', [MailController::class, 'create']);
        Route::post('create', [MailController::class, 'store']);
        Route::post('set_default', [MailController::class, 'set_default']);
        Route::get('edit/{id}', [MailController::class, 'edit']);
        Route::post('edit/{id}', [MailController::class, 'update']);
        Route::post('delete', [MailController::class, 'delete']);
        Route::get('cart', [MailController::class, 'cart']);
        Route::post('cart_notify', [MailController::class, 'cart_notify']);
        Route::post('send-multi-cart-notification', [MailController::class, 'send_multi_cart_notification']);
        Route::post('cart_list_filter', [MailController::class, 'cart_list_filter']);
    });

    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'menu']);
        Route::get('create', [MenuController::class, 'menu_create']);
        Route::post('create', [MenuController::class, 'menu_store']);
        Route::get('edit/{id}', [MenuController::class, 'menu_edit']);
        Route::post('edit/{id}', [MenuController::class, 'menu_update']);
        Route::post('delete', [MenuController::class, 'delete_menu']);
        Route::post('sub-categories', [MenuController::class, 'sub_category_by_menu']);

        Route::prefix('detail')->group(function () {
            Route::get('/', [MenuController::class, 'menu_detail']);
            Route::get('create', [MenuController::class, 'menu_detail_create']);
            Route::post('create', [MenuController::class, 'menu_detail_store']);
            Route::get('edit/{id}', [MenuController::class, 'menu_detail_edit']);
            Route::post('edit/{id}', [MenuController::class, 'menu_detail_update']);
            Route::post('delete', [MenuController::class, 'delete_detail_menu']);
        });
    });
    Route::prefix('side-menu')->group(function () {
        Route::get('/', [MenuController::class, 'side_menu']);
        Route::get('create', [MenuController::class, 'side_menu_create']);
        Route::post('create', [MenuController::class, 'side_menu_store']);
        Route::get('edit/{id}', [MenuController::class, 'side_menu_edit']);
        Route::post('edit/{id}', [MenuController::class, 'side_menu_update']);
        Route::post('delete', [MenuController::class, 'side_delete_menu']);

        Route::prefix('detail')->group(function () {
            Route::get('/', [MenuController::class, 'side_menu_detail']);
            Route::get('create', [MenuController::class, 'side_menu_detail_create']);
            Route::post('create', [MenuController::class, 'side_menu_detail_store']);
            Route::get('edit/{id}', [MenuController::class, 'side_menu_detail_edit']);
            Route::post('edit/{id}', [MenuController::class, 'side_menu_detail_update']);
            Route::post('delete', [MenuController::class, 'side_delete_detail_menu']);
        });
    });

    Route::prefix('order')->group(function () {
        Route::get('/', [OrderController::class, 'list']);
        Route::get('create', [OrderController::class, 'create']);
        Route::get('view/{id}', [OrderController::class, 'order_view']);
        Route::post('order_status', [OrderController::class, 'order_status']);
        Route::post('cancel_all', [OrderController::class, 'cancel_all']);
        Route::post('invoice_resend', [OrderController::class, 'invoice_resend']);
        Route::post('track_order_products/', [OrderController::class, 'track_order_products']);
        Route::post('cancelled_splitup/', [OrderController::class, 'cancelled_splitup']);
        Route::get('print-invoice/{id}', [OrderController::class, 'print_invoice']);

        Route::post('export', [OrderController::class, 'export'])->name('export');
    });

    Route::prefix('offer-strip')->group(function () {
        Route::get('/', [OfferStripController::class, 'offer_strip']);
        Route::get('create', [OfferStripController::class, 'offer_strip_create']);
        Route::post('create', [OfferStripController::class, 'offer_strip_store']);
        Route::get('edit/{id}', [OfferStripController::class, 'offer_strip_edit']);
        Route::post('edit/{id}', [OfferStripController::class, 'offer_strip_update']);
        Route::post('delete', [OfferStripController::class, 'delete_offer_strip']);
    });
    Route::prefix('sitemap_generator')->group(function () {
        Route::get('/', [SitemapController::class, 'index']);
    });
    Route::prefix('home')->group(function () {
        Route::get('/', [HomeController::class, 'index']);
        Route::post('store', [HomeController::class, 'store'])->name('home.store');
    });
    Route::prefix('product')->group(function () {

        Route::get('/', [ProductController::class, 'product']);
        Route::get('create', [ProductController::class, 'product_create']);
        Route::get('detail/{id}', [ProductController::class, 'product_detail']);
        Route::post('create', [ProductController::class, 'product_store']);
        Route::get('edit/{id}', [ProductController::class, 'product_edit']);
        Route::post('edit/{id}', [ProductController::class, 'product_update']);
        Route::post('delete', [ProductController::class, 'delete_product']);
        Route::get('upload-to-google-merchant', [ProductController::class, 'upload_to_google_merchant'])->name('upload-to-google-merchant');
        Route::get('export', [ProductController::class, 'product_export'])->name('export');
        Route::post('import', [ProductController::class, 'product_import'])->name('import');
        Route::get('copy/{id}', [ProductController::class, 'copy_product']);
        Route::post('validate', [HomeController::class, 'product_validate']);

        Route::prefix('category')->group(function () {
            Route::get('/', [CategoryController::class, 'category_list']);
            Route::get('create', [CategoryController::class, 'category_create']);
            Route::post('create', [CategoryController::class, 'category_store']);
            Route::get('edit/{id}', [CategoryController::class, 'category_edit']);
            Route::post('edit/{id}', [CategoryController::class, 'category_update']);
            Route::post('delete', [CategoryController::class, 'delete_category']);
        });


        Route::prefix('sub-category')->group(function () {
            Route::get('/', [CategoryController::class, 'sub_category_list']);
            Route::get('create', [CategoryController::class, 'sub_category_create']);
            Route::post('create', [CategoryController::class, 'sub_category_store']);
            Route::get('edit/{id}', [CategoryController::class, 'sub_category_edit']);
            Route::post('edit/{id}', [CategoryController::class, 'sub_category_update']);
            Route::post('delete', [CategoryController::class, 'delete_sub_category']);
        });


        Route::prefix('color')->group(function () {
            Route::get('/', [AttributeController::class, 'color']);
            Route::get('create', [AttributeController::class, 'color_create']);
            Route::post('create', [AttributeController::class, 'color_store']);
            Route::get('edit/{id}', [AttributeController::class, 'color_edit']);
            Route::post('edit/{id}', [AttributeController::class, 'color_update']);
            Route::post('delete', [AttributeController::class, 'delete_color']);
        });

        Route::prefix('gallery')->group(function () {
            Route::get('/{product_id}', [ProductController::class, 'gallery']);
            Route::get('create/{product_id}', [ProductController::class, 'gallery_create']);
            Route::post('create/{product_id}', [ProductController::class, 'gallery_store']);
            Route::get('edit/{id}', [ProductController::class, 'gallery_edit']);
            Route::post('edit/{id}', [ProductController::class, 'gallery_update']);
            Route::post('delete', [ProductController::class, 'delete_gallery']);
        });



        Route::prefix('offer')->group(function () {
            Route::get('/{product_id}', [ProductController::class, 'offer']);
            Route::get('create/{product_id}', [ProductController::class, 'offer_create']);
            Route::post('create/{product_id}', [ProductController::class, 'offer_store']);
            Route::get('edit/{id}', [ProductController::class, 'offer_edit']);
            Route::post('edit/{id}', [ProductController::class, 'offer_update']);
            Route::post('delete', [ProductController::class, 'delete_offer']);
        });


        Route::prefix('review')->group(function () {
            Route::get('/', [ProductController::class, 'review_list']);
            Route::get('view/{id}', [ProductController::class, 'review_view']);
            Route::post('/delete/', [ProductController::class, 'delete_review']);
        });



        Route::prefix('tag')->group(function () {
            Route::get('/', [AttributeController::class, 'tag']);
            Route::get('create', [AttributeController::class, 'tag_create']);
            Route::post('create', [AttributeController::class, 'tag_store']);
            Route::get('edit/{id}', [AttributeController::class, 'tag_edit']);
            Route::post('edit/{id}', [AttributeController::class, 'tag_update']);
            Route::post('delete', [AttributeController::class, 'delete_tag']);
        });



        Route::prefix('product-type')->group(function () {
            Route::get('/', [AttributeController::class, 'product_type']);
            Route::get('create', [AttributeController::class, 'product_type_create']);
            Route::post('create', [AttributeController::class, 'product_type_store']);
            Route::get('edit/{id}', [AttributeController::class, 'product_type_edit']);
            Route::post('edit/{id}', [AttributeController::class, 'product_type_update']);
            Route::post('delete', [AttributeController::class, 'delete_product_type']);
        });

        Route::prefix('size')->group(function () {
            Route::get('/', [AttributeController::class, 'size']);
            Route::get('create', [AttributeController::class, 'size_create']);
            Route::post('create', [AttributeController::class, 'size_store']);
            Route::get('edit/{id}', [AttributeController::class, 'size_edit']);
            Route::post('edit/{id}', [AttributeController::class, 'size_update']);
            Route::post('delete', [AttributeController::class, 'delete_size']);
        });

        Route::prefix('shape')->group(function () {
            Route::get('/', [AttributeController::class, 'shape']);
            Route::get('create', [AttributeController::class, 'shape_create']);
            Route::post('create', [AttributeController::class, 'shape_store']);
            Route::get('edit/{id}', [AttributeController::class, 'shape_edit']);
            Route::post('edit/{id}', [AttributeController::class, 'shape_update']);
            Route::post('delete', [AttributeController::class, 'delete_shape']);
        });

        Route::prefix('frame')->group(function () {
            Route::get('/', [AttributeController::class, 'frame']);
            Route::get('create', [AttributeController::class, 'frame_create']);
            Route::post('create', [AttributeController::class, 'frame_store']);
            Route::get('edit/{id}', [AttributeController::class, 'frame_edit']);
            Route::post('edit/{id}', [AttributeController::class, 'frame_update']);
            Route::post('delete', [AttributeController::class, 'delete_frame']);
        });
    });



    Route::prefix('report')->group(function () {
        Route::get('detail-report', [ReportController::class, 'detail_report']);
        Route::post('export', [ReportController::class, 'export'])->name('export');
        Route::post('order_detail_filter', [ReportController::class, 'order_detail_filter']);
        Route::get('product/out-of-stock/', [ReportController::class, 'out_of_stock']);
        Route::get('product/featured/', [ReportController::class, 'featured_products']);
        Route::get('product/new-product/', [ReportController::class, 'new_products']);
        Route::get('order/method/{method}/', [ReportController::class, 'method']);
        Route::get('order/{status}/', [ReportController::class, 'orders']);
        Route::get('order-offer/', [ReportController::class, 'offer_orders']);
        Route::post('order-offer/', [ReportController::class, 'render_offer_orders']);
        Route::post('order/export', [ReportController::class, 'order_export'])->name('order_export');
        Route::get('customer/basic/', [ReportController::class, 'customer_info']);
        Route::get('customer/order-report', [ReportController::class, 'customer_order']);
        Route::post('customer/order-report/', [ReportController::class, 'render_customer_order']);
        Route::post('customer/order-report-excel', [ReportController::class, 'customer_order_report_excel']);
    });

    Route::prefix('service')->group(function () {
        Route::get('/', [ServiceController::class, 'service']);
        Route::get('create', [ServiceController::class, 'service_create']);
        Route::post('create', [ServiceController::class, 'service_store']);
        Route::get('edit/{id}', [ServiceController::class, 'service_edit']);
        Route::post('edit/{id}', [ServiceController::class, 'service_update']);
        Route::post('delete', [ServiceController::class, 'delete_service']);
    });


    Route::group(['prefix' => 'site-information'], function () {
        Route::get('/', [SiteInformationController::class, 'siteInformation']);
        Route::post('/', [SiteInformationController::class, 'siteInformationStore']);
    });

    Route::group(['prefix' => 'seo'], function () {
        Route::group(['prefix' => 'extra'], function () {
            Route::get('/', [SeoController::class, 'extra_seo']);
            Route::post('/', [SeoController::class, 'extra_seo_store']);
        });
        Route::get('/{type}', [SeoController::class, 'seo']);
        Route::post('/{type}', [SeoController::class, 'seo_store']);
    });


    Route::prefix('team')->group(function () {

        Route::get('/', [TeamController::class, 'team']);
        Route::get('create', [TeamController::class, 'team_create']);
        Route::post('create', [TeamController::class, 'team_store']);
        Route::get('edit/{id}', [TeamController::class, 'team_edit']);
        Route::post('edit/{id}', [TeamController::class, 'team_update']);
        Route::post('delete/', [TeamController::class, 'delete_team']);

        Route::prefix('designation')->group(function () {
            Route::get('/', [TeamController::class, 'designation']);
            Route::get('create', [TeamController::class, 'designation_create']);
            Route::post('create', [TeamController::class, 'designation_store']);
            Route::get('edit/{id}', [TeamController::class, 'designation_edit']);
            Route::post('edit/{id}', [TeamController::class, 'designation_update']);
            Route::post('delete', [TeamController::class, 'delete_designation']);
        });

    });




});
