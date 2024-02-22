@extends('Admin.layouts.main')
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1><i class="nav-icon fas fa-user-shield"></i> {{$title}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'dashboard')}}">Home</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{url(Helper::sitePrefix().'bookings/questions')}}">Question</a></li>
                            <li class="breadcrumb-item active">{{$key}}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <form role="form" id="formWizard" class="form--wizard" enctype="multipart/form-data" method="post">
                    {{csrf_field()}}
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Questions Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{ session('success') }}
                                </div>
                            @elseif(session('error'))
                                <div class="alert alert-danger" role="alert">
                                    <button type="button" class="close" data-dismiss="alert">×</button>
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Question*</label>
                                    <textarea name="question" id="question" class="form-control required" rows="3" placeholder="Question">{{@$question->question}}</textarea>
                                    <div class="help-block with-errors" id="question_error"></div>
                                    @error('question')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label> Question Type*</label>
                                    <select name="question_type" id="question_type"
                                            class="form-control required select2">
                                        <option value="">Select Question Type</option>
                                        @foreach(["Yes/No"=>"Yes/No","Descriptive"=>"Descriptive","Choice"=>"Choice"] as $key)
                                            <option value="{{ $key}}" {{@$question->type==$key?'selected':''}}>{{ $key}}</option>
                                        @endforeach
                                    </select>
                                    <div class="help-block with-errors" id="question_type_error"></div>
                                    @error('question_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer" id="submit_button" style="display: {{@$question->type=='Choice'?'none':''}}">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <img class="animation__shake loadingImg" src="{{asset('backend/dist/img/loading.gif')}}"
                                 style="display:none;">
                        </div>
                    </div>


                    <div class="card card-info" id="choice_div" style="display: {{@$question->type=='Choice'?'':'none'}}">
                        <div class="card-header">
                            <h3 class="card-title">Answer Choices Form</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>

                            </div>
                        </div>
                        <div class="card-body">
                            @if(isset($choices))
                                @php $i=1 @endphp
                                @foreach($choices as $choice)
                                    <div class="form-row" id="append_result_{{$i}}">
                                        <div class="form-group col-md-6">
                                            <label for="inputPassword4">Title*</label>
                                            <input type="text" class="form-control" name="choice[]"
                                                   id="extra_title_{{$i}}" placeholder="Choice"
                                                   value="{{ $choice->choice }}" maxlength="230">
                                            <div class="help-block with-errors" id="extra_title_{{$i}}_error"></div>
                                        </div>

                                        <div class="form-group col-md-1">
                                            <label for="sort_order_{{$i}}">Sort Order</label>
                                            <input type="number" class="form-control" name="sort_order[]"
                                                   id="sort_order_{{$i}}" value="{{ $choice->sort_order?? $i }}">
                                        </div>
                                        <div class="form-group col-md-2" style="margin-top: 10px">
                                            @if($loop->last)
                                                <a href="javascript:void(0);"
                                                   class="btn btn-success mt-4 add_choice_row btn-sm add_{{$i}}"
                                                   id="{{$i}}"><i class="fa fa-plus fa-lg"></i></a>
                                            @endif
                                            <a href="javascript:void(0);"
                                               class="btn btn-danger mt-4 remove_choice_row btn-sm" id="{{$i}}"
                                               ref="{{ $choice->id }}"><i class="fa fa-times fa-lg"></i></a>
                                            <input type="hidden" name="detail_id[]" id="detail_id_{{$i}}"
                                                   value="{{ $choice->id }}">
                                        </div>
                                    </div>
                                    @php $i++@endphp
                                @endforeach
                            @else
                                <div class="form-row" id="append_result_1">
                                    <div class="form-group col-md-6">
                                        <label for="inputPassword4">Choice*</label>
                                        <input type="text" class="form-control choice_input" name="choice[]"
                                               id="extra_title_1" placeholder="Choice">
                                        <div class="help-block with-errors" id="extra_title_1_error"></div>
                                    </div>
                                    <div class="form-group col-md-1">
                                        <label for="sort_order_1">Sort Order</label>
                                        <input type="number" class="form-control" name="sort_order[]"
                                               id="sort_order_1" value="1">
                                    </div>
                                    <div class="form-group col-md-1" style="margin-top: 10px">
                                        <a href="javascript:void(0);"
                                           class="btn btn-success mt-4 add_choice_row btn-sm add_1" id="1"><i
                                                class="fa fa-plus fa-lg"></i></a>
                                        <input type="hidden" name="detail_id[]" id="detail_id_1" value="0">
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="card-footer">
                            <input type="submit" name="btn_save" value="Submit"
                                   class="btn btn-primary pull-left submitBtn">
                            <input type="hidden" name="product_id" id="product_id" value="{{@$product_id}}">
                            <input type="hidden" name="question_id" id="question_id"
                                   value="{{isset($question)?$question->id:'0'}}">
                            <img class="animation__shake loadingImg" src="{{url('backend/dist/img/loading.gif')}}"
                                 style="display:none;">
                        </div>
                    </div>


                </form>
            </div>
        </section>
    </div>


    <script>

        $('#question_type').on('change', function () {
            if ($(this).val() == 'Choice') {
                $('#choice_div').show();
                $('#submit_button').hide();
                $('.choice_input').attr('required', true).addClass('required');

            }else{
                $('#choice_div').hide();
                $('#submit_button').show();
            }
        });

        $(document).on('click', '.add_choice_row', function () {
            var unique_id = $(this).attr('id');
            var plus_unique = parseFloat(unique_id) + 1;
            var product_id = $(this).attr('product_id');
            var _token = token;
            $.ajax({
                type: 'POST',
                data: {unique_id: unique_id, _token: _token, product_id: product_id},
                url: base_url + '/bookings/questions/choice/extra_row',
                success: function (response) {
                    $('.add_choice_row').hide();
                    $(response).hide().insertAfter("#append_result_" + unique_id).fadeIn(500);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    swal('Error !', 'Some error occurred', 'error');
                }
            });
        });

        $(document).on('click', '.remove_choice_row', function () {
            var primary_key = $(this).attr('id');
            var data_key = $(this).attr('ref');
            var _token = token;
            if (data_key == 0) {
                var previous_key = parseFloat(primary_key) - 1;
                $(this).closest('.form-row').fadeOut(300, function () {
                    $(this).remove();
                    $('.add_' + previous_key).show();
                });
            } else {
                swal({
                    title: "Are you sure?",
                    text: "You will be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel plz!",
                    closeOnConfirm: false,
                    closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: base_url + '/bookings/questions/choice/remove_extra_row',
                            data: {id: data_key, _token: _token},
                            success: function (data) {
                                if (data.status == false) {
                                    swal('Error !', data.message, 'error');
                                } else {
                                    swal({title: "Success",
                                        text: "Entry has been deleted!",
                                        type: "success"}, function () {
                                        location.reload();
                                    });
                                }
                            }
                        })
                    } else {
                        swal("Cancelled", "Entry remain safe :)", "error");
                    }
                });
            }
        });
    </script>

@endsection
