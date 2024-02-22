<!--Cart List Start-->

@php
$sessionKey  =  Helper::getSessionKey();
@endphp
<style>
    .cart-error{
        padding: 36px;
    padding-top: 5px;
    color: red;
    }
    .cart-success{
        padding: 36px;
    padding-top: 5px;
    color: green;
    }
</style>
<div class="offcanvas offcanvas-end cartListRight side_cart" tabindex="-1" id="cartListRight" aria-labelledby="offcanvasRightLabel">
@include('web.includes.side_cart')
</div>

<!--Cart List End-->
