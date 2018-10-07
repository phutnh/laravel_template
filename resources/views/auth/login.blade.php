<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('setting.admin.path_css') . '/icons/favicon.png') }}">
    <title>Đăng nhập hệ thống ! - {{ config('app.name') }}</title>
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
                    <!-- Form -->
                    <form class="form-horizontal" id="loginform" method="post" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        @include('partials.validation_errors')
                        <div class="row p-b-30">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="ti-user"></i></span>
                                    </div>
                                    <input type="text" name="taikhoan" class="form-control form-control-lg" placeholder="Tài khoản" focus>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white" id="basic-addon2"><i class="ti-pencil"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Mật khẩu">
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="p-t-20">
                                        <a class="btn btn-info" href="{{ route('password.request') }}">
                                            <i class="fa fa-lock m-r-5"></i> Quên mật khẩu?
                                        </a>
                                        <button class="btn btn-success float-right" type="submit">Đăng nhập</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
    </script>

</body>

</html>