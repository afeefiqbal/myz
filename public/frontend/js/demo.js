$(document).ready(function () {
  
    var urlLastSegment = window.location.pathname.split("/").pop();
    $(".customerMessageField").bind("click keypress paste", function(e) {
        var val = $(this).val();
        var spaceVal = val.split(" ");
        if(spaceVal.length > 59)
            e.preventDefault();
    });

    if (window.location.hash && window.location.hash == '#_=_') {
        if (window.history && history.pushState) {
            window.history.pushState("", document.title, window.location.pathname);
        } else {
            // Prevent scrolling by storing the page's current scroll offset
            var scroll = {
                top: document.body.scrollTop, left: document.body.scrollLeft
            };
            window.location.hash = '';
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scroll.top;
            document.body.scrollLeft = scroll.left;
        }
    }

// $(".my-rating-readonly").starRating({
    //     totalStars: 5,
    //     starShape: 'rounded',
    //     starSize: 15,
    //     emptyColor: 'lightgray',
    //     hoverColor: '#FAB63C',
    //     activeColor: '#FAB63C',
    //     useGradient: false,
    //     readOnly: true,
    // });

    // $(".my-rating").starRating({
    //     totalStars: 5,
    //     starShape: 'rounded',
    //     starSize: 26,
    //     emptyColor: 'lightgray',
    //     hoverColor: '#FAB63C',
    //     activeColor: 'lightgray',
    //     ratedColor: '#FAB63C',
    //     useGradient: false,
    //     disableAfterRate: false,
    //     useFullStars: true,
    //     callback: function (currentRating, $el) {
    //         $('#rating').val(currentRating);
    //         // console.log('DOM element ', $el);
    //     }
    // });

    // $('.rtl-slider').slick({
    //     slidesToShow: 1, slidesToScroll: 1, arrows: false, fade: true, asNavFor: '.rtl-slider-nav'
    // });
    // $('.rtl-slider-nav').slick({
    //     slidesToShow: 4,
    //     slidesToScroll: 1,
    //     vertical: true,
    //     asNavFor: '.rtl-slider',
    //     centerMode: false,
    //     focusOnSelect: true,
    //     prevArrow: ".thumb-prev",
    //     nextArrow: ".thumb-next",
    // });



    $('.navigation-link').on('mouseover', function () {
        $(this).css({'cursor': 'pointer'});
    });

    $('.navigation-link').on('click', function () {
        var link = $(this).data('url');
        var type = $(this).data('type');
        window.location.href = base_url + '/' + type + '/' + link;
    });

    $(document).mouseup(function (e) {
        // $('#search-result-append-here').removeClass('d-none');

        var container = $("#product-main-search");
        // if the target of the click isn't the container nor a descendant of the container
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            $('.results').hide();
        }
    });



     //add or edit address button in profile address page
     $(document).on('click', '.address-form', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
            type: 'POST', dataType: 'html', data: {id}, headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/customer/address-form', success: function (response) {
                if (response != '0') {
                    $('#my_address_add_form').html(response);
                    $('#my_address_list').addClass('d-none');
                    $('#my_address_add_form').removeClass('d-none');
                } else {
                    swal.fire({
                        title: "Error", text: "Error while load the form", icon: 'error'
                    });
                }
            }
        });
    });

    $('#dropDown').click(function () {
        $('.drop-down').toggleClass('drop-down--active');
    });

    $(document).on('change', '.lang-change', function () {
        var language = $(this).find(':selected').data('lang');
        var language_code = $(this).find(':selected').data('lang_code');
        $.ajax({
            type: 'POST', dataType: 'json', data: {language, language_code}, headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/set-language', success: function (response) {
                if (response.status === true) {
                    Toast.fire({
                        title: "", text: response.message, icon: "success"
                    })
                    location.reload();
                } else {
                    Toast.fire('Error', 'Can\'t change the language', "error");
                }
            }
        });
    });

    $(document).on('click', '.tabLink', function () {
        var tab = $(this).data('tab');
        if (tab == "wishlist") {
            $('#latestProductsList').show();
        } else {
            $('#latestProductsList').hide();
        }
    });

  

    $(document).on('click', '.login-popup-modal', function () {
        $('#loginModal').modal('show');
    });




    $(document).on('click', '.contact_form_btn', function (e) {
        e.preventDefault();
        var buttonText = $(this).html();
        var url = $(this).data('url');
        var form_id = $(this).closest("form").attr('id');
        var modal_id = $(this).closest(".modal").attr('id');
        var formData = new FormData(document.getElementById(form_id));
        var errors = false;
        $('form input, form textarea').removeClass('is-invalid is-valid');
        $('span.error').remove();
        $("#" + form_id + " .required").each(function (k, v) {
            var field_name = $(v).attr('name');
            if (!$(v).val().length) {
                errors = true;
                var error = 'Please enter <strong>' + field_name + '</strong>.';
                var msg = '<span class="error invalid-feedback" style="color: red" for="' + field_name + '">' + error + '</span>';
                $('#' + form_id).find('input[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                    .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
            } else {
                if (field_name === 'email') {
                    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    if (!regex.test($(v).val())) {
                        errors = true;
                        msg = '<span class="error invalid-feedback" style="color: red" for="email">Please enter a valid email address</span>';
                        $('#' + form_id).find('input[name="' + field_name + '"]')
                            .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                    }
                }
            }
        });
        if (!errors) {
            $('.contact_form_btn').html(waitText);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: base_url + url,
            })
                .done(function (response) {
                    $('.contact_form_btn').html(buttonText);
                    if (response.status === "success") {
                        $("#" + form_id)[0].reset();
                        if (modal_id) {
                            $("#" + modal_id).hide();
                        }
                        Toast.fire({
                            title: "", text: response.message, icon: "success"
                        })
                        location.reload();
                    } else if (response.status == "login-success") {
                        Toast.fire({
                            title: "Success!", text: response.message, icon: "success"
                        })
                        $("#" + form_id)[0].reset();
                        location.reload();
                    } else {
                        Toast.fire({
                            title: response.status, text: response.message, icon: "success"
                        })
                    }
                })
                .fail(function (response) {
                    $('.contact_form_btn').html(buttonText);
                    $.each(response.responseJSON.errors, function (field_name, error) {
                        var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                        $("#" + form_id).find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                            .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                    });
                })
        }
    });

    $(document).on('click', '.apply_job', function () {
        var id = $(this).data('id');
        $('#job_id').val(id);
    });

    $('#proceed_to_checkout').on('click', function () {
        window.location.href = base_url + '/checkout';
    });

    $(document).on('click', '.service_enquiry_btn', function () {
        var id = $(this).data('id');
        $('#service_id').val(id);
    });

    $(document).on('click', '#change_password_btn', function () {
       
        if ($('#editPro').css('display') === 'block') {
            $(this).html(editProfile);
            $('#editPro').css('display', 'none');
            $('#editPass').css('display', 'block');
        } else {
            $(this).html(changePassword);
            $('#editPro').css('display', 'block');
            $('#editPass').css('display', 'none');
        }
    });

    // $(document).on('change', '#country', function () {
    //     var country_id = $(this).val();
    //     if (country_id) {
    //         $.ajax({
    //             type: 'POST', dataType: 'json', url: base_url + '/customer/state-list', data: {country_id}, headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }, success: function (data) {
    //                 if (data.status == false) {
    //                     Toast.fire('Error', data.message, "error");
    //                 } else {
    //                     if (data.states.length > 0) {
    //                         $("#state").empty();
    //                         $('#state').append('<option value="">Select State</option>');
    //                         $.each(data.states, function (key, value) {
    //                             $('#state').append('<option value="' + value.id + '"' + '>' + value.title + '</option>');
    //                         });
    //                     } else {
    //                         $('#state').append('<option value="">No States Available</option>');
    //                     }
    //                 }
    //             }
    //         })
    //     }
    // });


    // $(document).on('change', '#shipping_country', function () {
    //     console.log('yes');
    //     var country_id = $(this).val();
    //     console.log(country_id);
    //     console.log('yes');
    //     if (country_id) {
    //         $.ajax({
    //             type: 'POST', dataType: 'json', url: base_url + '/state-list', data: {country_id}, headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }, success: function (data) {
    //                 if (data.status == false) {
    //                     Toast.fire('Error', data.message, "error");
    //                 } else {
    //                     if (data.states.length > 0) {
    //                         $("#shipping_state").empty();
    //                         $('#shipping_state').append('<option value="">Select State</option>');
    //                         $.each(data.states, function (key, value) {
    //                             $('#shipping_state').append('<option value="' + value.id + '"' + '>' + value.title + '</option>');
    //                         });
    //                     } else {
    //                         $('#shipping_state').append('<option value="">No States Available</option>');
    //                     }
    //                 }
    //             }
    //         })
    //     }
    // });

    // $(document).on('change', '#shipping_state', function () {
    //     var state_id = $(this).val();
    //     if (state_id) {
    //         $.ajax({
    //             type: 'POST',async:false, dataType: 'json', url: base_url + '/get-value', data: {state_id}, headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }, success: function (data) {
    //                 if (data.status == false) {
    //                     Toast.fire('Error !', data.message, "error");
    //                 } else {
    //                     console.log(data);
    //                 }
    //             }
    //         })
    //     }
    // });
    // $(document).on('change', '#billing_country', function () {
    //     var country_id = $(this).val();
    //     if (country_id) {
    //         $.ajax({
    //             type: 'POST',async:false, dataType: 'json', url: base_url + '/b-state-list', data: {country_id}, headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }, success: function (data) {
    //                 if (data.status == false) {
    //                     Toast.fire('Error !', data.message, "error");
    //                 } else {
    //                     if (data.states.length > 0) {
    //                         $("#billing_state").empty();
    //                         $('#billing_state').append('<option value="">Select State</option>');
    //                         $.each(data.states, function (key, value) {
    //                             $('#billing_state').append('<option value="' + value.id + '"' + '>' + value.title + '</option>');
    //                         });
    //                     } else {
    //                         $('#billing_state').append('<option value="">No States Available</option>');
    //                     }
    //                 }
    //             }
    //         })
    //     }
    // });

    /****************** cart action *************************/



    // $(document).on('click', '.wishlist-action', function () {
    //     var id = $(this).data('id');
    //     var size = $(this).data('size');
    //     var cart_id = $(this).data('cart_id');
    //     var type_id = $(this).data('product_type_id');
        
    //     $.ajax({
    //         type: 'POST', dataType: 'json', data: {product_id: id,type_id : type_id, size : size,cart_id : cart_id}, headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }, url: base_url + '/add-wishlist', success: function (response) {
    //             if (response.status == true) {
    //                 if (response.responseStatus == true) {
    //                     $('#wishlist_check_' + id).removeClass('fill');
    //                     $('#wishlist_check_span_' + id).removeClass('fill');

    //                     if ($('#wishlistBox' + id).length > 0) {
    //                         $('#wishlistBox' + id).remove();
    //                     }
    //                 } else {
    //                     $('#wishlist_check_' + id).addClass('fill');
    //                     $('#wishlist_check_span_' + id).addClass('fill');

    //                 }
    //                 $('.wishlistCount').html(response.count);
    //                 $('.cartCount').html(response.cartCount);
    //                 if ($('#cartBox' + id).length > 0) {
    //                     $('#cartBox' + id).remove();
    //                 }
    //                 Toast.fire({
    //                     title: 'Success!', text: response.message, icon: 'success'
    //                 });
    //                 if (urlLastSegment == "cart" || urlLastSegment == "checkout" || urlLastSegment == "wishlist") {
    //                     location.reload();
    //                 }
    //             } else {
    //                 $('#wishlist_check_' + id).removeClass('fill');
    //                 $('#wishlist_check_span_' + id).removeClass('fill');

    //                 swal.fire({
    //                     title: "Oops", text: response.message, icon: "error"
    //                 });
    //             }
    //         }
    //     });
    // });





    $(document).on('click', '.login-popup', function () {
        var id = $(this).data('id');
        $('#wishlist_check_' + id).removeClass('fill');
        $('#loginModal').modal('show');
    });


    // $(document).on('click', '.deliver', function (e) {
        
    //     e.preventDefault();
    //     var id = $(this).data('id');
   
    //     $('.deliver').removeClass('active');
    //     var addressChoose = $('.addressChoose:checked').val();
    //     $(this).addClass('active');
    //     var _this = $(this);
    //     var remarks = $('#remark').val();
    //     // var _token = token;
    //     $.ajax({
    //         type: 'POST', dataType: 'json', data: {address_id: id, remarks: remarks}, headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }, url: base_url + '/select-customer-address', success: function (response) {
    //             if (response.status == true) {
    //                 Toast.fire({
    //                     title: "", text: response.response_message, icon: "success"
    //                 })
                  
    //                 if (response.status == true) {
                      
    //                 //     $('#address_select_error').addClass('d-none');
    //                     $('.error').addClass('d-none');
    //                     $('.confirm_payment_btn').attr('id','confirm_payment');
    //                 $('#confirm_payment').attr('disabled',false);
    //                 }else{
    //                     $('.confirm_payment_btn').removeAttr('id');
    //                     // $('#address_select_error').removeClass('d-none');
    //                     $('.error').removeClass('d-none');
    //                     $('#confirm_payment').attr('disabled',false);
    //                 }
    //                 $('.cod-charge').hide();

    //                 $('.shipping_amount').text(response.default_currency+' '+response.calculation_box.shippingAmount);
    //                 $('.tax_amount').text(response.default_currency+' '+response.calculation_box.tax_amount);
    //                 $('#grand_total_amount').val(response.calculation_box.final_total_with_tax);
    //                 $('.cart_final_total').text(response.default_currency+' '+response.calculation_box.final_total_with_tax);
    //                 // $('.session').removeClass('d-none');
    //                 if(response.message == false){

    //                     $('.address_session'+response.address_id).addClass('active');
                  
    //                     response.address_id_not_selected.forEach(function (item) {
                          
    //                         $('.address_session'+item).removeClass('active');
    //                     });
    //                     $('.login'+response.address_id).addClass('d-none');
                  
    //                     response.address_id_not_selected.forEach(function (item) {
                  
                          
    //                         $('.login'+item).removeClass('d-none');
    //                     });
    //                 }

    //                 // $('.login').removeClass('d-none');
                
              
    //                 $('#sameAdd').data('shipping-address',true);
               
                  
    //             } else {
    //                 Toast.fire('Error', response.response_message, "error");
    //                 _this.removeClass('active');
    //                 // $.notify(response.message, "error");
    //             }
    //         }
    //     });
    // });


    // $(document).on('click', '.billing', function (e) {
    //     e.preventDefault();
    //     var id = $(this).data('id');
    //     var remarks = $('#remark').val();
    //     // var _token = token;
    //     $('.billing').removeClass('active');
    //     $(this).addClass('active');
    //     $.ajax({
    //         type: 'POST', dataType: 'json', data: {address_id: id, remarks: remarks}, headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }, url: base_url + '/select-customer-billing-address', success: function (response) {
    //             if (response.status == true) {
    //                 Toast.fire({
    //                     title: "", text: 'Customer billing address selected successfully', icon: "success"
    //                 })
    //                 $('.error').addClass('d-none');
    //                 if (response.address_selected == true) {
    //                     $('.error').addClass('d-none');
    //                     $('.confirm_payment_btn').attr('id','confirm_payment');
    //                 $('#confirm_payment').attr('disabled',false);
    //                 }else{
    //                     $('.confirm_payment_btn').removeAttr('id');
    //                     // $('#address_select_error').removeClass('d-none');
    //                     $('.error').removeClass('d-none');
    //                     $('#confirm_payment').attr('disabled',false);
    //                 }
    //                 $('.session_billing'+response.address_id).addClass('active');
              
    //                 response.address_id_not_selected.forEach(function (item) {
    //                   console.log(item);
    //                     $('.session_billing'+item).removeClass('active');
    //                 });
    //                 $('.login_billing'+response.address_id).addClass('d-none');
              
    //                 response.address_id_not_selected.forEach(function (item) {
                      
                      
    //                     $('.login_billing'+item).removeClass('d-none');
    //                 });
                   
    //             } else {
    //                 $('.error').removeClass('d-none');
    //                 Toast.fire('Error', response.message, "error");
    //                 // $.notify(response.message, "error");
    //             }
    //         }
    //     });
    // });

    $(document).on('click', '.payment_method', function () {
        var payment_method = $(this).val();
        var finalAmount = $('#grand_total_amount').val();
        finalAmount = parseInt(finalAmount.replace(/\,/g, ''));
        $('.order-submit-loader').show();
        $.ajax({
            type: 'POST', dataType: 'json', data: {payment_method}, headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/cod-charge-apply', success: function (response) {
                $('.order-submit-loader').hide();
                if (response.status == true) {
                    if(payment_method=='cod'){
                        $('.cod-charge').show();
                        $('.cod-char').html(response.cost);
                        $('.cod-charge').html(response.currency + ' ' + response.cost);
                    }else{
                        $('.cod-charge').hide();
                    }
                    var finalTotal = parseFloat(finalAmount) + parseFloat(response.cost);
                    $('.cart_final_total').html(response.currency + ' ' + finalTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    Toast.fire('', response.message, "success");
                    if(response.cost!=0){
                       
                        $('.cod-char').html("("+response.currency + ' ' + response.cost+")");
                    }
                } else {
                    $('.cod-charge').hide();
                    finalAmount = parseFloat(finalAmount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    $('.cart_final_total').html(response.currency + ' ' + finalAmount);
                    $('#grand_total_amount').val(finalAmount);
                    if ($('.cod-charge').css('display') === 'flex') {
                        Toast.fire('', response.message, "success");
                        $('.cod-char').html("");
                    }
                }
            }
        });
    });

    $(document).on('click', '.payment_method', function () {
        var payment_method = $(this).val();
        var finalAmount = $('#grand_total_amount').val();
        finalAmount = parseInt(finalAmount.replace(/\,/g, ''));
        $('.order-submit-loader').show();
        $.ajax({
            type: 'POST', dataType: 'json', data: {payment_method}, headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/cod-charge-apply', success: function (response) {
                $('.order-submit-loader').hide();
                if (response.status == true) {
                    $('.cod-charge').show();
                    var finalTotal = parseFloat(finalAmount) + parseFloat(response.cost);
                    $('.cart_final_total').html(response.currency + ' ' + finalTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    Toast.fire('Done it!', response.message, "success");
                } else {
                    $('.cod-charge').hide();
                    finalAmount = parseFloat(finalAmount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    $('.cart_final_total').html(response.currency + ' ' + finalAmount);
                    $('#grand_total_amount').val(finalAmount);
                    if ($('.cod-charge').css('display') === 'flex') {
                        Toast.fire('Done it!', response.message, "success");
                    }
                }
            }
        });
    });
   

    /***************** cart action end **********************/

    $(document).on('click', '.submit-form-btn', function (e) {
        e.preventDefault();
        var btn_value = $(this).html();
        var email_id = $('#email').val();
        var required = [];
        var _token = token;
        var url = $(this).data('url');
        $('.required').each(function () {
            // console.log('.'+form_flag+'-required');
            var id = $(this).attr('id');
            // console.log(id);
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id).css({'border': '1px solid #FF0000'});
                $('#' + id + '_error').text('This Fiels is required');
            } else {
                $('#' + id).css({'border': '2px solid #707070;'});
                $('#' + id + '_error').text('');

            }
            var res = $("#CaptchaHidden").val();
            if (res == "" || res == undefined || res.length == 0) {
                if ($("#CaptchaHidden").next(".validation").length == 0) {
                    $("#CaptchaHidden").after("<div class='validation' style='color:#FF0000;font-weight: 700;margin-bottom: 14px;float:left;'>Please verify that you are not a robot</div>");
                }
            }
        });
        if (required.length == 0) {
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email_id)) {
                Toast.fire('Error', 'Please enter a valid email id' + email_id, "error");
                $('#email').css({'border': '1px solid #FF0000'});
            } else {
                // alert($('#'+form_flag+'Form').serialize());
                $(this).html('Please wait..!');
                $('.with-errors').html('');
                $.ajax({
                    type: 'POST', dataType: 'json', data: $('#sendMessage').serialize(), headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, url: base_url + '/' + url, success: function (response) {
                        $('.submit-form-btn').html(btn_value);
                        if (response.status == "success") {
                            Toast.fire({
                                title: "", text: response.message, icon: "success"
                            })
                            location.reload();
                            $('#sendMessage')[0].reset();
                        } else if (response.status == "error") {
                            $('#email').css({'border': '1px solid #FF0000'});
                        } else {
                            Toast.fire(response.status, response.message, response.status);
                        }
                    }
                });
            }
        }
    });


    $(document).on('click', '#contact_sbmt', function (e) {
        e.preventDefault();
        var _this = $(this);
        var btn_value = $(this).html();
        var email_id = $('#email').val();
        var required = [];
        var _token = token;
        var url = $(this).data('url');
        $('.contact-required').each(function () {
            var id = $(this).attr('id');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id).css({'border': '1px solid #FF0000'});
                $('#' + id + '_error').text('This Fiels is required');
            } else {
                $('#' + id).css({'border': '2px solid #707070;'});
                $('#' + id + '_error').text('');

            }
            var res = $("#CaptchaHidden").val();
            if (res == "" || res == undefined || res.length == 0) {
                if ($("#CaptchaHidden").next(".validation").length == 0) {
                    $("#CaptchaHidden").after("<div class='validation' style='color:#FF0000;font-weight: 700;margin-bottom: 14px;float:left;'>Please verify that you are not a robot</div>");
                }
            }
        });
        // if (required.length == 0) {
        //     var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        //     if (!regex.test(email_id)) {
        //         Toast.fire({
        //             title: "Error", text: 'Please enter a valid email id' + email_id, icon: 'error'
        //         });
        //         $('#email').css({'border': '1px solid #FF0000'});
        //     } else {
                // alert($('#'+form_flag+'Form').serialize());
                $(this).html('Please wait..!');
                $('.with-errors').html('');
                $(".contact-contents-left").find(".invalid-feedback").remove();
                $.ajax({
                    type: 'POST', dataType: 'json', data: $('#sendMessage').serialize(), headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, url: base_url + '/' + url,

                })
                    .done(function (response) {
                        _this.html(btn_value);
                        $('#register-form').val('Register');
                        if (response.status == "success") {
                            Toast.fire('', response.message, "success");
                            $('#sendMessage')[0].reset();
                            $("#sendMessage").find('.is-invalid').removeClass('is-invalid').attr("aria-invalid", "false");
                        } else if (response.status == "error") {
                            _this.html(btn_value);
                            // $('#register_email_id_error').html('Please enter a valid email ID').css({'color':'#FF0000','font-size':'14px','font-weight':'700'});
                            Toast.fire({
                                title: "Error", text: response.message, icon: 'error'
                            });
                        } else if (response.errors) {
                            _this.html(btn_value);
                            $('.alert-success').hide();
                            $('.alert-info').hide();
                            $('.alert-danger').show();
                            $('.alert-danger ul').html('');
                            for (var error in response.errors) {
                                $('.alert-danger').html(response.errors[error]);
                            }
                        }
                    })
                    .fail(function (response) {
                        _this.html(btn_value);
                        $('.invalid-feedback').html('');
                        $(".contact-contents-left").find(".invalid-feedback").remove();
                        $.each(response.responseJSON.errors, function (field_name, error) {
                            var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                            $("#sendMessage").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                                .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                        });
                    })

            // }
        // }

    });


    $(document).on('click', '#customize_order_sbmt', function (e) {
        e.preventDefault();
        var btn_value = $(this).html();
        var required = [];
        var _token = token;
        var url = $(this).data('url');
        $('.customize-required').each(function () {
            // console.log('.'+form_flag+'-required');
            var id = $(this).attr('id');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id).css({'border': '1px solid #FF0000'});
                $('#' + id + '_error').text('This Fiels is required');
            } else {
                $('#' + id).css({'border': '2px solid #707070;'});
                $('#' + id + '_error').text('');

            }

        });
        // alert(required.length);
        if (required.length == 0) {

            // alert($('#'+form_flag+'Form').serialize());
            $(this).html('Please wait..!');
            $('.with-errors').html('');
            $.ajax({
                type: 'POST', dataType: 'json', data: $('#customizeOrder').serialize(), headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/' + url, success: function (response) {
                    $('.submit-form-btn').html(btn_value);
                    if (response.status == "success") {
                        Toast.fire({
                            title: "", text: response.message, icon: "success"
                        })
                        location.reload();
                        $('#sendMessage')[0].reset();
                    } else if (response.status == "error") {
                        $('#email').css({'border': '1px solid #FF0000'});
                    } else {
                        Toast.fire(response.status, response.message, response.status);
                    }
                }
            });
        }
    });


    $(document).on('click', '.buy-action', function () {
        var id = $(this).data('id');
        var bogo = $(this).data('bogo');
        var qty = $('.qty').val();

        var cartText = $('.buy-action-span').html();
        
        if ($(this).data('relative') == undefined) {
            var countRelative = 1;
        } else {
            var countRelative = 0;
        }
        

        // alert(countRelative);return false;
        $('.buy-action-span').html('Loading..');
        var _token = token;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {product_id: id, _token: _token, qty: qty, countRelative: countRelative, bogo},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_url + '/add-cart',
            success: function (response) {
                if (response.status == true) {
                    if ($('.buy-action').data('purchase') != undefined) {
                        window.location.href = base_url + '/checkout';
                    } else {
                        $('.buy-action-span').html(cartText);
                        Toast.fire({
                            title: "", text: response.message, icon: "success"
                        })
                        $('.cartCount').html(response.count);
                        $('.cartTotal').html(response.cartTotal);
                        if (/[,\-]/.test(id)) {
                            var idArray = id.split(',');
                            var i;
                            for (i = 0; i < idArray.length; ++i) {
                                $('#addoncheck' + idArray[i]).prop('disabled', true);
                                $('.wishlistItem' + idArray[i]).removeClass('Isactive');
                                $('.wishlist-dynamic-filled-' + idArray[i]).hide();
                                $('.wishlist-dynamic-not-filled-' + idArray[i]).show();
                                $('#wishlistBox' + idArray[i]).remove();
                            }
                        } else {
                            $('.wishlistItem' + id).removeClass('Isactive');
                            $('.wishlist-dynamic-filled-' + id).hide();
                            $('.wishlist-dynamic-not-filled-' + id).show();
                            $('#wishlistBox' + id).remove();
                        }
                    }
                } else {
                    Toast.fire('Oops', response.message, "error");
                }
            }
        });
    });


    $(document).on('change', '#sort_order_drop', function () {
        $('#sort_order').val($(this).val());
        filterProducts();
    });

    $(document).on('change', '#sort_order_drop_mobile', function () {
        $('#sort_order').val($(this).val());
        filterProducts();
    });


    // $(function () {
    //     $("#slider-range").slider({
    //
    //     });
    //     $("#amount").val("$" + $("#slider-range").slider("values", 0) +
    //         " - $" + $("#slider-range").slider("values", 1));
    //     filterProducts();
    //
    // });

    // $(".range_bar_sort").slider({
    // change: function (event, ui) {
    //
    //     }
    // });


    // $(".range_bar_sort").on("slidechange", function (event, ui) {
    //     $("#amount").val("AED" + $("#slider-range").slider("values", 0) + " - AED" + $("#slider-range").slider("values", 1));
    //     filterProducts();
    // });

    $("#amount").keyup(function () {
        filterProducts();
    });

    $('.filter_tag').on('click', function () {
        if($(this).hasClass('tag_selected')){
            $(this).removeClass('tag_selected');
            $('#tag_filer_val').val('');
        } else{
            $('.filter_tag').removeClass('tag_selected');
            $(this).addClass('tag_selected');
            $('#tag_filer_val').val($(this).data('id'));
        }
        filterProducts();
    });

    // function filterProducts() {
    //     var fields = [];
    //     var values = [];
    //     $('.filterItem').each(function () {
    //         if ($(this).prop('checked') == true) {
    //             fields.push($(this).data('field'));
    //         }
    //     });
    //     $('#input_field').val($.unique(fields.sort()));
    //     $('#loading_offset').val(16);
    //     $('#loading_count').val(32);
    //     $.ajax({
    //         type: 'POST', dataType: 'html', data: $('#filter-form').serialize(), headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }, url: base_url + '/filter-product', success: function (response) {
    //             console.log(response);
    //             $('.productList').html(response);
     
    //             // window.scrollTo(0, 250);
    //             Toast.fire({
    //                 title: "Success!", text: "Filter completd", icon: "success"
    //             });
    //         }
    //     });
    // }

   


    $(document).on('click', '#register-form', function (e) {
        e.preventDefault();
        var email_id = $('#register_email_id').val();
        var required = [];
        $('.required').each(function () {
            var id = $(this).attr('id');
            var id_text = $(this).attr('placeholder');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id + '_error').html('Please enter your ' + id_text).css({
                    'color': '#FF0000', 'font-size': '12px', 'font-weight': '700'
                });
            } else {
                $('#' + id + '_error').html('');
            }
        });

        if (required.length == 0) {
            $('.with-errors').html('');
            $('#register-form').val('Please wait..!');
            $.ajax({
                type: 'POST', dataType: 'json', data: $('#registerForm').serialize(), headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/submit-register',
            })
                .done(function (response) {
                    $('#register-form').val('Register');
                    if (response.status == "success") {
                        Toast.fire({
                            title: "", text: response.message, icon: "success"
                        })
                        location.reload();
                    } else if (response.status == "error") {
                        // $('#register_email_id_error').html('Please enter a valid email ID').css({'color':'#FF0000','font-size':'14px','font-weight':'700'});

                        Toast.fire('Error', response.message, "error");

                    } else if (response.errors) {
                        $('.alert-success').hide();
                        $('.alert-info').hide();
                        $('.alert-danger').show();
                        $('.alert-danger ul').html('');
                        for (var error in response.errors) {
                            $('.alert-danger').html(response.errors[error]);
                        }
                    }
                })
                .fail(function (response) {
                    // $(this).html(buttonText);
                    $.each(response.responseJSON.errors, function (field_name, error) {
                        var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                        $("#registerForm").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                            .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                    });
                })

        }
    });

    $(document).on('click', '#login-form-btn', function (e) {
        var $this = $('#loginform');
        e.preventDefault();
        var required = [];
        $('.login-required').each(function () {
            var id = $(this).attr('id');
            var id_text = $(this).attr('Placeholder');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id + '_error').html('Please enter your ' + id_text).css({
                    'color': '#FF0000', 'font-size': '14px', 'font-weight': '700'
                });
            } else {
                $('#' + id + '_error').html('');
            }
        });

        if (required.length == 0) {
            $('button.submit-btn').prop('disabled', true);
            $('.alert-info').show();
            $('.alert-info').html('Authenticating....');
            $.ajax({
                type: 'POST', dataType: 'json', data: $('#loginform').serialize(), headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/login', success: function (data) {
                    if (data.status == 'error') {
                        $('.alert-success').hide();
                        $('.alert-info').hide();
                        $('.alert-danger').show();
                        $('.alert-danger').html(data.message);
                        for (var error in data.errors) {
                            $('.alert-danger').html(data.errors[error]);
                        }
                    } else {
                        $('.alert-info').hide();
                        $('.alert-danger').hide();
                        $('.alert-success').show();
                        $('.alert-success').html('Successfully Authenticated..!');
                        if (data.flag == 'true') {
                            window.location = base_url + '/checkout';
                        } else if (data.flag == 'profile') {
                            window.location = base_url + '/customer/shipping-address';
                        } else {
                            window.location = base_url + '/home';
                        }
                    }
                    $('button.submit-btn').prop('disabled', false);
                }
            });
        }
    });


    $(document).on('click', '#forgot-password-btn', function (e) {
        e.preventDefault();
       
        var _token = token;
        if ($('#email_forgot').val() == '') {
            $('#email_forgot_error').html('Please enter your email or username').css({
                'color': '#FF0000', 'font-size': '14px', 'font-weight': '700'
            });
        } else {
            $('#email_forgot_error').html('');
            $('#forgot-password-btn').html('Please wait...!');
            $.ajax({
                type: 'POST', dataType: 'json', data: $('#forgotForm').serialize(), headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/forgot-password', success: function (response) {
                    $('#forgot-password-btn').html('Forgot Password');
                    if (response.status == "true") {
                        Toast.fire({
                            title: "", text: response.message, icon: "success"
                        })
                    } else {
                        Toast.fire('Error', response.message, "error");
                    }
                }
            });
        }
    });


    // $(document).on('click', '#profile-update', function (e) {
    //     e.preventDefault();
    //     // var _token = token;
    //     var required = [];
    //     $('form input, form textarea').removeClass('is-invalid is-valid');
    //     $('span.error').remove();
    //     $('.profile-required').each(function () {
    //         var id = $(this).attr('id');
    //         if ($('#' + id).val() == '') {
    //             required.push($('#' + id).val());
    //             $('#' + id).css({'border': '1px solid #FF0000'});
    //         } else {
    //             $('#' + id).css({'border': '1px solid #cdcdcd'});
    //         }
    //     });
    //     if (required.length == 0) {
    //         $('.with-errors').html('');
    //         $.ajax({
    //             type: 'POST', dataType: 'json', data: $('#customerProfileForm').serialize(), headers: {
    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //             }, url: base_url + '/customer/update-profile',
    //         })
    //             .done(function (response) {
    //                 // $('#customerAddressForm').val('Register');
    //                 if (response.status == "true") {
    //                     Toast.fire({
    //                         title: "", text: response.message, icon: "success"
    //                     });
    //                     location.reload();
    //                 } else if (response.status == "error") {
    //                     // $('#register_email_id_error').html('Please enter a valid email ID').css({'color':'#FF0000','font-size':'14px','font-weight':'700'});
    //                     Toast.fire({
    //                         title: "Error", text: response.message, icon: 'error'
    //                     });
    //                 } else if (response.errors) {
    //                     $('.alert-success').hide();
    //                     $('.alert-info').hide();
    //                     $('.alert-danger').show();
    //                     $('.alert-danger ul').html('');
    //                     for (var error in response.errors) {
    //                         $('.alert-danger').html(response.errors[error]);
    //                     }
    //                 }
    //             })
    //             .fail(function (response) {
    //                 // console.log(response);
    //                 // $(this).html(buttonText);
    //                 $.each(response.responseJSON.errors, function (field_name, error) {
    //                     var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
    //                     $("#customerProfileForm").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
    //                         .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
    //                 });
    //             })
    //     }
    // });


    $(document).on('click', '#reset_password', function (e) {
        e.preventDefault();
        // var _token = token;
        var required = [];
        $('.reset-password-required').each(function () {
            var id = $(this).attr('id');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id).css({'border': '1px solid #FF0000'});
            } else {
                $('#' + id).css({'border': '1px solid #cdcdcd'});
            }
        });
        if (required.length == 0) {

            $('.with-errors').html('');
            $.ajax({
                type: 'POST', dataType: 'json', data: $('#reset_password_form').serialize(), headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/reset_password_store',

            })
                .done(function (response) {
                    // $('.contact_form_btn').html(buttonText);
                    if (response.status == true) {
                        Toast.fire({
                            title: "", text: response.message, icon: "success"
                        })
                        document.location.href = base_url;
                    } else {
                        Toast.fire('Error', response.message, "error");

                    }
                })
                .fail(function (response) {
                    // $('.contact_form_btn').html(buttonText);
                    $.each(response.responseJSON.errors, function (field_name, error) {
                        var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                        $("#reset_password_form").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                            .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                    });
                })
        }
    });


    $(document).on('click', '#change-password-btn', function (e) {
        e.preventDefault();
        $('span.error').html('');
        // var _token = token;
        var required = [];
        $('.password-required').each(function () {
            var id = $(this).attr('id');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id).css({'border': '1px solid #FF0000'});
            } else {
                $('#' + id).css({'border': '1px solid #cdcdcd'});
            }
        });
        if (required.length == 0) {
            $('.with-errors').html('');
            var password = $('#new_password').val();
            var confirm_password = $('#confirm_password').val();
            $.ajax({
                type: 'POST', dataType: 'json',

                data: $('#change-password-form').serialize(), headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/customer/change-password',
                beforeSend: function () {
                   
                    $('span.error').html('');
                }
            })
                .done(function (response) {
                    $('#change-password-form').val('Register');
                    if (response.status == "success") {
                        Toast.fire({
                            title: "", text: response.message, icon: "success"
                        })
                        location.reload();
                    } else if (response.status == "error") {
                        // $('#register_email_id_error').html('Please enter a valid email ID').css({'color':'#FF0000','font-size':'14px','font-weight':'700'});
                        Toast.fire('Error', response.message, "error");
                    } else if (response.errors) {
                        $('.alert-success').hide();
                        $('.alert-info').hide();
                        $('.alert-danger').show();
                        $('.alert-danger ul').html('');
                        for (var error in response.errors) {
                            $('.alert-danger').html(response.errors[error]);
                        }
                    }
                })
                .fail(function (response) {
                    // $(this).html(buttonText);
                    $.each(response.responseJSON.errors, function (field_name, error) {
                        var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                        $("#change-password-form").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                            .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                    });
                })
        }
    });

    $(document).on('click', '.addressModal', function (e) {
        e.preventDefault();

        var _token = token;
        var id = $(this).data('id');
        var logged = $(this).data('logged');
        var session = $(this).data('session');
        var set_session = $(this).data('set_session');
        var url = $(this).data('address-url');
        var redirect_url = $(this).data('redirect-url');
        $.ajax({
            type: 'POST',
            dataType: 'html',
            data: {id: id, _token: _token, logged: logged, session: session, set_session: set_session, url: url},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_url + '/billing-address-form',
            success: function (response) {
                // console.log(response);
                if (response != '0') {
                    $('#addressModalForm').html(response);
                    $('#customerAddressForm #redirect_url').val(redirect_url);
                    $('#adress-modal').modal('show');
                } else {
                    Toast.fire({
                        title: "Error", text: "Error while load the form", icon: 'error'
                    });
                }
            }
        });
    });

    $(document).on('click', '.shippingAddressModal', function (e) {
        e.preventDefault();
        // alert('hii');

        var _token = token;
        var id = $(this).data('id');
        var logged = $(this).data('logged');
        var session = $(this).data('session');
        var set_session = $(this).data('set_session');
        var url = $(this).data('address-url');
        var redirect_url = $(this).data('redirect-url');
        $.ajax({
            type: 'POST',
            dataType: 'html',
            data: {id: id, _token: _token, logged: logged, session: session, set_session: set_session, url: url},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_url + '/shipping-address-form',
            success: function (response) {
                // console.log(response);
                if (response != '0') {
                    $('#addressModalForm').html(response);
                    $('#customerAddressForm #redirect_url').val(redirect_url);
                    $('#adress-modal').modal('show');
                } else {
                    Toast.fire({
                        title: "Error", text: "Error while load the form", icon: 'error'
                    });
                }
            }
        });
    });

    $(document).on('click', '#save-shipping-address', function (e) {
        url = $(this).data('url');
        e.preventDefault();
        var _token = token;
        var required = [];
        var redirect_url = '';
        redirect_url = $('#redirect_url').val();
        $('.address-required').each(function () {
            var id = $(this).attr('id');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id + '_error').html('This field is required').css({
                    'color': '#FF0000', 'font-size': '12px', 'font-weight': '700'
                });
            } else {
                $('#' + id + '_error').html('');
            }
        });
        if (required.length == 0) {
            $('.with-errors').html('');
            $.ajax({
                type: 'POST', dataType: 'json', data: $('#customerAddressForm').serialize(), headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/' + url,

            })

                .done(function (response) {
                    console.log(response);
                    // $('#customerAddressForm').val('Register');
                    if (response.status == "true") {
                        $('#adress-modal').modal('hide');
                        Toast.fire({
                            title: "",
                            text: response.message,
                            icon: "success",
                            timer: 4000
                        });
                        if(redirect_url !== ''){
                            if(redirect_url === '/customer/my-account/address'){
                                $('#address-list-div').html('');
                                $.ajax({
                                    type: 'GET',
                                    data: {},
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: base_url + '/customer/list-customer-addresses',
                                    success: function (response) {
                                        if (response != 0) {
                                            $('#address-list-div').html(response);
                                        } else {
                                            swal.fire({
                                                title: 'Error', text: 'Some error occurred', icon: 'error'
                                            });
                                        }
                                    }
                                });
                            }
                            else{
                                window.location.href = base_url + redirect_url;
                            }
                        }
                        else
                            window.location.href = base_url + '/customer/my-account/address';
                    } else if (response.status == "error") {
                        // $('#register_email_id_error').html('Please enter a valid email ID').css({'color':'#FF0000','font-size':'14px','font-weight':'700'});
                        Toast.fire({
                            title: "Error", text: response.message, icon: 'error'
                        });
                    } else if (response.errors) {
                        $('.alert-success').hide();
                        $('.alert-info').hide();
                        $('.alert-danger').show();
                        $('.alert-danger ul').html('');
                        for (var error in response.errors) {
                            $('.alert-danger').html(response.errors[error]);
                        }
                    }
                })
                .fail(function (response) {
                    // $(this).html(buttonText);
                    $.each(response.responseJSON.errors, function (field_name, error) {
                        var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                        $("#customerAddressForm").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                            .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                    });
                })


        }
    });

    $(document).on('click', '.shipping-address-remove', function () {
        var address_id = $(this).data('id');
        var _token = token;
        swal.fire({
            title: "Are you sure?",
            text: "You will not be able to revert this!",
            type: "warning",
            icon: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: base_url + '/customer/delete_shipping_address',
                    data: {address_id: address_id, _token: _token},
                    success: function (data) {
                        if (data.status == 'false') {
                            Toast.fire({
                                title: "Error", text: data.message, icon: 'error'
                            });
                        } else {
                            $('#address' + address_id).remove();
                            Toast.fire({
                                title: "Success",
                                text: "Shipping address has been deleted successfully",
                                icon: "success"
                            });
                        }
                    }
                })
            } else {
                Toast.fire({
                    title: "Cancelled", text: "Entry remain safe :)", icon: 'error'
                });
            }
        });
    });


    $(document).on('click', '#billing_submit', function (e) {
        e.preventDefault();
        var _token = token;
        var required = [];
        $('.billing-required').each(function () {
            var id = $(this).attr('id');
            var id_text = $(this).attr('placeholder');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id).css({'border': '1px solid #FF0000'});
            } else {
                $('#' + id).css({'border': '1px solid #d0d0d0'});
            }
        });
        if (required.length == 0) {
            if ($('#billing_email').length > 0) {
                var email = $('#billing_email').val();
            } else {
                var email = 'review@cff.com';
            }
            var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(email)) {
                $('#email_error').css({'border': '1px solid #FF0000'});
            } else {
                $('.with-errors').html('');
                $.ajax({
                    type: 'POST', dataType: 'json', data: $('#billing-address-form').serialize(), headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, url: base_url + '/billing-address-store',

                })
                    .done(function (response) {
                        // $('#customerAddressForm').val('Register');
                        if (response.status == "true") {
                            Toast.fire({
                                title: "", text: response.message, icon: "success"
                            })
                            // location.reload();
                        } else if (response.status == "error") {
                            // $('#register_email_id_error').html('Please enter a valid email ID').css({'color':'#FF0000','font-size':'14px','font-weight':'700'});
                            Toast.fire('Error', response.message, "error");
                        } else if (response.errors) {
                            $('.alert-success').hide();
                            $('.alert-info').hide();
                            $('.alert-danger').show();
                            $('.alert-danger ul').html('');
                            for (var error in response.errors) {
                                $('.alert-danger').html(response.errors[error]);
                            }
                        }
                    })
                    .fail(function (response) {
                        // console.log(response);
                        // $(this).html(buttonText);
                        $.each(response.responseJSON.errors, function (field_name, error) {
                            var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                            $("#billing-address-form").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                                .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                        });
                    })
            }
        }
    });

    $(document).on('click', '.return-order', function () {
        
        var id = $(this).data('id');
        var order_id = $(this).data('order_id');
      
        $('#return_product_id').val(id);
        $('#return_order_id').val(order_id);
        $('#refund_method').val( $(this).data('refund_method'));
        $('#return_order_status').val($(this).data('status'));
        $('#returnOrder').modal('show');
    });
    $(document).on('click', '.cancel-order', function () {
        
        var id = $(this).data('id');
        var order_id = $(this).data('order_id');
        $('#product_id').val(id);
        $('#order_id').val(order_id);
        $('#order_status').val($(this).data('status'));
        $('#cancelOrder').modal('show');
    });

    $(document).on('click', '#cancel-order-submit', function (e) {
      
        e.preventDefault();
        // if($('#terms-conditions-cancel').prop('checked')==true){
        //     $('#terms-conditions-cancel-error').html('');
        $('#cancel-order-submit').html('Please wait..!');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#cancelOrderForm').serialize(),
            url: base_url + '/cancel-order',
            success: function (response) {
                $('#cancel-order-submit').html('Submit');
                if (response.status == true) {
                    Toast.fire({
                        title: "Success", text: response.message, icon: "success",
                    });
                    setTimeout(() => {
                        
                        window.location.reload();
                    }, 900);

                } else {
                    // $.notify(response.message, "error");
                    Toast.fire("Error!", response.message, 'error');
                }
            },
            fail: function (response) {
                // alert('dddd');
            }
        });
        // }else{
        //     $('#terms-conditions-cancel-error').html('Please accept the terms & condition').css({'color':'red'});
        // }
    });
    $(document).on('click', '#return-order-submit', function (e) {
      
        e.preventDefault();
        // if($('#terms-conditions-cancel').prop('checked')==true){
        //     $('#terms-conditions-cancel-error').html('');
        $('#return-order-submit').html('Please wait..!');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: $('#returnOrderForm').serialize(),
            url: base_url + '/return-order',
            success: function (response) {
                $('#return-order-submit').html('Submit');
                if (response.status == true) {
                    Toast.fire({
                        title: "Success", text: response.message, icon: "success",
                    });
                    setTimeout(() => {
                        
                        window.location.reload();
                    }, 900);

                } else {
                    // $.notify(response.message, "error");
                    Toast.fire("Error!", response.message, 'error');
                }
            },
            fail: function (response) {
                // alert('dddd');
            }
        });
        // }else{
        //     $('#terms-conditions-cancel-error').html('Please accept the terms & condition').css({'color':'red'});
        // }
    });

    $(document).on('change', '.similarSizeChange', function () {
        var size = $('#myoptionsize').val();
        var color = $('#myoptionsize2').val();
        var product_id = $('#productId').val();
// console.log(size,color,product_id);
        // var _token = token;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {product_id: product_id, _token: _token, size:size,color:color},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/similar-product-size-change',
            success: function (response) {
                if (response.status == true) {
                    window.location.href = base_url+response.url;
                } else {
                }
            }
        });
    });


    $(document).on('change', '.similarColorChange', function () {
        var size = $('#myoptionsize').val();
        var color = $('#myoptionsize2').val();
        var product_id = $('#productId').val();
        // console.log(size,color,product_id);
        var _token = token;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {product_id: product_id, _token: _token, size:size,color:color},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/similar-product-color-change',
            success: function (response) {
                if (response.status == true) {
                    window.location.href = base_url+response.url;
                } else {
                }
            }
        });
    });




    $(document).on('click', '.addon_check', function () {

        var id = $(this).val();
        var price = $(this).data('price');
        var total_price = $('#addonSubmit').data('total-price');
        var addon_ids = $('#addonSubmit').data('id').split(",");
        if ($(this).prop('checked') == true) {
            addon_ids.push(id);
            $('#addonSubmit').data('id', addon_ids.toString());
            var total_count = addon_ids.length;
            var total_price = total_price + price;
            $('#count').html(total_count);
            $('#total_price').html(total_price);
            $('#addonSubmit').data('total-price', total_price);


        } else {
            var new_addon = addon_ids.filter(e => e !== id);
            $('#addonSubmit').data('id', new_addon.toString());
            var total_count = new_addon.length + 1;
            var total_price = total_price - price;
            $('#count').html(total_count);
            $('#total_price').html(total_price);
            $('#addonSubmit').data('total-price', total_price);

        }
        // if(!($(".addon_check:checked").length > 0)){
        //     $('#addonSubmit').html('Choose item to buy together');
        //
        // }

    });


    function removeValue(list, value) {
        return list.replace(new RegExp(",?" + value + ",?"), function (match) {
            var first_comma = match.charAt(0) === ',', second_comma;

            if (first_comma && (second_comma = match.charAt(match.length - 1) === ',')) {
                return ',';
            }
            return '';
        });
    };



    $(document).on('change', '.addressChoose', function (e) {
        e.preventDefault();
        //check this checkbox is checked or not
        var val = $(this).val();
        if($(this).prop('checked')==true){
            var val = "different";
        }
        else{
            var val = "same";
        }
        $('#billingAddressChoose').val(val);
        var customer=$(this).data('customer');
        var shipping_address=$(this).data('shipping-address');
        
        if(shipping_address) {
            addressChoose(val);
        }else if(val=='same'){
            var required = [];

            if(val=='same'){
                if(!customer){
                    $('.address-required').each(function () {
                        var id = $(this).attr('id');
                        if ($('#' + id).val() == '') {
                            required.push($('#' + id).val());
                        }
                    });
                    if(required.length == 0){
                        $('#sameAdd').prop('checked',true);
                        $('#diffAdd').prop('checked',false);
                        $('#sameAdd').data('shipping-address',true);
                        addressChoose(val);

                    }else{
                        $('#sameAdd').prop('checked',false);
                        $('#diffAdd').prop('checked',true);
                        $('#sameAdd').data('shipping-address',false);
                        Toast.fire('Error', "Please select shipping Address", "error");
                    }
                }else{
                    if(shipping_address){
                        $('#sameAdd').prop('checked',true);
                        $('#diffAdd').prop('checked',false);
                        $('#sameAdd').data('shipping-address',true);
                        addressChoose(val);

                    }else{
                        $('#sameAdd').prop('checked',false);
                        $('#diffAdd').prop('checked',true);
                        $('#sameAdd').data('shipping-address',false);
                        Toast.fire('Error', "Please select shipping Address", "error");
                    }
                }

            }
          
        }else{
           
            addressChoose(val);
        }
        $('.address-slider').slick('refresh');
    });


    function addressChoose(val){
   
        $.ajax({
            type: 'POST', dataType: 'json', data: {address_type: val,}, headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/choose-customer-billing-address', success: function (response) {
                if (response.status) {
                    Toast.fire({
                        title: "", text: 'Customer billing address selected successfully', icon: "success"
                    })
                     $('#billingAddressChoose').val(val);
                    if (response.address_selected == true) {
                        $('#address_select_error').addClass('d-none');
                        $('.confirm_payment_btn').attr('id','confirm_payment');
                    }else{
                        $('#address_select_error').removeClass('d-none');
                        $('.confirm_payment_btn').removeAttr('id');

                    }
                    if(response.billingAddress.address_choose=='same'){


                        $('.billing').removeClass('active');
                        $('.billingAddress'+response.billingAddress.address_id).addClass('active');
                        $('.billing').addClass('d-none');
                        $('.billingAddress'+response.billingAddress.address_id).removeClass('d-none');

                        $('#billing_first_name').val(response.billingAddress.billing_first_name).prop("readonly", true);
                        $('#billing_last_name').val(response.billingAddress.billing_last_name).prop("readonly", true);
                        $('#billing_phone_number').val(response.billingAddress.billing_phone_number).prop("readonly", true);
                        $('#billing_email').val(response.billingAddress.billing_email).prop("readonly", true);
                        $('#billing_address').val(response.billingAddress.billing_address).prop("readonly", true);
                        $('#billing_country').val(response.billingAddress.billing_country).change().prop("disabled", true);
                        $('#billing_state').val(response.billingAddress.billing_state).change().prop("disabled", true);

                    }else{

                        $('.billing').removeClass('active');
                        $('.billing').removeClass('d-none');


                        $('#billing_first_name').val('').attr("readonly", false);
                        $('#billing_last_name').val('').attr("readonly", false);
                        $('#billing_phone_number').val('').attr("readonly", false);
                        $('#billing_email').val('').attr("readonly", false);
                        $('#billing_address').val('').attr("readonly", false);
                        $('#billing_country').val('').change().attr("disabled", false);
                        $('#billing_state').val('').change().attr("disabled", false);
                    }
                    // location.reload();
                } else {
                    Toast.fire('Error', "Error while selecting billing address", "error");
                    // $.notify(response.message, "error");
                }
            }
        });

    }



    $(document).on('change', '.special_delivery', function (e) {

        e.preventDefault();
        var _token = token;
        var required = [];
        var reload=$(this).data('reload');
        $('.deivery-required').each(function () {
            var id = $(this).attr('id');
            var id_text = $(this).attr('placeholder');
            if ($('#' + id).val() == '') {
                required.push($('#' + id).val());
                $('#' + id).css({'border': '1px solid #FF0000'});
            } else {
                $('#' + id).css({'border': '1px solid #d0d0d0'});
            }
        });
        if (required.length == 0) {
            $.ajax({
                type: 'POST', dataType: 'html', data: $('#deliveryForm').serialize(), headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/delivery-date-check', success: function (response) {
                    if (response != '') {
                        // $('#specialDayDiv').html(response);
                        $('#specialdaypopup').modal('show');
                    } else {
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            data: {clear: 1, date_change: 1, _token: _token,},
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: base_url + '/clear_delivery_date_time',
                            success: function (response) {
                                if (response.status == true) {
                                    if ($(this).data('purchase') != undefined) {
                                        window.location.href = base_url + '/checkout';
                                    } else {
                                        Toast.fire({
                                            title: "",
                                            text: "Delivery Date and Time Changed Successfully",
                                            icon: "success"
                                        })
                                        $('.cartUrl').attr('href', base_url + '/cart')
                                        $('.count').html(response.count);
                                        $('.cartTotal').html(response.cartTotal);
                                        if(reload){
                                            location.reload();
                                        }
                                    }
                                } else {
                                    Toast.fire('Oops', response.message, "error");
                                }
                            }
                        });

                    }

                }
            });
        }
    });


    $(document).on('click', '#specialDaySbmt', function () {
        var product_ids = $(this).data('product-ids');
        var delivery_date = $(this).data('delivery-date');
        var _token = token;
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {product_id: product_ids, delivery_date: delivery_date, _token: _token,},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_url + '/update-cart-special-price',
            success: function (response) {
                if (response.status == true) {
                    if ($(this).data('purchase') != undefined) {
                        window.location.href = base_url + '/checkout';
                    } else {
                        Toast.fire({
                            title: "", text: "Special day price applied Successfully", icon: "success"
                        })

                        $('.cartUrl').attr('href', base_url + '/cart')
                        $('.count').html(response.count);
                        $('.cartTotal').html(response.cartTotal);
                        window.location.reload();

                        if (/[,\-]/.test(id)) {
                            var idArray = id.split(',');
                            var i;
                            for (i = 0; i < idArray.length; ++i) {
                                $('#addoncheck' + idArray[i]).prop('disabled', true);
                                $('.wishlistItem' + idArray[i]).removeClass('Isactive');
                                $('.wishlist-dynamic-filled-' + idArray[i]).hide();
                                $('.wishlist-dynamic-not-filled-' + idArray[i]).show();
                                $('#wishlistBox' + idArray[i]).remove();
                            }

                        } else {
                            $('.fill-' + id).removeClass('fill');
                            $('#text-wishlist').text("Add to Wishlist");

                            $('.wishlistItem' + id).removeClass('Isactive');
                            $('.wishlist-dynamic-filled-' + id).hide();
                            $('.wishlist-dynamic-not-filled-' + id).show();
                            $('#wishlistBox' + id).remove();
                        }
                    }
                } else {
                    Toast.fire('Oops', response.message, "error");
                }
            }
        });

    });


    $(document).on('click', '#specialDayCancel', function () {

        $('.specialday_datepicker').datepicker('setDate', 'today');


    });

        $('#specialdaypopup').on('hidden.bs.modal', function () {
        $('.specialday_datepicker').datepicker('setDate', 'today');
    });



    $(document).on('click', '#dateClear', function (e) {
        e.preventDefault();
        var delivery_date = $(this).data('delivery-date');
        var _token = token;
        $.ajax({
            type: 'POST', dataType: 'json', data: {clear: 1, _token: _token,}, headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/clear_delivery_date_time', success: function (response) {
                if (response.status == true) {
                    if ($(this).data('purchase') != undefined) {
                        window.location.href = base_url + '/checkout';
                    } else {
                        Toast.fire({
                            title: "", text: "Delivery Date and Time Cleared successfully", icon: "success"
                        })
                        $('.cartUrl').attr('href', base_url + '/cart')
                        $('.count').html(response.count);
                        $('.cartTotal').html(response.cartTotal);
                        window.location.reload();
                    }
                } else {
                    Toast.fire('Error', response.message, "error");
                }
            }
        });

    });
     
//coupon apply
    $(document).on('click', '#coupon-apply', function (e) {
        e.preventDefault();
        var coupon = $('#coupon').val();
        var btnTitle = $('#coupon-apply').val();
        $('#coupon-apply').html('Please Wait..');
        if ($('#credit_point_check_valid').val() == 1) {
            var credit_point = $('#credit_point_amount').val();
        } else {
            var credit_point = 0;
        }
     
        if (coupon) {
            $.ajax({
                type: 'POST', dataType: 'json', data: {coupon, credit_point}, headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }, url: base_url + '/apply-coupon', success: function (response) {
                    $('#coupon-apply').val(btnTitle);
                    if (response.status == 'success') {
                        $('.coupon_div').css({'visibility': 'visible'});
                        Toast.fire({
                            title: 'Success', text: response.message, icon: 'success'
                        });
                        setTimeout(() => {
                            $('.couponList .invalidMessage').html('');
                        }, 900);
                        location.reload();
                    } else {
                        $('.coupon_div').css({'visibility': 'hidden'});
                        // Toast.fire({
                        //     title: 'Error', text: response.message, icon: response.status
                        // });
                        $('.couponList .invalidMessage').html('');
                        $('.couponList .invalidMessage').html (response.message);
                        $('#coupon-apply').html('APPLY').removeClass('active');
                        $('#coupon').val('');
                        setTimeout(() => {
                            // $('.couponList .invalidMessage').html('');
                        }, 900);
                    }
                }
            });
        } else {
            Toast.fire('Error', 'Coupon Value is Empty', 'error');
            $('#coupon-apply').html('Apply Coupon');
             
            $('.couponList .invalidMessage').removeClass('d-none');
            $('.couponList .invalidMessage').html('');
            $('.couponList .invalidMessage').html('Coupon Value is Empty');
            setTimeout(() => {
                $('.couponList .invalidMessage').html('');
            }, 900);
        }
    });


    $(document).on('click', '.remove_coupon', function () {
        var coupon = $(this).data('coupon');
        swal.fire({
            title: "Are you sure to remove this coupon?",
            text: "",
            icon: "warning",
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Yes, remove it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'POST', dataType: 'json', data: {coupon}, headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }, url: base_url + '/remove-coupon', success: function (response) {
                        if (response.status == 'success') {
                            Toast.fire({
                                title: "", text: response.message, icon: response.status
                            });
                            window.location.reload();
                        } else {
                            Toast.fire({
                                title: "Error", text: response.message, icon: response.status
                            });
                        }
                    }
                });
            } else {
                Toast.fire("Cancelled", "Entry remain safe :)", "warning");
            }
        });
    });





    $(document).on('change', '.billing-value-change', function (e) {
        
        var addressChoose = $('.billingAddressChoose:checked').val();
        e.preventDefault();
        var reload = $(this).data('reload');
        // var _token = token;
        $.ajax({
            type: 'POST', dataType: 'json', data: $('#addBillingForm').serialize(), headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/' + 'billing-address-store',beforeSend: function() {
                $(document).find('span.invalid-feedback').text('');
            },
        })

            .done(function (response) {
                // $('#customerAddressForm').val('Register');
                if (response.status == "true" ) {
                    Toast.fire('Success', response.message, 'success');
                    setTimeout(() => {
                        // window.location.reload();
                        $('#confirm_payment').attr('disabled', false);
                        $('.error').addClass('d-none');
                    }, 100);
                }
            })  .fail(function (response) {
             
                // $(this).html(buttonText);
                $.each(response.responseJSON.errors, function (field_name, error) {
               
                    var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                    $("#addBillingForm").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                        .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                });
                if (addressChoose == 'same') {
                    // $('')
                    if (field_name == 'country') {
                        $('#billing_' + field_name).val(val).change();
                    } else {
                        $('#billing_' + field_name).val(val);
                    }
                }
            })
    });


    $(document).on('change', '#remark', function (e) {
        e.preventDefault();
        var _this = $(this);
        var remarks = $('#remark').val();
        $.ajax({
            type: 'POST', dataType: 'json', data: {remarks: remarks}, headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/add-order-remarks', success: function (response) {
                if (response.status == true) {
                    $('.invalid-feedback').html('');
                    _this.removeClass('is-invalid').attr("aria-invalid", "true");
                    $(".customer-notes").find(".invalid-feedback").remove();
                    Toast.fire({
                        title: "", text: response.message, icon: "success"
                    });
                } else {
                    Toast.fire('Error', response.message, "error");
                }
            },
            error: function (response, error) {
                $('.invalid-feedback').html('');
                $(".customer-notes").find(".invalid-feedback").remove();
                $.each(response.responseJSON.errors, function (field_name, error) {
                    var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                    _this.removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
                });
            }
        });
    });


    $(document).on('click', '.default_address', function () {
        var id = $(this).data('id');
        $.ajax({
            type: 'POST', dataType: 'json', data: {id}, headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/customer/set-default-address', success: function (response) {
                if (response.status === "success") {
                    Toast.fire({
                        title: "", text: response.message, icon: "success"
                    });
                    window.location.href = base_url + '/customer/account/address';

                    // location.reload();
                } else {
                    Toast.fire({
                        title: "Error", text: response.message, icon: 'error'
                    });
                }
            }
        });
    });



    // $(document).on('click', '.load-more-product', function () {
    //     var offset = $('#loading_offset').val();
    //     var btnHtml = $('.load-more-product').html();
    //     $('.load-more-product').html('Please wait..!');
    //     $.ajax({
    //         type: 'POST',
    //         data: $('#filter-form').serialize(),
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         },
    //         url: base_url + '/product-load-more',
    //         success: function (response) {
    //             if (response != 0) {
    //                 $('.appendHere' + offset).after(response).remove();
    //                 $('.more-section-' + offset).remove();
    //                 $('.load-more-product').html(btnHtml);
    //             } else {
    //                 swal.fire({
    //                     title: 'Error', text: 'Some error occurred', icon: 'error'
    //                 });
    //             }
    //         }
    //     });
    // });

});

// $(window).scroll(function() {
//     if($(window).scrollTop() + $(window).height()+1200 >= $(document).height()) {
//         if (method == "blogs") {
//           blogLoadMoreData();
//         }else{
//             loadMoreData();
//         }
//     }
// });



function loadMoreData() {
    var total_products = $('#total_products').val();
    var offset = $('#loading_offset').val();
    var btnHtml = $('.load-more-product').html();
    if (total_products > offset) {
        $('.load-more-product').html('Please wait..!');
        $.ajax({
            type: 'POST', data: $('#filter-form').serialize(), headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }, url: base_url + '/product-load-more', success: function (response) {
                if (response != 0) {
                    $('.appendHere' + offset).after(response).remove();
                    $('.more-section-' + offset).remove();
                    $('.load-more-product').html(btnHtml);
                } else {
                    Toast.fire({
                        title: "Error", text: 'Some error occurred', icon: 'error'
                    });
                }
            }
        });
    }

}

function blogLoadMoreData() {
    // alert('blogs');
    var total_blogs = $('#totalBlogs').val();
var offset = $('#blog_loading_offset').val();
    var loading_limit = $('#blog_loading_limit').val();
    var _token = token;

    var btnHtml = $('.load-more-product').html();
    if (total_blogs > offset) {
        $('.load-more-product').html('Please wait..!');
        $.ajax({
            type: 'POST',
            data: {total_blogs: total_blogs, offset: offset, loading_limit: loading_limit},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_url + '/blog-load-more',
            success: function (response) {
                if (response != 0) {
                    $('.appendHere' + offset).after(response).remove();
                    $('.more-section-' + offset).remove();
                    $('.load-more-product').html(btnHtml);
                } else {
                    Toast.fire({
                        title: "Error", text: 'Some error occurred', icon: 'error'
                    });
                }
            }
        });
    }

}


 ////////////////////// ===================  Customer login after  =================== //////////////////////

 $(document).on('click', '.shipping-login-value-change', function (e) {

    $(document).find('span.invalid-feedback').text('fdd');
    e.preventDefault();
    var field_name = $(this).attr('name');
    var val = $(this).val();
    // var addressChoose=$('.addressChoose').val();
    var addressChoose = $('.addressChoose:checked').val();
    var reload = $(this).data('reload');
    // var _token = token;
    $.ajax({
        type: 'POST', dataType: 'json', data: $('#addShippingLoginAddressForm').serialize(), headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, url: base_url + '/' + 'update-customer-shipping-address', beforeSend: function() {
            $(document).find('span.invalid-feedback').text('');
        },

    })

        .done(function (response) {
            if (addressChoose == 'same') {
                if (field_name == 'country') {
                    $('#billing_' + field_name).val(val).change();
                } else {
                    $('#billing_' + field_name).val(val);
                }
                if (field_name == 'state') {
                    $('#billing_' + field_name).val(val).change();
                } else {
                    $('#billing_' + field_name).val(val);
                }
            }
            if (response.status == "true" && response.reload == 'true') {
           
                $('.shipping_charge').text(response.calculation_box.shippingAmount);
                $('.tax_amount').text(response.calculation_box.tax_amount);
                $('#grand_total_amount').val(response.calculation_box.final_total_with_tax);
                $('.cart_final_total_span').text(response.calculation_box.final_total_with_tax);
                Toast.fire('Success', response.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                    
                }, 1500);
            }
        })
      

        .fail(function (response) {
            
            // $(this).html(buttonText);
            $.each(response.responseJSON.errors, function (field_name, error) {
           
                var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                $("#addShippingLoginAddressForm").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                    .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
            });
            if (addressChoose == 'same') {
                // $('')
                if (field_name == 'country') {
                    $('#billing_' + field_name).val(val).change();
                } else {
                    $('#billing_' + field_name).val(val);
                }
            }
        })
});

$(document).on('change', '.billing-login-value-change', function (e) {
var addressChoose = $('.billingAddressChoose:checked').val();
    e.preventDefault();
    var reload = $(this).data('reload');
    // var _token = token;
    $.ajax({
        type: 'POST', dataType: 'json', data: $('#addBillingingLoginAddressForm').serialize(), headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }, url: base_url + '/' + 'billing-address-store',beforeSend: function() {
            $(document).find('span.invalid-feedback').text('');
        },
    })

        .done(function (response) {
            // $('#customerAddressForm').val('Register');
            if (response.status == "true" ) {
                Toast.fire('Success', response.message, 'success');
                if(response.reload == 'true'){

                    setTimeout(() => {
                        window.location.reload();
                        
                    }, 1500);
                }
            }
        })  .fail(function (response) {
            
            // $(this).html(buttonText);
            $.each(response.responseJSON.errors, function (field_name, error) {
           
                var msg = '<span class="error invalid-feedback" for="' + field_name + '">' + error + '</span>';
                $("#addBillingingLoginAddressForm").find('input[name="' + field_name + '"], select[name="' + field_name + '"], textarea[name="' + field_name + '"]')
                    .removeClass('is-valid').addClass('is-invalid').attr("aria-invalid", "true").after(msg);
            });
            if (addressChoose == 'same') {
                // $('')
                if (field_name == 'country') {
                    $('#billing_' + field_name).val(val).change();
                } else {
                    $('#billing_' + field_name).val(val);
                }
            }
        })
});
