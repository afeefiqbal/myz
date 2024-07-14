<?php

namespace App\Http\Helpers;

use App\Http\Controllers\Web\CartController;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Color;
use App\Models\ContactAddress;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\CustomerAddress;
use App\Models\DatabaseStorageModel;
use App\Models\Deal;
use App\Models\Menu;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOfferSize;
use App\Models\ProductPrice;
use App\Models\ProductReview;
use App\Models\RecentlyViewedProduct;
use App\Models\Shape;
use App\Models\ShippingCharge;
use App\Models\SideMenu;
use App\Models\SiteInformation;
use App\Models\Size;
use App\Models\User;

use Buglinjo\LaravelWebp\Facades\Webp;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use NumberFormatter;
use PHPMailer\PHPMailer\PHPMailer;
use Termwind\Components\Dd;

class Helper
{

    /**
     * Return the site prefix keyword
     *
     * @return string admin panel url prefix
     */
    public static function sitePrefix()
    {
        return strtolower('admin/');
    }

    /**
     * Return the authenticated user's type
     *
     * @return string user type
     */
    public static function loggedUserType()
    {
        return strtolower(Auth::guard('admin')->user()->user_type);
    }


    /**
     * Return the authenticated user's name
     *
     * @return string user's name
     */
    public static function loggedUserName()
    {
        $logged = Auth::guard('admin')->user();
        if ($logged) {
            $type = self::loggedUserType();
            $user = $logged->$type;
            return $user->name;
        }
    }

    /**
     * Return the authenticated user's name
     *
     * @return string user's name
     */
    public static function loggedUserProfileImage()
    {
        $user = Auth::guard('admin')->user();
        $image = asset('backend/dist/img/unknown.png');
        if ($user) {
            if ($user->profile_image != NULL && File::exists(public_path($user->profile_image))) {
                $image = asset($user->profile_image);
            }
        }
        return $image;
    }

    public static function loggedCustomerName()
    {
        $logged = Auth::guard('customer')->user()->customer;
        $name = '';
        if ($logged) {
            $name = $logged->first_name . ' ' . $logged->last_name;
        }
        return $name;
    }
    public static function setSessionKey($sessionKey){
        Session::put('session_key', $sessionKey);
        $sessionKey = Session::get('session_key');
       return $sessionKey;
    }
    public static function getSessionKey(){
        $sessionKey = '';
        if (Session::has('session_key')) {
            $sessionKey = Session::get('session_key');
        }
        return $sessionKey;
    }

    public static function commonData()
    {
        $siteInformation = SiteInformation::first();
        $menus = Menu::active()->with('category')->oldest('sort_order')->get();
        
        $shapes = Shape::active()->get();
        $sideMenus = SideMenu::active()->oldest('sort_order')->get();
        $colors = Color::active()->get();
        $blogCount = Blog::active()->count();
        $sessionKey = '';
        if (Session::has('session_key')) {
            $sessionKey = Session::get('session_key');
        }

        $calculation_box = self::calculationBox();
        $currencies = Currency::where('status', 'Active')->get();
        $defaultCurrency = Currency::where('is_default', 1)->first();

        $first_image = Banner::first();
        if(isset($first_image)){
            $first_image = $first_image->about_first_bottom_image;
        }
        $first_image_text = Banner::first();
        if(isset($first_image_text)){
            $first_image_text = $first_image_text->about_first_bottom_image_text;
        }
        $second_image = Banner::first();
        if(isset($second_image)){
            $second_image = $second_image->about_second_bottom_image;
        }
        $second_image_text = Banner::first();
        if(isset($second_image_text)){
            $second_image_text = $second_image_text->about_second_bottom_image;
        }
        $third_image = Banner::first();
        if(isset($third_image)){
            $third_image = $third_image->about_third_bottom_image;
        } 
        $third_image_text = Banner::first();
        if(isset($third_image_text)){
            $third_image_text = $third_image_text->about_third_bottom_image_text;
        } 

        $parentCategories = Category::active()->isParent()->get();
        $menuCategories = Category::active()->get();
        $address = ContactAddress::active()->first();
        $shapes = Shape::active()->get();
        return View::share(compact('siteInformation', 'menus', 'blogCount', 'sessionKey','shapes','menuCategories', 'calculation_box', 
        'first_image',
        'first_image_text',
        'second_image',
        'second_image',
        'second_image_text',
        'third_image',
        'third_image_text',
        'currencies', 'defaultCurrency', 'parentCategories', 'address','shapes','colors','sideMenus'));
    }

    /**
     * Rename a file with underscore and increment number if the file exists in the provided location
     * and uploads that file.
     *
     * @param file $file The file value from file input field.
     * @param string $fileNAme The name to be added for the file.
     * @param string $location The location where the file is to be saved.
     *
     * @return string The 'renamed' file name with location.
     */
    public static function uploadFile($file, $location, $fileName = null)
    {
        if (!File::exists(public_path($location))) {
            File::makeDirectory(public_path($location), 0777, true);
        }
        if ($fileName == null) {
            list($name, $ext) = explode('.', $file->getClientOriginalName());
            $fileName = $name;
        }
        $fileName = str_replace(' ', '-', strtolower($fileName));
        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '-', $fileName) . time() . '.' . $file->getClientOriginalExtension();
        $fileName = str_replace('--', '-', $fileName);
        $target = $location . $fileName;
        if (File::exists(public_path($target))) {
            $increment = 0;
            list($name, $ext) = explode('.', $fileName);
            while (File::exists(public_path($target))) {
                $increment++;
                $fileName = $name . '_' . $increment . '.' . $ext;
                $target = $location . $fileName;
            }
        }
        $file->move(public_path($location), $fileName);
        return $target;
    }

    public static function deleteFile($collection, $fieldName)
    {
        if (File::exists(public_path($collection->$fieldName))) {
            File::delete(public_path($collection->$fieldName));
        }
    }

    /**
     * convert an image file to webp and upload it to specified location.
     *
     * @param file $file The file value from file input field.
     * @param string $location The location where the file is to be saved.
     * @param string $fileName the name of the file.
     *
     * @return string webp file location
     */
    public static function uploadWebpImage($file, $location, $fileName)
    {
        if (!File::exists(public_path($location))) {
            File::makeDirectory(public_path($location), 0777, true);
        }
        $fileName = str_replace(' ', '-', strtolower($fileName));
        $fileName = preg_replace('/[^A-Za-z0-9\-]/', '-', $fileName) . time() . '.webp';
        $fileName = str_replace('--', '-', $fileName);

        $target = $location . $fileName;
        if (File::exists(public_path($target))) {

            $increment = 0;
            list($name, $ext) = explode('.', $fileName);
            while (File::exists(public_path($target))) {
                $increment++;
                $fileName = $name . '_' . $increment . '.' . $ext;
                $target = $location . $fileName;
            }
        }
        Webp::make($file)->save(public_path($target));

        return $target;
    }


    /**
     * print an image with webp on pages with picture tag.
     *
     * @param Collection $collection The eloquent collection.
     * @param string $field the name of the field.
     * @param string $webpField the name of the webp field.
     * @param string $attributeField the name of the attribute field.
     * @param string $cssClass the css class of the image.
     *
     * @return string html code for printing image on pages.
     */
    public static function printImage($collection, $field, $webpField, $attributeField, $cssClass = null, $cssStyle = null, $pictureClass = null)
    {
        $imageData = '<picture' . ($pictureClass ? ' class="' . $pictureClass . '"' : '') . '>';
        if (!empty($collection->$webpField) && File::exists(public_path($collection->$webpField))) {
            $imageData .= '<source srcset="' . asset($collection->$webpField) . '" type="image/webp">';
        }
        if (!empty($collection->$field) && File::exists(public_path($collection->$field))) {
            $imageData .= '<img src="' . asset($collection->$field) . '" ' . $collection->$attributeField;
        } else {
            if ($field == 'desktop_image' || $field == 'desktop_banner') {
                $imageData .= '<img src="' . asset('frontend/images/default-image-rect.jpg') . '" alt="Default Image"';
            } else if ($field == 'profile_image') {
                $imageData .= '<img src="' . asset('frontend/images/user_img_de.png') . '" alt="Default Image"';
            } else if ($field == 'author_image') {
                $imageData .= '<img src="' . asset('frontend/images/blog/profile/blog_profile.jpg') . '" alt="Default Image"';
            } else {
                $imageData .= '<img src="' . asset('frontend/images/default-image.jpg') . '" alt="Default Image"';
            }
        }
        if ($cssClass) {
            $imageData .= ' class="' . $cssClass . '"';
        }
        if ($cssStyle) {
            $imageData .= ' style="' . $cssStyle . '"';
        }
        $imageData .= ' ></picture>';
        return $imageData;
    }

    public static function mailConf($subject)
    {
        if (!isset($subject)) {
            $subject = config('app.name');
        }
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        //        $mail->SMTPDebug = 2;
        $mail->SMTPSecure = config('mail.mailers.smtp.encryption');
        $mail->Host = config('mail.mailers.smtp.host');  //gmail has host > smtp.gmail.com
        $mail->Port = config('mail.mailers.smtp.port'); //gmail has port > 587 . without double quotes
        $mail->Username = config('mail.mailers.smtp.username'); //your username. actually your email
        $mail->Password = config('mail.mailers.smtp.password'); // your password. your mail password
        $mail->CharSet = 'utf-8';
        $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
        $mail->Subject = $subject;
        $mail->IsHTML(true);
        return $mail;
    }

    public static function sendCredentials($user, $name, $password)
    {
        $subject = config('app.name') . " - Send Credentials";
        $mail = self::mailConf($subject);
        $searchArr = ["{name}", "{email}", "{phone}", "{password}", "{owner}"];
        $replaceArr = [$name, $user->email, $user->phone, $password, config('app.name')];
        $body = file_get_contents(resource_path('views/mail_templates/send_credentials.blade.php'));
        $body = str_replace($searchArr, $replaceArr, $body);
        $mail->MsgHTML($body);
        $mail->addAddress($user->email, $name);
        $mail->send();
        if ($mail) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Send password reset Email to user
     *
     * @return boolean Returns true when mail is sent else false
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function forgotPassword($user, $name, $link)
    {
        $subject = config('app.name') . " - Forgot Password";
        $mail = self::mailConf($subject);

        $searchArr = ["{name}", "{link}", "{owner}"];
        $replaceArr = [$name, $link, config('app.name')];
        $body = file_get_contents(resource_path('views/mail_templates/forgot_password.blade.php'));
        $body = str_replace($searchArr, $replaceArr, $body);
        $mail->MsgHTML($body);
        $mail->addAddress($user->email, $name);
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
    public static function verifyemail($user, $name, $link)
    {
        $subject = config('app.name') . " - Verify Email";
        $mail = self::mailConf($subject);

        $searchArr = ["{name}", "{link}", "{owner}"];
        $replaceArr = [$name, $link, config('app.name')];
        $body = file_get_contents(resource_path('views/mail_templates/verify_email.blade.php'));
        $body = str_replace($searchArr, $replaceArr, $body);
        $mail->MsgHTML($body);
        $mail->addAddress($user->email, $name);
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendOrderPlacedMail($order, $flag)
    {
        if ($flag == '1') {
            $orderData = Order::find($order);
            if ($orderData != NULL) {
                if ($orderData->orderCustomer->user_type == "User") {
                    $order = Order::with(['orderProducts' => function ($t) {
                        $t->with('productData');
                    }])->with(['orderCustomer' => function ($c) use ($orderData) {
                        $c->with('customerData');
                        $c->with('billingAddress');
                        $c->where('customer_id', $orderData->orderCustomer->customer_id);
                    }])->with('orderCoupons')->find($orderData->id);
                } else {
                    $order = Order::with(['orderProducts' => function ($t) {
                        $t->with('productData');
                    }])->with('orderCustomer')->with('orderCoupons')->find($orderData->id);
                }
            }
        }
        $common = SiteInformation::first();
        $contactAddress = ContactAddress::where('status', 'Active')->first();
        $customerAddress = $order->orderCustomer->billingAddress;
        $to = $customerAddress->email;
        $to_name = $customerAddress->first_name . ' ' . $customerAddress->last_name;
        $link = url('order/' . base64_encode($order->order_code));
        $orderGrandTotal = Order::OrderGrandTotal($order->id);
       
        $orderTotal = Order::getProductTotal($order->id);
        //mail to customer
     $emails = explode(',', $common->order_emails);
     //send mail to multiple emails
  
        // Mail::send('mail_templates.order_invoice_v2', array('order' => $order, 'name' => $to_name, 'common' => $common,'admin' =>false,
        //     'orderGrandTotal' => $orderGrandTotal, 'orderTotal' => $orderTotal, 'title' => 'Congratulations, Order Successful!',
        //     'link' => $link), function ($message) use ($to, $to_name, $common,$contactAddress) {
        //     $message->to($to, $to_name)->subject(config('app.name') . ' - Order Placed');
        //     $message->from($common->email, $common->email_recipient);
        // });        //mail to admin
        // foreach ($emails as $email) {
        //     Mail::send('mail_templates.order_invoice_v2', array('order' => $order, 'name' => $to_name, 'common' => $common,'admin'=>true,
        //         'orderGrandTotal' => $orderGrandTotal, 'orderTotal' => $orderTotal, 'title' => 'New Order Recieved',
        //         'link' => $link), function ($message) use ($email, $to_name, $common,$contactAddress) {
        //         $message->to($email, $to_name)->subject(config('app.name') . ' - Order Placed');
        //         $message->from($common->email, $common->email_recipient);
        //     });
        // }
        return true;
    }

    public static function sendOrderCancelledMail($order, $reason, $orderLog)
    {
        $product = $orderLog->orderProduct->productData;
        $common = SiteInformation::first();
        $contactAddress = ContactAddress::where('status', 'Active')->first();

        $customerAddress = $order->orderCustomer->billingAddress;

        $to = $customerAddress->email;
        $to_name = $customerAddress->first_name . ' ' . $customerAddress->last_name;
        //mail to customer
        try {

        Mail::send('mail_templates.order_cancel', array('order' => $order, 'name' => $to_name, 'common' => $common,
            'reason' => $reason, 'product' => $product->title), function ($message) use ($to, $to_name, $common,$contactAddress) {
            $message->to($to, $to_name)->subject(config('app.name') . ' - Order Cancelled');
            $message->from($common->email, $common->email_recipient);
        });
        //mail to admin
        $emails = explode(',', $common->order_emails);
        foreach ($emails as $email) {

            Mail::send('mail_templates.order_cancel', array('order' => $order, 'name' => $common->email_recipient,
                'common' => $common, 'reason' => $reason, 'product' => $product->title), function ($message) use ($common,$email) {
                    $message->to($email, $common->email_recipient)->subject(config('app.name') . ' - Order Cancelled');
                $message->from($common->email, $common->email_recipient);
            });
        }
        } catch (\Exception $e) {
    
            return false;
        }

        return true;
    }

    public static function sendContactMail($contact, $type = Null)
    {
        $common = SiteInformation::first();
        $subject = config('app.name') . ' - ' . $type;
        $mail = self::mailConf($subject);
        if ($contact->type == 'product') {
            $searchArr = ["{name}", "{email}", "{product}", "{phone}", "{message}", "{type}", "{site_name}"];
            $replaceArr = [$contact->name, $contact->email, $contact->product->title, $contact->phone, $contact->message, $type, config('app.name')];
            $body = file_get_contents(resource_path('views/mail_templates/product_enquiry.blade.php'));
        } else {
            $searchArr = ["{name}", "{email}", "{phone}",  "{message}", "{type}", "{site_name}"];
            $replaceArr = [$contact->name, $contact->email, $contact->phone, $contact->message, $type, config('app.name')];
            $body = file_get_contents(resource_path('views/mail_templates/enquiry.blade.php'));
        }
        $body = str_replace($searchArr, $replaceArr, $body);
        $contactAddress = SiteInformation::first();
//        dd($common->email);

        $mail->MsgHTML($body);
        $emails = explode(',', $common->enquiry_emails);
        foreach ($emails as $email) {
            $mail->addAddress($email, $common->email_recipient);
        }
        $mail->send();
        if ($mail) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendReply($enquiry)
    {
        if($enquiry->type == 'product')
            $subject = config('app.name') . ' -Reply for your bulk enquiry';
        else
            $subject = config('app.name') . ' -Reply for your contact request';
        $mail = self::mailConf($subject);
        $searchArr = ["{name}", "{message}", "{reply}", "{site_name}","{subject}"];
        $replaceArr = [$enquiry->name, $enquiry->message, $enquiry->reply, config('app.name'),$subject];
        $body = file_get_contents(resource_path('views/mail_templates/enquiry_reply.blade.php'));
        $body = str_replace($searchArr, $replaceArr, $body);
        $mail->MsgHTML($body);
        //check email is valid or not
        $email = $enquiry->email;
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($email, $enquiry->name);
        }
        else{
            return false;
        }
        $mail->send();
        if ($mail) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendCustomerNewpassword($user, $password)
    {
        $subject = config('app.name') . " - New Password";
        $mail = self::mailConf($subject);
        $searchArr = ["{name}", "{password}", "{owner}"];
        $replaceArr = [$user->customer->first_name . ' ' . $user->customer->last_name, $password, config('app.name')];
        $body = file_get_contents(resource_path('views/mail_templates/send_new_password.blade.php'));
        $body = str_replace($searchArr, $replaceArr, $body);
        $mail->MsgHTML($body);
        $mail->addAddress($user->email, $user->customer->first_name . ' ' . $user->customer->last_name);
        $mail->send();
        if ($mail) {
            return true;
        } else {
            return false;
        }
    }

    public static function imageDimension($type)
    {
        if ($type == "blog-detail") {
            $dimension['width'] = '510';
            $dimension['height'] = '545';
        } elseif ($type == 'product-detail' || $type == 'wishlist') {
            $dimension['width'] = '800';
            $dimension['height'] = '440';
        } else {
            $dimension['width'] = '1640';
            $dimension['height'] = '375';
        }
        return $dimension;
    }

    public static function defaultCurrency()
    {
        if (Session::has('currency')) {
            $currency = session('currency');
        } else {
            $currency = config('app.default_currency');
        }
        return $currency;
    }

    public static function defaultCurrencyRate()
    {
        if (Session::has('currency')) {
            $currency_rate = session('currency_rate');
        } else {
            $currency_rate = '1';
        }
        return $currency_rate;
    }


    public static function transferGuestCartToUser($sessionKey)
    {
        // check for guest cart data in session
  
        $guestCart = session('guest_cart.data');
     
        if(isset($guestCart) && !empty($guestCart)){

            if ($guestCart->isNotEmpty()) {
                $guestCartItems = $guestCart->toArray();
                foreach ($guestCartItems as $item) {
                  
                    $cart_request = new Request();
                    $cart_request->setMethod('POST');
                  
                    $product_id = $item['attributes']['product_id'];
                    $size = $item['attributes'];
                    $cart_request->request->add(['product_id' => $item['id']]);
                    $cart_request->request->add(['qty' => $item['quantity']]);
                    $cart_request->request->add(['countRelative' => 1]);
                    app(CartController::class)->cartAddItems($cart_request, $product_id, $sessionKey,$size);
                }
            }
        }
        // check for guest cart data in database
        $dbCart = DatabaseStorageModel::find(session('guest_cart.session') . '_cart_items');
        // delete guest cart data from database
        if ($dbCart) $dbCart->delete();
    }

    public static function updateCartItemPrice()
    {
        if (Session::has('session_key')) {
            $sessionKey = session('session_key');
            if (!Cart::session($sessionKey)->isEmpty()) {
                foreach (Cart::session($sessionKey)->getContent() as $row) {
                    $product = Product::find($row->id);
                    if($product != null){

                        if (Helper::offerPrice($product->id) != '') {
                            $offer_amount = Helper::offerPriceAmount($product->id);
                            $offer_id = Helper::offerId($product->id);
                            $product_price = $offer_amount;
                        } else {
                            $offer_amount = '0.00';
                            $offer_id = '0';
                            $product_price = Helper::defaultCurrencyRate() * $product->price;
                        }
                        Cart::session($sessionKey)->update($row->id, [
                            'price' => $product_price,
                            'attributes' => [
                                'currency' => Helper::defaultCurrency(),
                                'color' => $product->color_id,
                                'offer' => $offer_id,
                                'offer_amount' => $offer_amount,
                                'base_price' => $product->price,
                            ]
                        ]);
                    }
                    else{
                        cart::session($sessionKey)->remove($row->id);
                    }
                }
            }
        }
    }


    public static function SendPaymentDeclinedFailedMail($order, $flag, $type)
    {
        if ($flag == '1') {
            $orderData = Order::find($order);
            if ($orderData != NULL) {
                if ($orderData->orderCustomer->user_type == "User") {
                    $order = Order::with(['orderProducts' => function ($t) {
                        $t->with('productData');
                    }])->with(['orderCustomer' => function ($c) use ($orderData) {
                        $c->with('customerData');
                        $c->with('CustomerAddressData');
                        $c->where('customer_id', $orderData->orderCustomer->customer_id);
                    }])->with('orderCoupon')->find($orderData->id);
                } else {
                    $order = Order::with(['orderProducts' => function ($t) {
                        $t->with('productData');
                    }])->with('orderCustomer')->with('orderCoupon')->find($orderData->id);
                }
            }
        }
        $common = SiteInformation::first();
        if ($order->orderCustomer->user_type == "User") {
           
            $to = $order->orderCustomer->billingAddress->email;
            $to_name = $order->orderCustomer->billingAddress->first_name . ' ' . $order->orderCustomer->billingAddress->last_name;
            $userType = 'user';
            $link = '';
        } else {
            $to = $order->orderCustomer->shippingAddress->email;
          
            $to_name = $order->orderCustomer->shippingAddress->full_name;
            $userType = 'guest';
            $link = url('order/' . base64_encode($orderData->order_code));
        }
        $orderGrandTotal = Order::OrderGrandTotal($order->id);
        $orderTotal = Order::getProductTotal($order->id);
        $name = $to_name;
        if($type == 'Declined'){
            $title = 'New Order - Payment Declined';
            $subject = 'Payment Declined';
        }
        if($type == 'Failed'){
            $title = 'New Order - Payment Failed';
            $subject = 'Payment Failed';
        }
 
        Mail::send('mail_templates.order_invoice_v2', array('order' => $order, 'name' => $name, 'common' => $common,
            'orderGrandTotal' => $orderGrandTotal, 'orderTotal' => $orderTotal, 'userType' => $userType, 'link' => $link, 'subject' => $subject,
            'title' => $title, 'type' => $type),
            function ($message) use ($to, $to_name, $common, $subject) {
                $message->to($to, $to_name)->subject(config('app.name') . ' - ' . $subject);;
//            $message->from($common->email_1, $common->contact_recepient_name);
            });

        //mail to /admins
        Mail::send('mail_templates.order_invoice_v2', array('order' => $order, 'name' => $common->email_recepient,'subject' => $subject,
            'common' => $common, 'orderGrandTotal' => $orderGrandTotal, 'orderTotal' => $orderTotal,
            'orderTotal' => $orderTotal, 'userType' => $userType, 'link' => $link,
            'title' => $title, 'type' => $type),
            function ($message) use ($common, $subject) {
                $message->to($common->email, isset($common->email_recepient) ? $common->email_recepient : 'ARTMYST')
                    ->subject(config('app.name') . ' - ' . $subject);
                /*if($status=="Cancelled"){
                    $message->bcc($common->admin_mail, $common->admin_name);
                }*/
            });
    }
    public static function getCartItemCount()
    {
        $cartItemCount = 0;
        if (Session::has('session_key')) {
            $sessionKey = session('session_key');
            if (!Cart::session($sessionKey)->isEmpty()) {
                foreach (Cart::session($sessionKey)->getContent() as $row) {
                    $cartItemCount += $row->quantity;
                }
            }
        }
        return $cartItemCount;
    }


    public static function getAllSubCategories($parent_id = 0, $subCategoryList = null)
    {
        $subCategoryList = $subCategoryList ?? Category::where('id', 0)->get();
        $subCategories = Category::active()->where('parent_id', $parent_id)->latest()->get();
        $subCategoryList = $subCategoryList->merge($subCategories);
        if ($subCategories->isNotEmpty()) {
            foreach ($subCategories as $subCategory) {
                $subCategoryList = Helper::getAllSubCategories($subCategory->id, $subCategoryList);
            }
        }
        return $subCategoryList;
    }

    public static function offerPrice($productId)
    {
        
        $offer = self::offerPriceAmount($productId);
        return $offer;
        if ($offer != '') {
            $offer = self::defaultCurrency() . ' ' . $offer;
        }
        return $offer;
    }

    public static function offerPriceAmount($productId)
    {
        $product = Product::find($productId);
        $offer = '';
        if ($product) {
            $deal = Deal::whereRaw("find_in_set('" . $productId . "',products)")->where([['status', 'Active'], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
            if ($deal) {
                if ($deal->offer_type == "Percentage") {
                    $productPrice = $product->price * self::defaultCurrencyRate();
                    $percentage = $deal->offer_value;
                    $amount = (($productPrice * $percentage) / 100);
                    $finalAmount = number_format(($productPrice - $amount), 2);
                    $offer = $finalAmount;
                } else if ($deal->offer_type == "Fixed") {
                    $offer = number_format($deal->offer_value * self::defaultCurrencyRate(), 2);
                } else {
                    //for normal deal=> takes offer
                    $offer = Offer::where([['status', 'Active'], ['product_id', $productId], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
                    if ($offer) {
                        $offer = number_format($offer->price * self::defaultCurrencyRate(), 2);
                    }
                }
            } else {
                $offer = Offer::where([['status', 'Active'], ['product_id', $productId], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
                if ($offer) {
                    $offer = number_format($offer->price * self::defaultCurrencyRate(), 2);
                }
            }
        }
        return $offer;
    }
    public static function offerPriceAmountWithoutDefaultCurrency($productId)
    {
        $product = Product::find($productId);
        $offer = '';
        if ($product) {
            $deal = Deal::whereRaw("find_in_set('" . $productId . "',products)")->where([['status', 'Active'], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
            if ($deal) {
                if ($deal->offer_type == "Percentage") {
                    $productPrice = $product->price;
                    $percentage = $deal->offer_value;
                    $amount = (($productPrice * $percentage) / 100);
                    $finalAmount = number_format(($productPrice - $amount), 2);
                    $offer = $finalAmount;
                } else if ($deal->offer_type == "Fixed") {
                    $offer = number_format($deal->offer_value, 2);
                } else {
                    $offer = Offer::where([['status', 'Active'], ['product_id', $productId], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
                    if ($offer) {
                        $offer = number_format($offer->price, 2);
                    }
                }
            } else {
                $offer = Offer::where([['status', 'Active'], ['product_id', $productId], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
                if ($offer != NULL) {
                    $offer = number_format($offer->price, 2);
                }
            }
        }
        return $offer;
    }

    public static function offerId($productId)
    {
        $product = Product::find($productId);
        $offerId = '';
        if ($product) {
            $deal = Deal::whereRaw("find_in_set('" . $productId . "',products)")->where([['status', 'Active'], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
            if ($deal) {
                $offerId = $deal->id;
            } else {
                $offer = Offer::where([['status', 'Active'], ['product_id', $productId], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
                if ($offer != NULL) {
                    $offerId = $offer->id;
                }
            }
        }
        return $offerId;
    }

    public static function offerPercentageDiv($productId, $type)
    {
        $product = Product::find($productId);
        $offerContent = $finalDigit = '';
        if ($product) {
            $deal = Deal::whereRaw("find_in_set('" . $productId . "',products)")->where([['status', 'Active'], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
            if ($deal) {
                if ($deal->offer_type == "Percentage") {
                    $finalDigit = $deal->offer_value;
                } else if ($deal->offer_type == "Fixed") {
                    $offer = $deal->offer_value * self::defaultCurrencyRate();
                    $percent = $offer / ($product->price * self::defaultCurrencyRate());
                    $percent_by = $percent * 100;
                    $percent_last = 100 - $percent_by;
                    $finalDigit = round($percent_last);
                } else {
                    $offer = Offer::where([['status', 'Active'], ['product_id', $productId], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
                    if ($offer != NULL) {
                        $offer = $offer->price * self::defaultCurrencyRate();
                        $percent = $offer / ($product->price * self::defaultCurrencyRate());
                        $percent_by = $percent * 100;
                        $percent_last = 100 - $percent_by;
                        $finalDigit = round($percent_last);
                    }
                }
            } else {
                $offer = Offer::where([['status', 'Active'], ['product_id', $productId], ['start_date', '<=', date('Y-m-d')], ['end_date', '>=', date('Y-m-d')]])->first();
                if ($offer != NULL) {
                    $offer = $offer->price * self::defaultCurrencyRate();
                    $percent = $offer / ($product->price * self::defaultCurrencyRate());
                    $percent_by = $percent * 100;
                    $percent_last = 100 - $percent_by;
                    $finalDigit = round($percent_last);
                }
            }
            if ($finalDigit != '') {
                if ($type == "1") {
                    $offerContent = '<div class="offerbg"><h5><span><bold>' . $finalDigit . '</bold>%</span> <mark>Off</mark></h5></div>';
                } else {
                    $offerContent = '<div class="offer"><h6>' . $finalDigit . '%<span>Off</span></h6></div>';
                }
            }
        }
        return $offerContent;
    }

    public static function calculationBox()
    {
        //update item prices
        self::updateCartItemPrice();
        $return_result = [];
        if (Session::has('session_key')) {
            $siteInformation = SiteInformation::first();
            $sessionKey = session('session_key');
            $grand_total = Cart::session($sessionKey)->getTotal();

            $currency_rate = self::defaultCurrencyRate();
            $grand_total = $grand_total ;
            $shippingFreeArray = [];
            if (Session::has('coupons')) {
                foreach (session('coupons') as $session_coupon) {
                    $coupon = Coupon::where([['status', 'Active'], ['code', $session_coupon['code']]])->first();
                    self::coupon_application($coupon);
                    if ($coupon->is_free_shipping == 'Yes') {
                        $shippingFreeArray[] = '1';
                    }
                }
            }
            if (Session::has('coupon_value')) {
                $grand_total = $grand_total - session('coupon_value');
            }
            $shippingAmount = '0.00';
            if (!$shippingFreeArray) {
                if (Auth::guard('customer')->check()) {
                    if (Session::has('selected_shipping_address')) {
                        $customerAddress = CustomerAddress::active()->find(session('selected_shipping_address'));
                    } else {
                        $customerAddress = CustomerAddress::active()->where('customer_id', Auth::guard('customer')->user()->customer->id)
                            ->where('is_default', 'Yes')->first();
                    }
                    if ($customerAddress) {
                        $shippingAmount = ShippingCharge::getShippingCharge($customerAddress->state_id, $grand_total);
                    } else {
                        $shippingAmount = '0.00';
                    }
                } else {
                    if (Session::has('shipping_state')) {
                        $shippingAmount = ShippingCharge::getShippingCharge(session('shipping_state'), $grand_total);
                    } else {
                        $shippingAmount = '0.00';
                    }
                }
            }
            $tax_amount = 0.00;
            if ($siteInformation->tax != 0) {
                if ($siteInformation->tax_type == "Outside") {
                    $tax_amount = $grand_total * $siteInformation->tax / 100;
                    $grand_total = $grand_total + $tax_amount;
                }
            }
            
        
            $grandTotal = $grand_total + $shippingAmount;
           
            $return_result['shippingAmount'] = $shippingAmount;
            $return_result['tax_amount'] = $tax_amount;
            $return_result['final_total_with_tax'] = $grandTotal;
          
           
        }
        return $return_result;
    }


    public static function get_coupon_total_value()
    {
        $coupon_total_value = 0;
        if (Session::has('coupons')) {
            foreach (Session::get('coupons') as $session_coupon) {
                $coupon_total_value += $session_coupon['coupon_value'];
            }
        }
        return $coupon_total_value;
    }


    public static function coupon_application($coupon, $credit_point = 0)
    {

        if ($coupon) {
            $currency = Helper::defaultCurrency();
            $currency_rate = Helper::defaultCurrencyRate();
            $sessionKey = session('session_key');
            $coupon_value = $currency_rate * $coupon->coupon_value;
            $cartAmount = (\Cart::session($sessionKey)->getSubTotal() - $credit_point);
            $cartAmount = number_format((float)$cartAmount, 2, '.', '');
            $minimum_valid = $maximum_valid = $usage_valid = $totalUsage_valid = $person_usage_valid = true;
            if (Session::has('coupons')) {
                foreach (Session::get('coupons') as $session_coupon) {
                    $existCouponData = Coupon::where('code', $session_coupon['code'])->first();
                    if ($existCouponData->id == $coupon->id) {
                        $usage_valid = true;
                    } else {
                        if ($existCouponData->individual_use == "No" || $coupon->individual_use == "No") {
                            $usage_valid = false;
                        }
                    }
                }
            }
            if ($usage_valid == true) {
                if ($coupon->expiry_date >= date('Y-m-d')) {
                    if ($coupon->minimum_spend != '0.00') {
                        if ($coupon->minimum_spend <= $cartAmount) {
                            $minimum_valid = true;
                        } else {
                            $minimum_valid = false;
                        }
                    }
                    if ($coupon->maximum_spend != '0.00') {
                        if ($coupon->maximum_spend >= $cartAmount) {
                            $maximum_valid = true;
                        } else {
                            $maximum_valid = false;
                        }
                    }
              
                    if ($minimum_valid == true && $maximum_valid == true) {
                        if (Auth::guard('customer')->check()) {
                            if (Session::has('selected_shipping_address')) {
                                $customerAddress = CustomerAddress::find(session('selected_shipping_address'));
                            } else {
                                $customerAddress = CustomerAddress::where([['customer_id', '=', Auth::guard('customer')->user()->customer->id], ['is_default', '=', 'Yes']])->first();
                            }
                        }
                        $totalUsage = Coupon::getTotalUsage($coupon->id);
                        if ($totalUsage > $coupon->usage_per_coupon) {
                            $totalUsage_valid = false;
                        }
                        if ($totalUsage_valid == true) {
                            $address_required_valid = true;
                            if (Auth::guard('customer')->check()) {
                                if (!$customerAddress) {
                                    $address_required_valid = false;
                                }
                            } else {
                                if (!Session::has('shipping_state') && !Session::has('billing_state')) {
                                    $address_required_valid = false;
                                }
                            }
                            if ($address_required_valid == true) {
                                $personUsage = Coupon::getPersonUsage($coupon->id);
                                if ($personUsage >= $coupon->usage_per_person) {
                                    $person_usage_valid = false;
                                }
                                if ($person_usage_valid == true) {
                                    $allow_public_valid = true;
                                    if ($coupon->allow_public == "Yes") {
                                        $allow_public_valid = true;
                                    } else {
                                        if (Auth::guard('customer')->check()) {
                                            if ($coupon->allowed_mails != NULL) {
                                                if ($customerAddress) {
                                                    if (in_array(Auth::guard('customer')->id(), explode(',', $coupon->allowed_mails))) {
                                                        $allow_public_valid = true;
                                                    } else {
                                                        $allow_public_valid = false;
                                                    }
                                                }
                                            } else {
                                                $allow_public_valid = true;
                                            }
                                        } else {
                                            $allow_public_valid = false;
                                        }
                                    }
                                    if ($allow_public_valid == true) {
                                        $sale_price_valid = true;
                                        $cartProducts = Cart::session($sessionKey)->getContent();
                                        $offerProductCount = 0;
                                        foreach ($cartProducts as $cartProduct) {
                                            if ($coupon->applicable_only_if_sale_price == "No") {
                                                if ($coupon->type == "Fixed") {
                                                    if (self::offerPriceAmount($cartProduct->id) != '') {
                                                        $sale_price_valid = false;
                                                        break;
                                                    }
                                                } else {
                                                    // for percentage - check if all products in cart has offer
                                                    if (self::offerPriceAmount($cartProduct->id) != '') {
                                                        $offerProductCount++;
                                                    }
                                                }
                                            } else {
                                                $sale_price_valid = true;
                                                break;
                                            }
                                        }
                                        if ($cartProducts->count() == $offerProductCount) {
                                            $sale_price_valid = false;
                                        }
                                        if ($sale_price_valid == true) {
                                            $coupon_applicable_cart_product_ids = $coupon_not_applicable_cart_product_ids = [];
                                            $coupon_applicable_cart_product_cost = [];
                                            $coupon_applicable_value = 0;
                                            $couponProductIds = self::getCouponProductIds($coupon);
                                        
                                            foreach ($cartProducts as $cartProduct) {
                                                $productData = Product::find($cartProduct->attributes->product_id);
                                 
                                                if (in_array($productData->id, $couponProductIds)) {
                                           
                                                    if ($coupon->applicable_only_if_sale_price == "No") {
                                                        if (self::offerPriceAmount($cartProduct->attributes->product_id) == '') {
                                                         
                                                            $coupon_applicable_cart_product_ids[] = $cartProduct->id;
                                                            $coupon_applicable_cart_product_cost[] = $cartProduct->price * $cartProduct->quantity;
                                                        } else {
                                                            $coupon_not_applicable_cart_product_ids[] = $cartProduct->attributes->product_id;
                                                        }
                                                    } else {
                                                        $coupon_applicable_cart_product_ids[] = $cartProduct->id;
                                                        $coupon_applicable_cart_product_cost[] = $cartProduct->price * $cartProduct->quantity;
                                                    }
                                                } else {
                                                   
                                                    $coupon_not_applicable_cart_product_ids[] = $cartProduct->attributes->product_id;
                                                }
                                            }
                                            if ($coupon_not_applicable_cart_product_ids) {
                                               
                                                if ($coupon->type == "Fixed") {
                                                    if(Session::has('coupons')){
                                                        self::removeSessionCoupon($coupon->code);
                                                    }
                                                    return array(
                                                        'status' => "error",
                                                        'message' => "This coupon is only available for selected items",
                                                    );
                                                } else {
                                                    if ($coupon_applicable_cart_product_cost) {
                                                        $coupon_applicable_value = array_sum($coupon_applicable_cart_product_cost) * $coupon_value / 100;
                                                    }
                                                }
                                            } else {
                                                if ($coupon->type == "Fixed") {
                                                    $coupon_applicable_value = $coupon_value;
                                                } else {
                                                    if ($coupon_applicable_cart_product_cost) {
                                                        $coupon_applicable_value = array_sum($coupon_applicable_cart_product_cost) * $coupon_value / 100;
                                                     
                                                    } else {
                                                        $coupon_applicable_value = $cartAmount * $coupon_value / 100;
                                                    }
                                                }
                                            }
                                            if ($coupon->type != "Fixed" && $coupon->coupon_value_limit < $coupon_applicable_value) {   
                                                $coupon_applicable_value = $coupon->coupon_value_limit;
                                            }
                                            if ($coupon_applicable_value > 0) {
                                                $final_amount_after_coupon = $cartAmount - $coupon_applicable_value;
                                                if ($final_amount_after_coupon > $coupon_applicable_value) {
                                                    if (Session::has('coupons')) {
                                                        if (in_array($coupon->code, array_column(Session::get('coupons'), 'code'))) {
                                                            foreach (Session::get('coupons') as $key => $session_coupon) {
                                                                if ($session_coupon['code'] == $coupon->code) {
                                                                    Session::put('coupons.' . $key . '.code', $coupon->code);
                                                                    Session::put('coupons.' . $key . '.coupon_value', $coupon_applicable_value);
                                                                    Session::put('coupons.' . $key . '.products', $coupon_applicable_cart_product_ids);
                                                                }
                                                            }
                                                        } else {
                                                            Session::push('coupons', ['code' => $coupon->code, 'coupon_value' => $coupon_applicable_value, 'products' => $coupon_applicable_cart_product_ids]);
                                                        }
                                                    } else {
                                                      
                                                        Session::push('coupons', ['code' => $coupon->code, 'coupon_value' => $coupon_applicable_value, 'products' => $coupon_applicable_cart_product_ids]);
                                                    }
                                                    $coupon_total_value = Helper::get_coupon_total_value();
                                                    if ($coupon_total_value) {
                                                        Session::put('coupon_value', $coupon_total_value);
                                                    }
                                                    
                                                    return array(
                                                        'status' => "success",
                                                        'message' => "Coupon applied successfully",
                                                    );
                                                } else {
                                                    if(Session::has('coupons')){
                                                        self::removeSessionCoupon($coupon->code);
                                                    }
                                                    return array(
                                                        'status' => "error",
                                                        //coupon value is greater than cart price
                                                        'message' => "Add more products to cart to apply ths coupon",
                                                    );
                                                }
                                            } else {
                                                if(Session::has('coupons')){
                                                    self::removeSessionCoupon($coupon->code);
                                                }
                                                return array(
                                                    'status' => "error",
                                                    'message' => "This coupon is not available right now",
                                                );
                                            }
                                        } else {
                                            if(Session::has('coupons')){
                                                self::removeSessionCoupon($coupon->code);
                                            }
                                            return array(
                                                'status' => "error",
                                                'message' => "This coupon is available for products without offer",
                                            );
                                        }
                                    } else {
                                        if(Session::has('coupons')){
                                            self::removeSessionCoupon($coupon->code);
                                        }
                                        return array(
                                            'status' => "error",
                                            'message' => "This coupon is available only for selected customers",
                                        );
                                    }
                                } else {
                                    if(Session::has('coupons')){
                                        self::removeSessionCoupon($coupon->code);
                                    }
                                    return array(
                                        'status' => "error",
                                        'message' => "Person usage limit exceeded",
                                    );
                                }
                            } else {
                                if(Session::has('coupons')){
                                    self::removeSessionCoupon($coupon->code);
                                }
                                return array(
                                    'status' => "error",
                                    'message' => "Please fill shipping and billing address to avail this coupon",
                                );
                            }
                        } else {
                            if(Session::has('coupons')){
                                self::removeSessionCoupon($coupon->code);
                            }
                            return array(
                                'status' => "error",
                                'message' => "Coupon usage limit exceeded",
                            );
                        }
                    } else {
                        if(Session::has('coupons')){
                            self::removeSessionCoupon($coupon->code);
                        }
                        return array(
                            'status' => 'error',
                            'message' => "Purchase amount must be above " . $currency . ' ' . $coupon->minimum_spend ." and below " . $currency . ' ' . $coupon->maximum_spend,
                        );
                    }
                } else {
                    if(Session::has('coupons')){
                        self::removeSessionCoupon($coupon->code);
                    }
                    return array(
                        'status' => 'error',
                        'message' => "Coupon Expired",
                    );
                }
            } else {
                if(Session::has('coupons')){
                    self::removeSessionCoupon($coupon->code);
                }
                return array(
                    'status' => 'error',
                    'message' => "Can't use with other coupons",
                );
            }
        } else {
            if(Session::has('coupons')){
                self::removeSessionCoupon($coupon->code);
            }
            return array(
                'status' => 'error',
                'message' => "Coupon not found",
            );
        }
    }

    public static function getCouponProductIds($coupon)
    {
        $includedCategoryIds = $excludedCategoryIds = $includedProductIds = $excludedProductIds = [];
        if ($coupon->included_categories != NULL) {
            $includedCategoryIds = explode(',', $coupon->included_categories);
        }
        if ($coupon->excluded_categories != NULL) {
            $excludedCategoryIds = explode(',', $coupon->excluded_categories);
        }
        if ($coupon->included_products != NULL) {
            $includedProductIds = explode(',', $coupon->included_products);
        }
        if ($coupon->excluded_products != NULL) {
            $excludedProductIds = explode(',', $coupon->excluded_products);
        }
        if ($includedCategoryIds && $excludedProductIds) {
            $categoryIds = implode('|', $includedCategoryIds);
            $products = Product::active()->whereRaw('CONCAT(",", `sub_category_id`, ",") REGEXP ",(' . $categoryIds . '),"')->get();
            $couponProductIds = array_diff($products->pluck('id')->toArray(), $excludedProductIds);
        } elseif ($includedCategoryIds) {
            $categoryIds = implode('|', $includedCategoryIds);
            $products = Product::active()->whereRaw('CONCAT(",", `sub_category_id`, ",") REGEXP ",(' . $categoryIds . '),"')->get();
            $couponProductIds = $products->pluck('id')->toArray();
        } elseif ($excludedCategoryIds && $includedProductIds) {
            $allCategoryIds = Category::active()->whereNotNull('parent_id')->get()
                ->pluck('id')->toArray();
            $includedCategoryIds = array_diff($allCategoryIds, $excludedCategoryIds);
            $categoryIds = implode('|', $includedCategoryIds);
            $products = Product::active()->whereRaw('CONCAT(",", `sub_category_id`, ",") REGEXP ",(' . $categoryIds . '),"')->get();
            $couponProductIds = array_unique(array_merge($products->pluck('id')->toArray(), $includedProductIds));
        } elseif ($excludedCategoryIds) {
            $allCategoryIds = Category::active()->whereNotNull('parent_id')->get()
                ->pluck('id')->toArray();
            $includedCategoryIds = array_diff($allCategoryIds, $excludedCategoryIds);
            $categoryIds = implode('|', $includedCategoryIds);
            $products = Product::active()->whereRaw('CONCAT(",", `sub_category_id`, ",") REGEXP ",(' . $categoryIds . '),"')->get();
            $couponProductIds = $products->pluck('id')->toArray();
        } elseif ($includedProductIds) {
            $couponProductIds = $includedProductIds;
        } elseif ($excludedProductIds) {
            $products = Product::active()->whereNotIn('id', $excludedProductIds)->get();
            $couponProductIds = $products->pluck('id')->toArray();
        } else {
            $products = Product::active()->get();
            $couponProductIds = $products->pluck('id')->toArray();
        }
        return $couponProductIds;
    }

    public static function removeSessionCoupon($coupon_code)
    {
        $coupons = Session::get('coupons');

        foreach ($coupons as $key => $session_coupon) {
            if ($session_coupon['code'] == $coupon_code) {
                array_splice($coupons, $key, 1);
                Session::put('coupons', $coupons);
            }
        }
        if (empty(Session::get('coupons'))) {
            Session::forget('coupons');
            Session::forget('coupon_value');
        } else {
            $coupon_total_value = Helper::get_coupon_total_value();
            if ($coupon_total_value) {
                Session::put('coupon_value', $coupon_total_value);
            }
        }
    }

    public static function checkConfirmOrder()
    {
        $status = false;
        if (Auth::guard('customer')->check()) {
            if(Session::has('selected_customer_address')){
                session(['selected_billing_address' => Session::get('selected_customer_address')]);
                session(['selected_shipping_address' => Session::get('selected_customer_address')]);
                    }
            $customerAddress = Auth::guard('customer')->user()->customer->activeCustomerAddresses;

            if (Session::has('selected_billing_address') && Session::has('selected_shipping_address')) {

                $status = true;
            }

        } else {
            if (Session::has('billing_address') && Session::has('shipping_address')) {
                $status = true;
            }
        }
        return $status;
    }

    public static function OrderStatus($status)
    {
        if ($status == 'Processing') {
            $color = "#272D8B";
        } elseif ($status == "On Hold") {
            $color = "#11506B";
        } elseif ($status == "Delivery") {
            $color = "#156B11";
        } elseif ($status == "Completed") {
            $color = "#156C1A";
        } elseif ($status == "Cancelled") {
            $color = "#DE09F3";
        } elseif ($status == "Refunded") {
            $color = "#F0F309";
        } else {
            $color = "#F30925";
        }
        return $color;
    }


    public static function dealProducts($id)
    {
        if ($id == 0) {
            $deals = Deal::active()->where('offer_type', '!=', 'Normal')->get();
        } else {
            $deals = Deal::active()->where([['id', '!=', $id], ['offer_type', '!=', 'Normal']])->get();
        }
        $ids = [];
        foreach ($deals as $deal) {
            if (strpos($deal->products, ',') !== false) {
                $ids[] = explode(',', $deal->products);
            } else {
                $ids[0][] = $deal->products;
            }
        }
        $finalArray = [];
        if (!empty($ids)) {
            foreach ($ids as $id) {
                foreach ($id as $i) {
                    $finalArray[] = $i;
                }
            }
        }
        return $finalArray;
    }

    public static function addRecentProduct($product)
    {
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user()->customer;
            $recent_product = RecentlyViewedProduct::where(['customer_id' => $customer->id, 'product_id' => $product->id])->first();
            if ($recent_product) {
                $recent_product->updated_at = now();
                $recent_product->save();
            } else {
                $recent_product = RecentlyViewedProduct::create([
                    'customer_id' => $customer->id,
                    'product_id' => $product->id,
                ]);
            }
        }
    }
    public static function statusColour($status)
    {
        switch ($status) {
            case 'Processing':
                $colourClass = 'success';
                break;
            case 'Completed':
                $colourClass = 'success';
                break;
            case 'Failed':
                $colourClass = 'warning';
                break;
            case 'Cancelled':
                $colourClass = 'warning';
                break;
            case 'Returned':
                $colourClass = 'warning';
                break;
            default:
                $colourClass = 'success';
        }
        return $colourClass;
    }
    public static function getRecentProducts()
    {
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user()->customer;

            $prs =  Product::where('copy','no')->get();
            $pids = $prs->pluck('id')->toArray();   

            $recent_products = RecentlyViewedProduct::with('product')->where(['customer_id' => $customer->id])->whereIn('product_id',$pids)->latest('updated_at')->take(20)->get();
        } else {
            // return empty collection
            $recent_products = collect();
        }
        return $recent_products;
    }

    public static function addCompareProduct($product_id)
    {
        if (Session::has('compare_products')) {
            if (in_array($product_id, array_column(Session::get('compare_products'), 'product_id'))) {
                //if already present, remove
                self::removeCompareProduct($product_id);
                $status = 'removed';
            } else {
                Session::push('compare_products', ['product_id' => $product_id]);
                $status = 'added';
            }
        } else {
            Session::push('compare_products', ['product_id' => $product_id]);
            $status = 'added';
        }
        return $status;
    }


    public static function removeCompareProduct($product_id)
    {
        if (Session::has('compare_products')) {
            $compare_products = Session::get('compare_products');
            foreach ($compare_products as $key => $session_compare_product) {
                if ($session_compare_product['product_id'] == $product_id) {
                    array_splice($compare_products, $key, 1);
                    Session::put('compare_products', $compare_products);
                }
            }
            if (empty(Session::get('compare_products'))) {
                Session::forget('compare_products');
            }
        }
    }


// Product Rating Related
    public static function averageRating($productId)
    {
        $avgRating = ProductReview::active()->where('product_id', $productId)->avg('rating');
        return number_format($avgRating, 1);
    }


    public static function ratingProgress($productId)
    {
        $totalRating = self::averageRatingText($productId);
        $ratingText = 0;
        if ($totalRating > 0) {
            if ($totalRating == "1") {
                $ratingText = 20;
            } elseif ($totalRating == "2") {
                $ratingText = 40;
            } elseif ($totalRating == "3") {
                $ratingText = 60;
            } elseif ($totalRating == "4") {
                $ratingText = 80;
            } else {
                $ratingText = 100;
            }
        }
        return $ratingText;
    }

    public static function averageRatingText($productId)
    {
        $totalRating = self::averageRating($productId);
        $ratingText = '';
        $f = new NumberFormatter("in", NumberFormatter::SPELLOUT);
        $f->format($totalRating);
        if ($totalRating > 0) {
            if ($totalRating == "1") {
                $ratingText = 'one';
            } elseif ($totalRating == "2") {
                $ratingText = 'two';
            } elseif ($totalRating == "3") {
                $ratingText = 'three';
            } elseif ($totalRating == "4") {
                $ratingText = 'four';
            } else {
                $ratingText = 'five';
            }
        }
        return $ratingText;
    }

    public static function ratingCount($productId, $rating = null)
    {
        if ($rating) {
            $reviewCount = ProductReview::active()->where('product_id', $productId)->where('rating', $rating)->count();
        } else {
            $reviewCount = ProductReview::active()->where('product_id', $productId)->count();
        }
        return $reviewCount;
    }
    public static function reviewCount($productId)
    {
        $reviewCount = ProductReview::active()->where('product_id', $productId)->whereNotNull('review')->count();
        return $reviewCount;
    }
    public static function getReviewUserImage($email)
    {
        $user = User::where('email', $email)->first();
        $image = '<img src="' . asset('frontend/images/user_img_de.png') . '" alt="">';
        if ($user) {
            $image = self::printImage($user, 'profile_image', 'profile_image_webp', 'image_attribute');
        }
        return $image;
    }

    public static function categoryUrl($categoryId)
    {
        $category = Category::find($categoryId);
        $htm = '';
        if ($category) {
            $htm = $category->short_url;
        }
        return $htm;
    }

    public static function categoryName($categoryId)
    {
        $category = Category::find($categoryId);
        $htm = '';
        if ($category) {
            $htm = $category->title;
        }
        return $htm;
    }
    public static function cargoryId($categoryId)
    {
        $category = Category::find($categoryId);
        $htm = '';
        if ($category) {
            $htm = $category->id;
        }
        return $htm;
    }


    public static function categoryImage($categoryId)
    {
        $category = Category::find($categoryId);
        $htm = '';
        if ($category) {
            $htm = $category->image;
        }
        return $htm;
    }




    public  static  function combinationArrays($chars, $size, $combinations = array())
    {
        if (empty($combinations)) {
            $combinations = $chars;
        }
        if ($size == 1) {
            return $combinations;
        }
        $new_combinations = array();
        foreach ($combinations as $combination) {
            foreach ($chars as $char) {
                if ($combination != $char) {
                    $new_combinations[$combination][] = $char;
                }
            }
        }
        return $this->combinationArrays($chars, $size - 1, $new_combinations);
    }

    public static function getMinPrice()
    {
        $price = 0;
        $product = Product::where('status', 'Active')->pluck('id')->toArray();
        $getPrice = ProductPrice::whereIn('product_id',$product)->min('price');

        
        if ($getPrice)
            $price = $getPrice;
        return $price;
    }

    public static function getMaxPrice()
    {
        $price = 0;
        $product = Product::where('status', 'Active')->pluck('id')->toArray();
        $getPrice =ProductPrice::whereIn('product_id',$product)->max('price');

        if ($getPrice)
            $price = $getPrice;
        return $price;
    }

    public function Banner(){
        $first_image = Banner::first()->about_first_bottom_image;
        $first_image_text = Banner::first()->about_first_bottom_image_text;
        $second_image = Banner::first()->about_second_bottom_image;
        $second_image_text = Banner::first()->about_second_bottom_image_text;
        $third_image = Banner::first()->about_third_bottom_image;
        $third_image_text = Banner::first()->about_third_bottom_image_text;
        

    }
}
