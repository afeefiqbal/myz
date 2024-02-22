<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }} | Reset Password</title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('backend/dist/css/sweetalert.min.css')}}">
    <link rel="stylesheet" href="{{asset('backend/dist/css/sweetalert-overrides.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('backend/dist/css/login.css?v=1.5')}}">
    <script type="text/javascript">
        var base_url = "{{ url('/') }}";
        var token = "{{ csrf_token() }}";
    </script>
</head>
<body>
    <div class="main">
        <input type="checkbox" id="chk" aria-hidden="true">
        <div class=" alignText">
            {!! Helper::printImage(@$siteInformation, 'logo','logo_webp','logo_attribute','animation__shake logo') !!}
        </div>
        <div class="signup login-show">
            <h3 class="align-center">Reset Your Password</h3>
            @if(@$status == 'invalid')
                <div class="alert alert-danger">
                    <li>{{ $message }}</li>
                </div>
            @elseif(@$link_expired=='true')
                <div class="alert alert-danger">
                    <li>Link Expired</li>
                </div>
            @else
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <form method="POST" action="" id="reset-password-form">
                    @csrf
                    <input type="password" name="password" class="@error('password') is-invalid @enderror required"
                           id="password" placeholder="Password" minlength="8" maxlength="30">
                    <div class="help-block with-errors" id="password_error"></div>
                    <input type="password" name="password_confirmation"
                           class="@error('password_confirmation') is-invalid @enderror required"
                           id="password_confirmation" placeholder="Confirm Password" min="8" maxlength="30">
                    <div class="help-block with-errors" id="password_confirmation_error"></div>
                    <input type="hidden" name="token" id="token" value="{{$token}}">
                    <input class="login-btn" type="submit" value="Reset Password" id="password_reset">
                    <span class="error_message"></span>
                </form>
            @endif
        </div>
    </div>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('backend/dist/js/sweetalert.min.js')}}"></script>
    <script src="{{asset('backend/dist/js/sweetalert-init.js')}}"></script>
    <script src="{{asset('backend/dist/js/custom.js')}}"></script>
    <style>
        .error {
            color: red;
        }
    </style>
</body>
</html>
