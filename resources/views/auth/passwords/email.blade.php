<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('setting.admin.path_css') . '/icons/favicon.png') }}">
    <title>Gửi link khôi phục ! - {{ config('app.name') }}</title>
    <link href="{{ asset(config('setting.admin.path_css') . 'style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center bg-dark">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="loginform">
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db"><img src="{{ asset('css/admincp/icons/logo-icon.png') }}" alt="logo" /></span>
                    </div>
                    <div class="text-center">
                        <span class="text-white">Vui lòng nhập địa chỉ email chúng tôi sẽ gửi link khôi phục mật khẩu cho bạn.</span>
                    </div>
                    <div class="row m-t-20">
                        <!-- Form -->
                        <form class="col-12" method="post" action="{{ route('password.email') }}">
                            <!-- email -->
                            {{ csrf_field() }}
                            @include('partials.validation_errors')
                            @include('partials.messages')
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white"><i class="ti-email"></i></span>
                                </div>
                                <input type="text" name="email" class="form-control form-control-lg" placeholder="Địa chỉ email" focus>
                            </div>
                            <div class="row m-t-20 p-t-20 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success" href="{{ route('login') }}" id="to-login" name="action">Trở về</a>
                                    <button class="btn btn-info float-right" type="submit" name="action">Gửi link</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset(config('setting.admin.path_js') . 'jquery.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'popper.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'bootstrap.min.js') }}"></script>
    <script>

    $('[data-toggle="tooltip"]').tooltip();
    $(".preloader").fadeOut();
    $("input").attr('autocomple', 'off');
    </script>

</body>

</html>