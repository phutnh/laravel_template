<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('css/admincp/icons/favicon.png') }}">
    <title>Matrix Template - The Ultimate Multipurpose admin template</title>
    <!-- Custom CSS -->
    <link href="{{ asset('css/admincp/style.min.css') }}" rel="stylesheet">
    @yield('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <div id="main-wrapper">
			@include('back.layouts.header')
      <div class="page-wrapper">
			@yield('content')
       <footer class="footer text-center">
          All Rights Reserved. Copyright {{ date('Y') }}
        </footer>
      </div>
    </div>
    <script src="{{ asset('js/admincp/jquery.min.js') }}"></script>
    <script src="{{ asset('js/admincp/popper.min.js') }}"></script>
    <script src="{{ asset('js/admincp/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/admincp/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('js/admincp/sparkline.js') }}"></script>
    <script src="{{ asset('js/admincp/waves.js') }}"></script>
    <script src="{{ asset('js/admincp/sidebarmenu.j') }}s"></script>
    <script src="{{ asset('js/admincp/custom.min.js') }}"></script>
  </body>
</html>