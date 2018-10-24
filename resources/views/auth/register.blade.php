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
    <style type="text/css">
        .register-margin-right select {
            margin-right: 10px;
        }
        .auth-wrapper .auth-box {
            max-width: 1200px;
            margin-top: 20px;
        }
        .register-file {
            padding: 6px;
        }
        .register-w-f {
            width: 110px;
        }
    </style>
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
                <div>
                    <div class="text-center p-t-20 p-b-20">
                        <span class="db"><img src="{{ asset('css/admincp/icons/logo-icon.png') }}" alt="logo" /></span>
                    </div>
                    @if(count($errors)>0)
                        <div class="alert alert-danger error">
                            @foreach($errors->all() as $error)
                                {{$error}}<br/>
                            @endforeach
                        </div>
                    @endif
                    @if (session()->has('success'))
                       <div class="alert alert-success" role="alert" id="flash">
                          <i class="mdi mdi-check"></i> {{session()->get('success')}} Bạn có muốn<a href="{{route('login')}}" class="alert-link"> đăng nhập</a>
                       </div>
                    @endif
                    <!-- Form -->
                    <form class="form-horizontal m-t-20" action="{{route('user.register.create')}}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="row p-b-30">
                            <div class="col-12 col-lg-6">
                                <!-- username-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="register-w-f">Họ Tên</i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="txtname" placeholder="Họ tên" value="{{ old('txtname') }}" required  autofocus="true">
                                </div>
                                <!-- image-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="register-w-f">Hình ảnh của bạn</i></span>
                                    </div>
                                    <input type="file" class="register-file form-control form-control-lg" name="txtimage" placeholder="Hình ảnh" value="{{ old('txtimage') }}" required>
                                </div>
                                <!-- account-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="register-w-f">UserName</i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="txtaccount" placeholder="Username" value="{{ old('txtaccount') }}" required>
                                </div>
                                <!--passwork-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i class="register-w-f">Mật khẩu</i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" name="txtpass" placeholder="Mật khẩu" required>
                                </div>
                                <!--confirm passwork-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i class="register-w-f">Nhập lại mật khẩu</i></span>
                                    </div>
                                    <input type="password" class="form-control form-control-lg" name="txtrepass" placeholder="Xác nhận mật khẩu" required>
                                </div>
                                <!-- email -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="register-w-f">Email</i></span>
                                    </div>
                                    <input type="email" class="form-control form-control-lg" name="txtemail" placeholder="Email" value="{{ old('txtemail') }}" required>
                                </div>
                                <!-- cmnd -->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon1"><i class="register-w-f">Số CMND</i></span>
                                    </div>
                                    <input type="number" class="form-control form-control-lg" name="txtcmnd" placeholder="Số chứng minh nhân dân" value="{{ old('txtcmnd') }}" required>
                                </div>
                                
                            </div>
                            <div class="col-12 col-lg-6">
                                <!--phone-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i class="register-w-f">Điện Thoại</i></span>
                                    </div>
                                    <input type="number" class="form-control form-control-lg" name="txtphone" placeholder="Điện thoại" value="{{ old('txtphone') }}" required>
                                </div>
                                <!--Gender and Birthday-->
                                <div class="input-group mb-3 register-margin-right">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i class="register-w-f">Giới Tính</i></span>
                                    </div>
                                    <select style="height:46px;" class="form-control form-control-lg" name="txtgender" value="{{ old('txtgender') }}" required>
                                        <option value="">--</option>
                                        <option value="0">Nam</option>
                                        <option value="1">Nữ</option>
                                    </select>
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i>Ngày Sinh</i></span>
                                    </div>
                                    <input class="form-control form-control-lg" type="date"  id="example-date-input" name="txtday" value="{{ old('txtday') }}" required>
                                </div>
                                <!--address-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i class="register-w-f">Địa chỉ</i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="txtaddress" placeholder="Địa chỉ"  value="{{ old('txtaddress') }}" required>
                                </div>
                                <!--number bank-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i class="register-w-f">Số tài khoản</i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="txtnumberbank" placeholder="Số tài khoản" required>
                                </div>
                                <!--name bank 1-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i class="register-w-f">Tên ngân hàng</i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="txtnamebank1" placeholder="Ngân hàng" required>
                                </div>
                                <!--name bank 2-->
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success text-white" id="basic-addon2"><i class="register-w-f">Chi nhánh</i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="txtnamebank2" placeholder="Chi nhánh ngân hàng" required>
                                </div>
                                <!--nguoigioithieu-->
                                @if(isset($nguoigioithieu))
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white" id="basic-addon2"><i class="register-w-f">Người giới thiệu</i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" name="txtaddress" placeholder="Địa chỉ"  value="{{ $nguoigioithieu->manhanvien }} - {{ $nguoigioithieu->tennhanvien }}" readOnly>
                                    <input type="hidden" id="nguoigioithieuban" name="nguoigioithieuban" value="{{ $nguoigioithieu->id }}">
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12 text-right">
                                    <div class="p-t-20">
                                        <button class="btn btn-lg btn-info" type="submit">Đăng ký</button>
                                    </div>
                            </div>
                        </div>
                    </form>
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
        $("input").attr('autocomplete', 'off');
    </script>
</body>

</html>