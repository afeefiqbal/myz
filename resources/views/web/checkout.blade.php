@extends('web.layouts.main')
@section('content')
<section class="breadscrumb-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="breadscrumb-contain">
                    <h2>Checkout</h2>
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="index.php">
                                    <i class="fa-solid fa-house"></i>
                                </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Checkout section Start -->
<section class="checkout-section section-b-space">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">
            <div class="col-xxl-3 col-lg-4">
                <!-- Nav tabs -->
                <ul class="nav nav-pills nav-justified custom-navtab" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <div class="nav-link active" id="shopping-cart" data-bs-toggle="tab"
                            data-bs-target="#s-cart" role="tab">
                            <div class="nav-item-box">
                                <div>
                                    <span>STEP 1</span>
                                    <h4>Shopping Cart</h4>
                                </div>
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                    trigger="loop-on-hover"
                                    colors="primary:#121331,secondary:#646e78,tertiary:#0baf9a" class="lord-icon">
                                </lord-icon>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item" role="presentation">
                        <div class="nav-link" id="delivery-address" data-bs-toggle="tab" data-bs-target="#d-address"
                            role="tab">
                            <div class="nav-item-box">
                                <div>
                                    <span>STEP 2</span>
                                    <h4>Delivery Address</h4>
                                </div>
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/oaflahpk.json"
                                    trigger="loop-on-hover" colors="primary:#0baf9a" class="lord-icon">
                                </lord-icon>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item" role="presentation">
                        <div class="nav-link" id="delivery-option" data-bs-toggle="tab" data-bs-target="#d-options"
                            role="tab">
                            <div class="nav-item-box">
                                <div>
                                    <span>STEP 3</span>
                                    <h4>Delivery Options</h4>
                                </div>
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/jyijxczt.json"
                                    trigger="loop-on-hover"
                                    colors="primary:#3a3347,secondary:#0baf9a,tertiary:#ebe6ef,quaternary:#646e78"
                                    class="lord-icon">
                                </lord-icon>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item" role="presentation">
                        <div class="nav-link" id="payment-option" data-bs-toggle="tab" data-bs-target="#p-options"
                            role="tab">
                            <div class="nav-item-box">
                                <div>
                                    <span>STEP 4</span>
                                    <h4>Payment Options</h4>
                                </div>
                                <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                    trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a"
                                    class="lord-icon">
                                </lord-icon>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>

            <div class="col-xxl-9 col-lg-8">
                <!-- Tab panes -->
                <div class="tab-content" id="progressBar">
                    <div class="tab-pane active" id="s-cart" role="tabpanel" aria-labelledby="shopping-cart">
                        <h2 class="tab-title">Shopping Cart</h2>
                        <div class="cart-table p-0">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr class="product-box-contain">
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <a href="product-left.php" class="product-image">
                                                        <img src="https://img.freepik.com/free-vector/wifi-router-front-side-view-mockup_107791-5061.jpg?w=1060&t=st=1705510903~exp=1705511503~hmac=3cc0dafdb9f9020d8c28f83b575bb11ed268ee18341cab188b9a7482cd0b124b"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>
                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="name">
                                                                <a href="product-left.php" class="text-title">iMac</a>
                                                            </li>

                                                            <li class="text-content"><span class="text-title">Sold
                                                                    By :</span> Fresho</li>

                                                            <li class="text-content"><span
                                                                    class="text-title"></span> </li>

                                                            <li>
                                                                <h5 class="text-content d-inline-block">Price :</h5>
                                                                <span>$35.10</span>
                                                                <span class="text-content">$45.68</span>
                                                            </li>

                                                            <li>
                                                                <h5 class="saving theme-color">Saving : $20.68</h5>
                                                            </li>

                                                            <li class="quantity-price-box">
                                                                <div class="cart_qty">
                                                                    <div class="input-group">
                                                                        <button type="button" class="qty-left-minus"
                                                                            data-type="minus" data-field="">
                                                                            <i class="fa fa-minus"
                                                                                aria-hidden="true"></i>
                                                                        </button>
                                                                        <input
                                                                            class="form-control input-number qty-input"
                                                                            type="text" name="quantity" value="0">
                                                                        <button type="button" class="qty-right-plus"
                                                                            data-type="plus" data-field="">
                                                                            <i class="fa fa-plus"
                                                                                aria-hidden="true"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <h5>Total: $35.10</h5>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price">
                                                <h4 class="table-title text-content">Price</h4>
                                                <h5>$35.10 <del class="text-content">$45.68</del></h5>
                                                <h6 class="theme-color">You Save : $20.68</h6>
                                            </td>

                                            <td class="quantity">
                                                <h4 class="table-title text-content">Qty</h4>
                                                <div class="quantity-price">
                                                    <div class="cart_qty">
                                                        <div class="input-group">
                                                            <button type="button" class="qty-left-minus"
                                                                data-type="minus" data-field="">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input"
                                                                type="text" name="quantity" value="0">
                                                            <button type="button" class="qty-right-plus"
                                                                data-type="plus" data-field="">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="subtotal">
                                                <h4 class="table-title text-content">Total</h4>
                                                <h5>$35.10</h5>
                                            </td>

                                            <td class="save-remove">
                                                <h4 class="table-title text-content">Action</h4>
                                                <a class="save notifi-wishlist" href="javascript:void(0)">Save for
                                                    later</a>
                                                <a class="remove close_button" href="javascript:void(0)">Remove</a>
                                            </td>
                                        </tr>

                                        <tr class="product-box-contain">
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <a href="product-left.php" class="product-image">
                                                        <img src="https://img.freepik.com/free-vector/computer-design_1156-101.jpg?w=740&t=st=1705511015~exp=1705511615~hmac=41f974635ff936b954216109c3399797c60d3db7424ea32b8fc9e565e2d6f1fc"
                                                            class="img-fluid blur-up lazyload" alt="">
                                                    </a>
                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="name">
                                                                <a href="product-left.php"
                                                                    class="text-title">iPhone</a>
                                                            </li>

                                                            <li class="text-content"><span class="text-title">Sold
                                                                    By :</span> Nesto</li>

                                                            <li class="text-content"><span
                                                                    class="text-title"></span> </li>

                                                            <li>
                                                                <h5 class="text-content d-inline-block">Price :</h5>
                                                                <span>$35.10</span>
                                                                <span class="text-content">$45.68</span>
                                                            </li>

                                                            <li>
                                                                <h5 class="saving theme-color">Saving : $20.68</h5>
                                                            </li>

                                                            <li class="quantity">
                                                                <div class="quantity-price">
                                                                    <div class="cart_qty">
                                                                        <div class="input-group">
                                                                            <button type="button"
                                                                                class="qty-left-minus"
                                                                                data-type="minus" data-field="">
                                                                                <i class="fa fa-minus"
                                                                                    aria-hidden="true"></i>
                                                                            </button>
                                                                            <input
                                                                                class="form-control input-number qty-input"
                                                                                type="text" name="quantity"
                                                                                value="0">
                                                                            <button type="button"
                                                                                class="qty-right-plus"
                                                                                data-type="plus" data-field="">
                                                                                <i class="fa fa-plus"
                                                                                    aria-hidden="true"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>

                                                            <li>
                                                                <h5>Total: $52.95</h5>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price">
                                                <h4 class="table-title text-content">Price</h4>
                                                <h5>$52.95 <del class="text-content">$68.49</del></h5>
                                                <h6 class="theme-color">You Save : $15.14</h6>
                                            </td>

                                            <td class="quantity">
                                                <h4 class="table-title text-content">Qty</h4>
                                                <div class="quantity-price">
                                                    <div class="cart_qty">
                                                        <div class="input-group">
                                                            <button type="button" class="qty-left-minus"
                                                                data-type="minus" data-field="">
                                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                                            </button>
                                                            <input class="form-control input-number qty-input"
                                                                type="text" name="quantity" value="0">
                                                            <button type="button" class="qty-right-plus"
                                                                data-type="plus" data-field="">
                                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="subtotal">
                                                <h4 class="table-title text-content">Total</h4>
                                                <h5>$52.95</h5>
                                            </td>

                                            <td class="save-remove">
                                                <h4 class="table-title text-content">Action</h4>
                                                <a class="save notifi-wishlist" href="javascript:void(0)">Save for
                                                    later</a>
                                                <a class="remove close_button" href="javascript:void(0)">Remove</a>
                                            </td>
                                        </tr>

                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="button-group">
                            <ul class="button-group-list">
                                <li>
                                    <button onclick="location.href = 'index.php';"
                                        class="btn btn-light shopping-button text-dark"><i
                                            class="fa-solid fa-arrow-left-long ms-0"></i>Continue Shopping</button>
                                </li>

                                <li>
                                    <button class="btn btn-animation proceed-btn">Continue Delivery Address</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane" id="d-address" role="tabpanel" aria-labelledby="delivery-address">
                        <div class="d-flex align-items-center mb-3">
                            <h2 class="tab-title mb-0">Delivery Address</h2>
                            <button class="btn btn-animation btn-sm fw-bold ms-auto" type="button"
                                data-bs-toggle="modal" data-bs-target="#add-address">
                                <i class="fa-solid fa-plus d-block d-sm-none m-0"></i>
                                <span class="d-none d-sm-block">+ Add New</span>
                            </button>
                        </div>

                        <div class="row g-4">
                            <div class="col-xxl-6 col-lg-12 col-md-6">
                                <div class="delivery-address-box">
                                    <div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jack"
                                                id="flexRadioDefault1">
                                        </div>

                                        <div class="label">
                                            <label>Home</label>
                                        </div>

                                        <ul class="delivery-address-detail">
                                            <li>
                                                <h4 class="fw-500">Jack Jennas</h4>
                                            </li>

                                            <li>
                                                <p class="text-content"><span class="text-title">Address
                                                        : </span>8424 James Lane South San Francisco, CA 94080</p>
                                            </li>

                                            <li>
                                                <h6 class="text-content"><span class="text-title">Pin Code
                                                        :</span> +380</h6>
                                            </li>

                                            <li>
                                                <h6 class="text-content mb-0"><span class="text-title">Phone
                                                        :</span> + 380 (0564) 53 - 29 - 68</h6>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-md-6">
                                <div class="delivery-address-box">
                                    <div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jack"
                                                id="flexRadioDefault2" checked="checked">
                                        </div>

                                        <div class="label">
                                            <label>Office</label>
                                        </div>

                                        <ul class="delivery-address-detail">
                                            <li>
                                                <h4 class="fw-500">Jack Jennas</h4>
                                            </li>

                                            <li>
                                                <p class="text-content"><span class="text-title">Address
                                                        :</span>Nakhimovskiy R-N / Lastovaya Ul., bld. 5/A, appt. 12
                                                </p>
                                            </li>

                                            <li>
                                                <h6 class="text-content"><span class="text-title">Pin Code :</span>
                                                    +380</h6>
                                            </li>

                                            <li>
                                                <h6 class="text-content mb-0"><span class="text-title">Phone
                                                        :</span> + 380 (0564) 53 - 29 - 68</h6>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-group">
                            <ul class="button-group-list">
                                <li>
                                    <button class="btn btn-light shopping-button backward-btn text-dark">
                                        <i class="fa-solid fa-arrow-left-long ms-0"></i>Return To Shopping
                                        Cart</button>
                                </li>

                                <li>
                                    <button class="btn btn-animation proceed-btn">Continue Delivery Option</button>
                                </li>
                            </ul>

                        </div>
                    </div>

                    <div class="tab-pane" id="d-options" role="tabpanel" aria-labelledby="delivery-option">
                        <h2 class="tab-title">Delivery Option</h2>
                        <div class="row g-4">
                            <div class="col-12">
                                <div class="delivery-option">
                                    <div class="row g-4">
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-category">
                                                <div class="shipment-detail">
                                                    <div class="form-check custom-form-check">
                                                        <input class="form-check-input" type="radio" name="standard"
                                                            id="standard" checked>
                                                        <label class="form-check-label" for="standard">Standard
                                                            Delivery Option</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-items">
                                                <div>
                                                    <h5 class="items text-content"><span>3 Items</span> @ $693.48
                                                    </h5>
                                                    <h5 class="charge text-content">Delivery Charge $28.12
                                                        <button type="button" class="btn p-0"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Extra Charge">
                                                            <i class="fa-solid fa-circle-exclamation"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-md-12">
                                            <div class="select-option">
                                                <div class="form-floating theme-form-floating">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option value="0">TOMORROW 10:00 PM - 6:00 PM</option>
                                                        <option value="2">Tuesday 11:00 AM - 6:45 PM</option>
                                                        <option value="3">Wednesday 10:30 AM - 8:00 PM</option>
                                                    </select>
                                                    <label>Select Timing</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="delivery-option">
                                    <div class="row g-4">
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-category">
                                                <div class="shipment-detail">
                                                    <div class="form-check custom-form-check">
                                                        <input class="form-check-input" type="radio" name="standard"
                                                            id="sameDay">
                                                        <label class="form-check-label" for="sameDay">Same Day
                                                            Delivery Option</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-items">
                                                <div>
                                                    <h5 class="items text-content"><span>3 Items</span> @ $693.48
                                                    </h5>
                                                    <h5 class="charge text-content">Delivery Charge $32.15
                                                        <button type="button" class="btn p-0"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Extra Charge">
                                                            <i class="fa-solid fa-circle-exclamation"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-md-12">
                                            <div class="select-option">
                                                <div class="form-floating theme-form-floating">
                                                    <select class="form-select theme-form-select"
                                                        aria-label="Default select example">
                                                        <option value="0">TOMORROW 10:00 PM - 6:00 PM</option>
                                                        <option value="2">Tuesday 11:00 AM - 6:45 PM</option>
                                                        <option value="3">Wednesday 10:30 AM - 8:00 PM</option>
                                                    </select>
                                                    <label>Select Timing</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="delivery-option">
                                    <div class="row g-4">
                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-category">
                                                <div class="shipment-detail">
                                                    <div class="form-check mb-0 custom-form-check">
                                                        <input class="form-check-input" type="radio" name="standard"
                                                            id="future">
                                                        <label class="form-check-label" for="future">Future Delivery
                                                            Option</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-sm-6">
                                            <div class="delivery-items">
                                                <div>
                                                    <h5 class="items text-content"><span>3 Items</span> @ $693.48
                                                    </h5>
                                                    <h5 class="charge text-content">Delivery Charge $34.67
                                                        <button type="button" class="btn p-0"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            title="Extra Charge">
                                                            <i class="fa-solid fa-circle-exclamation"></i>
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-md-12">
                                            <form class="form-floating theme-form-floating date-box">
                                                <input type="date" class="form-control">
                                                <label>Select Date</label>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-group">
                            <ul class="button-group-list">
                                <li>
                                    <button class="btn btn-light shopping-button backward-btn text-dark">
                                        <i class="fa-solid fa-arrow-left-long ms-0"></i>Return To Delivery
                                        Address</button>
                                </li>

                                <li>
                                    <button class="btn btn-animation proceed-btn">Continue Payment Option</button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane" id="p-options" role="tabpanel" aria-labelledby="payment-option">
                        <h2 class="tab-title">Payment Option</h2>
                        <div class="row g-sm-4 g-2">
                            <div class="col-xxl-4 col-lg-12 col-md-5 order-xxl-2 order-lg-1 order-md-2">
                                <div class="summery-box">
                                    <div class="summery-header bg-white">
                                        <h3>Order Summery</h3>
                                        <a href="cart.php">Edit Cart</a>
                                    </div>

                                   
                                    <ul class="summery-total bg-white">
                                        <li>
                                            <h4>Subtotal</h4>
                                            <h4 class="price">$111.81</h4>
                                        </li>

                                        <li>
                                            <h4>Shipping</h4>
                                            <h4 class="price">$8.90</h4>
                                        </li>

                                        <li>
                                            <h4>Tax</h4>
                                            <h4 class="price">$29.498</h4>
                                        </li>

                                        <li>
                                            <h4>Coupon/Code</h4>
                                            <h4 class="price">$-23.10</h4>
                                        </li>

                                        <li class="list-total">
                                            <h4>Total (USD)</h4>
                                            <h4 class="price">$19.28</h4>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-xxl-8 col-lg-12 col-md-7 order-xxl-1 order-lg-2 order-md-1">
                                <div class="accordion accordion-flush custom-accordion" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <div class="accordion-header" id="flush-headingOne">
                                            <div class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseOne">
                                                <div class="custom-form-check form-check mb-0">
                                                    <label class="form-check-label" for="credit"><input
                                                            class="form-check-input mt-0" type="radio"
                                                            name="flexRadioDefault" id="credit" checked> Credit or
                                                        Debit Card</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row g-2">
                                                    <div class="col-12">
                                                        <div class="payment-method">
                                                            <div
                                                                class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                                <input type="text" class="form-control" id="credit2"
                                                                    placeholder="Enter Credit & Debit Card Number">
                                                                <label for="credit2">
                                                                    Enter Credit & Debit Card Number</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-4">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" id="expiry"
                                                                placeholder="Enter Expiry Date">
                                                            <label for="expiry">Expiry Date</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-4">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="text" class="form-control" id="cvv"
                                                                placeholder="Enter CVV Number">
                                                            <label for="cvv">CVV Number</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-xxl-4">
                                                        <div class="form-floating mb-lg-3 mb-2 theme-form-floating">
                                                            <input type="password" class="form-control"
                                                                id="password" placeholder="Enter Password">
                                                            <label for="password">Password</label>
                                                        </div>
                                                    </div>

                                                    <div class="button-group mt-0">
                                                        <ul>
                                                            <li>
                                                                <button
                                                                    class="btn btn-light shopping-button">Cancel</button>
                                                            </li>

                                                            <li>
                                                                <button class="btn btn-animation">Use This
                                                                    Card</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header" id="flush-headingTwo">
                                            <div class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseTwo">
                                                <div class="custom-form-check form-check mb-0">
                                                    <label class="form-check-label" for="banking"><input
                                                            class="form-check-input mt-0" type="radio"
                                                            name="flexRadioDefault" id="banking"> Net
                                                        Banking</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <h5 class="text-uppercase mb-4">Select Your Bank</h5>
                                                <div class="row g-2">
                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank1">
                                                            <label class="form-check-label" for="bank1">Industrial &
                                                                Commercial Bank</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank2">
                                                            <label class="form-check-label" for="bank2">Agricultural
                                                                Bank</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank3">
                                                            <label class="form-check-label" for="bank3">Bank of
                                                                America</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank4">
                                                            <label class="form-check-label" for="bank4">Construction
                                                                Bank Corp.</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank5">
                                                            <label class="form-check-label" for="bank5">HSBC
                                                                Holdings</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="bank6">
                                                            <label class="form-check-label" for="bank6">JPMorgan
                                                                Chase & Co.</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <div class="select-option">
                                                            <div class="form-floating theme-form-floating">
                                                                <select class="form-select theme-form-select"
                                                                    aria-label="Default select example">
                                                                    <option value="hsbc">HSBC Holdings</option>
                                                                    <option value="loyds">Lloyds Banking Group
                                                                    </option>
                                                                    <option value="natwest">Nat West Group</option>
                                                                    <option value="Barclays">Barclays</option>
                                                                    <option value="other">Others Bank</option>
                                                                </select>
                                                                <label>Select Other Bank</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header" id="flush-headingThree">
                                            <div class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseThree">
                                                <div class="custom-form-check form-check mb-0">
                                                    <label class="form-check-label" for="wallet"><input
                                                            class="form-check-input mt-0" type="radio"
                                                            name="flexRadioDefault" id="wallet"> My Wallet</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <h5 class="text-uppercase mb-4">Select Your Wallet</h5>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <label class="form-check-label" for="amazon"><input
                                                                    class="form-check-input mt-0" type="radio"
                                                                    name="flexRadioDefault" id="amazon"> Amazon
                                                                Pay</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="gpay">
                                                            <label class="form-check-label" for="gpay">Google
                                                                Pay</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="airtel">
                                                            <label class="form-check-label" for="airtel">Airtel
                                                                Money</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="paytm">
                                                            <label class="form-check-label" for="paytm">Paytm
                                                                Pay</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="jio">
                                                            <label class="form-check-label" for="jio">JIO
                                                                Money</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="custom-form-check form-check">
                                                            <input class="form-check-input mt-0" type="radio"
                                                                name="flexRadioDefault" id="free">
                                                            <label class="form-check-label"
                                                                for="free">Freecharge</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="accordion-item">
                                        <div class="accordion-header" id="flush-headingFour">
                                            <div class="accordion-button collapsed" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapseFour">
                                                <div class="custom-form-check form-check mb-0">
                                                    <label class="form-check-label" for="cash"><input
                                                            class="form-check-input mt-0" type="radio"
                                                            name="flexRadioDefault" id="cash"> Cash On
                                                        Delivery</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="flush-collapseFour" class="accordion-collapse collapse"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <h5 class="cod-review">Pay digitally with SMS Pay Link. Cash may not
                                                    be accepted in COVID restricted areas. <a
                                                        href="javascript:void(0)">Know more.</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="button-group">
                            <ul class="button-group-list">
                                <li>
                                    <button class="btn btn-light shopping-button backward-btn text-dark">
                                        <i class="fa-solid fa-arrow-left-long ms-0"></i>Return To Delivery
                                        Option</button>
                                </li>

                                <li>
                                    <button onclick="location.href = 'order-success.php';"
                                        class="btn btn-animation">Done</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Checkout section End -->

<!-- Footer Section Start -->
<footer class="section-t-space">
    <div class="container-fluid-lg">
        <div class="service-section">
            <div class="row g-3">
                <div class="col-12">
                    <div class="service-contain">
                        <div class="service-box">
                            <div class="service-image">
                                <img src="https://themes.pixelstrap.com/fastkart/assets/svg/product.svg" class="blur-up lazyload" alt="">
                            </div>

                            <div class="service-detail">
                                <h5>Every Fresh Products</h5>
                            </div>
                        </div>

                        <div class="service-box">
                            <div class="service-image">
                                <img src="https://themes.pixelstrap.com/fastkart/assets/svg/delivery.svg" class="blur-up lazyload" alt="">
                            </div>

                            <div class="service-detail">
                                <h5>Free Delivery For Order Over $50</h5>
                            </div>
                        </div>

                        <div class="service-box">
                            <div class="service-image">
                                <img src="https://themes.pixelstrap.com/fastkart/assets/svg/discount.svg" class="blur-up lazyload" alt="">
                            </div>

                            <div class="service-detail">
                                <h5>Daily Mega Discounts</h5>
                            </div>
                        </div>

                        <div class="service-box">
                            <div class="service-image">
                                <img src="https://themes.pixelstrap.com/fastkart/assets/svg/market.svg" class="blur-up lazyload" alt="">
                            </div>

                            <div class="service-detail">
                                <h5>Best Price On The Market</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-footer section-b-space section-t-space">
            <div class="row g-md-4 g-3">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="footer-logo">
                        <div class="theme-logo">
                            <a href="index.php">
                                <img src="assets/images/logo/logo.jpeg" class="blur-up lazyload" alt="">
                            </a>
                        </div>

                        <div class="footer-logo-contain">
                            <p>In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to
                                demonstrate the visual form.</p>

                            <ul class="address">
                                <li>
                                    <i data-feather="home"></i>
                                    <a href="javascript:void(0)">1418 Riverwood Drive, CA 96052, US</a>
                                </li>
                                <li>
                                    <i data-feather="mail"></i>
                                    <a href="javascript:void(0)">support@fastkart.com</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="footer-title">
                        <h4>Categories</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            <li>
                                <a href="shop-left-sidebar.php" class="text-content">Vegetables & Fruit</a>
                            </li>
                            <li>
                                <a href="shop-left-sidebar.php" class="text-content">Beverages</a>
                            </li>
                            <li>
                                <a href="shop-left-sidebar.php" class="text-content">Meats & Seafood</a>
                            </li>
                            <li>
                                <a href="shop-left-sidebar.php" class="text-content">Frozen Foods</a>
                            </li>
                            <li>
                                <a href="shop-left-sidebar.php" class="text-content">Biscuits & Snacks</a>
                            </li>
                            <li>
                                <a href="shop-left-sidebar.php" class="text-content">Grocery & Staples</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl col-lg-2 col-sm-3">
                    <div class="footer-title">
                        <h4>Useful Links</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            <li>
                                <a href="index.php" class="text-content">Home</a>
                            </li>
                            <li>
                                <a href="shop-left-sidebar.php" class="text-content">Shop</a>
                            </li>
                            <li>
                                <a href="about-us.php" class="text-content">About Us</a>
                            </li>
                            <li>
                                <a href="blog-list.php" class="text-content">Blog</a>
                            </li>
                            <li>
                                <a href="contact-us.php" class="text-content">Contact Us</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-3">
                    <div class="footer-title">
                        <h4>Help Center</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            <li>
                                <a href="order-success.php" class="text-content">Your Order</a>
                            </li>
                            <li>
                                <a href="user-dashboard.php" class="text-content">Your Account</a>
                            </li>
                            <li>
                                <a href="order-tracking.php" class="text-content">Track Order</a>
                            </li>
                            <li>
                                <a href="wishlist.php" class="text-content">Your Wishlist</a>
                            </li>
                            <li>
                                <a href="search.php" class="text-content">Search</a>
                            </li>
                            <li>
                                <a href="faq.php" class="text-content">FAQ</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="footer-title">
                        <h4>Contact Us</h4>
                    </div>

                    <div class="footer-contact">
                        <ul>
                            <li>
                                <div class="footer-number">
                                    <i data-feather="phone"></i>
                                    <div class="contact-number">
                                        <h6 class="text-content">Hotline 24/7 :</h6>
                                        <h5>+91 888 104 2340</h5>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="footer-number">
                                    <i data-feather="mail"></i>
                                    <div class="contact-number">
                                        <h6 class="text-content">Email Address :</h6>
                                        <h5>fastkart@hotmail.com</h5>
                                    </div>
                                </div>
                            </li>

                            <li class="social-app">
                                <h5 class="mb-2 text-content">Download App :</h5>
                                <ul>
                                    <li class="mb-0">
                                        <a href="https://play.google.com/store/apps" target="_blank">
                                            <img src="https://themes.pixelstrap.com/fastkart/assets/images/playstore.svg" class="blur-up lazyload"
                                                alt="">
                                        </a>
                                    </li>
                                    <li class="mb-0">
                                        <a href="https://www.apple.com/in/app-store/" target="_blank">
                                            <img src="https://themes.pixelstrap.com/fastkart/assets/images/appstore.svg" class="blur-up lazyload"
                                                alt="">
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="sub-footer section-small-space">
            <div class="reserve">
                <h6 class="text-content">©2022 Fastkart All rights reserved</h6>
            </div>

            <div class="payment">
                <img src="assets/images/payment/1.png" class="blur-up lazyload" alt="">
            </div>

            <div class="social-link">
                <h6 class="text-content">Stay connected :</h6>
                <ul>
                    <li>
                        <a href="https://www.facebook.com/" target="_blank">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/" target="_blank">
                            <i class="fa-brands fa-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/" target="_blank">
                            <i class="fa-brands fa-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a href="https://in.pinterest.com/" target="_blank">
                            <i class="fa-brands fa-pinterest-p"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<!-- Location Modal Start -->
<div class="modal location-modal fade theme-modal" id="locationModal" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose your Delivery Location</h5>
                <p class="mt-1 text-content">Enter your address and we will specify the offer for your area.</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="location-list">
                    <div class="search-input">
                        <input type="search" class="form-control" placeholder="Search Your Area">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="disabled-box">
                        <h6>Select a Location</h6>
                    </div>

                    <ul class="location-select custom-height">
                        <li>
                            <a href="javascript:void(0)">
                                <h6>Alabama</h6>
                                <span>Min: $130</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Arizona</h6>
                                <span>Min: $150</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>California</h6>
                                <span>Min: $110</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Colorado</h6>
                                <span>Min: $140</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Florida</h6>
                                <span>Min: $160</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Georgia</h6>
                                <span>Min: $120</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Kansas</h6>
                                <span>Min: $170</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Minnesota</h6>
                                <span>Min: $120</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>New York</h6>
                                <span>Min: $110</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Washington</h6>
                                <span>Min: $130</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Location Modal End -->

<!-- Add address modal box start -->
<div class="modal fade theme-modal" id="add-address" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel1">Add a new address</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="fname" placeholder="Enter First Name">
                        <label for="fname">First Name</label>
                    </div>
                </form>

                <form>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="text" class="form-control" id="lname" placeholder="Enter Last Name">
                        <label for="lname">Last Name</label>
                    </div>
                </form>

                <form>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="email" class="form-control" id="email" placeholder="Enter Email Address">
                        <label for="email">Email Address</label>
                    </div>
                </form>

                <form>
                    <div class="form-floating mb-4 theme-form-floating">
                        <textarea class="form-control" placeholder="Leave a comment here" id="address"
                            style="height: 100px"></textarea>
                        <label for="address">Enter Address</label>
                    </div>
                </form>

                <form>
                    <div class="form-floating mb-4 theme-form-floating">
                        <input type="email" class="form-control" id="pin" placeholder="Enter Pin Code">
                        <label for="pin">Pin Code</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-md" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn theme-bg-color btn-md text-white" data-bs-dismiss="modal">Save
                    changes</button>
            </div>
        </div>
    </div>
</div>
<!-- Add address modal box end -->


<!-- Deal Box Modal Start -->
<div class="modal fade theme-modal deal-modal" id="deal-box" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title w-100" id="deal_today">Deal Today</h5>
                    <p class="mt-1 text-content">Recommended deals for you.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="deal-offer-box">
                    <ul class="deal-offer-list">
                        <li class="list-1">
                            <div class="deal-offer-contain">
                                <a href="shop-left-sidebar.php" class="deal-image">
                                    <img src="assets/images/vegetable/product/10.png" class="blur-up lazyload"
                                        alt="">
                                </a>

                                <a href="shop-left-sidebar.php" class="deal-contain">
                                    <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>
                                    <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>
                                </a>
                            </div>
                        </li>

                        <li class="list-2">
                            <div class="deal-offer-contain">
                                <a href="shop-left-sidebar.php" class="deal-image">
                                    <img src="assets/images/vegetable/product/11.png" class="blur-up lazyload"
                                        alt="">
                                </a>

                                <a href="shop-left-sidebar.php" class="deal-contain">
                                    <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>
                                    <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>
                                </a>
                            </div>
                        </li>

                        <li class="list-3">
                            <div class="deal-offer-contain">
                                <a href="shop-left-sidebar.php" class="deal-image">
                                    <img src="assets/images/vegetable/product/12.png" class="blur-up lazyload"
                                        alt="">
                                </a>

                                <a href="shop-left-sidebar.php" class="deal-contain">
                                    <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>
                                    <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>
                                </a>
                            </div>
                        </li>

                        <li class="list-1">
                            <div class="deal-offer-contain">
                                <a href="shop-left-sidebar.php" class="deal-image">
                                    <img src="assets/images/vegetable/product/13.png" class="blur-up lazyload"
                                        alt="">
                                </a>

                                <a href="shop-left-sidebar.php" class="deal-contain">
                                    <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>
                                    <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {

        //make checkbox unchecked
        // $('.different_shipping_address').prop('checked', false);
        if($(".different_shipping_address").is(':checked')){
            var choose = "different";
            $('.billiing_address_form').removeClass("d-none");
            $('.choose').val("different");

    } else {
        var choose = "same";
            $('.billiing_address_form').addClass("d-none");
            $('.choose').val("same");

    }
    });
    //check if checkbox is checked or not
    $(document).on('click', '.different_shipping_address', function (e) {
        if($(this).is(':checked')){
            var choose = "different";
            $('.billiing_address_form').removeClass("d-none");
            $('.choose').val("different");
        }
        else{
            var choose = "same";
            $('.billiing_address_form').addClass("d-none");
            $('.choose').val("same");
        }
    });
        //for selecting different address for shipping
        $(document).on('change', '.different_shipping_address', function (e) {
            e.preventDefault();
            $this = $(this);
            var different_status = $this.is(':checked');
            $.ajax({
                type: 'POST', dataType: 'json', data: {different_status}, headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/different-shipping-address', success: function (response) {

                    if (response.status == true  ) {
                    console.log(response);
                        Toast.fire("", response.message, "success");
                    //make all fields readonly
                    if(response.orderC == true){
                        $('.error').addClass("d-none");

                    }
                    else{
                        $('.error').removeClass("d-none");
                    }
                    if(response.type == 'same'){
                        $('.billiing_address_form').addClass("d-none");
                        $('#addBillingForm input').val('');
                        //select box empty
                        $('#addBillingForm select').val('');
                        $('#addBillingForm textarea').val('');
                        $('#addBillingForm span').html('');
                        $('.error').addClass("d-none");
                        $('#billingAddressChoose').val('same');
                        //remove disabled attribute from confirm payment button
                        $('#confirm_payment').attr('disabled', false);
                    }
                    else{
                        $('.billiing_address_form').removeClass("d-none");
                        $('#addBillingForm input').val('');
                        $('.error').removeClass("d-none");
                        $('#billingAddressChoose').val('different');
                        $('#confirm_payment').attr('disabled', true);
                    }
                    if(response.reload == true){
                        setTimeout(() => {
                            // location.reload();
                        }, 1000);
                    }
                    } else {
                        if(response.orderC == true){
                        $('.error').addClass("d-none");

                    }
                    else{
                        $('.error').removeClass("d-none");
                    //empty all  in addBillingForm form
                    $(':input').val('');



                    }
                    if(response.type == 'same'){
                            $('.billiing_address_form').addClass("d-none");

                            $('#confirm_payment').attr('disabled', false);
                        }
                        else{

                            $('.billiing_address_form').removeClass("d-none");
                            $('#confirm_payment').attr('disabled', true);
                        }


                        Toast.fire('Error', response.message, "error");
                    }
                    setTimeout(() => {
                        // location.reload();

                    }, 1500);
                }
            });
        });
</script>
@endpush
