<!DOCTYPE html>
<html dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('setting.admin.path_css') . '/icons/favicon.png') }}">
    <title>Đăng ký hệ thống ! - {{ config('app.name') }}</title>
    <link href="{{ asset(config('setting.admin.path_css') . 'style.min.css') }}" rel="stylesheet">
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
                <div class="alert alert-warning" role="alert">
                     Xin lỗi ! Link giới thiệu này vẫn chưa được kích hoạt. Vui lòng <a href="{{route('user.register.index')}}">Đăng ký</a> với chúng tôi qua trang chủ
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <script src="{{ asset(config('setting.admin.path_js') . 'jquery.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'popper.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'bootstrap.min.js') }}"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
    </script>
</body>

</html>