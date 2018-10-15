<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('setting.admin.path_css') . '/icons/favicon.png') }}">
    <title>{{ $template['title'] }} - {{ config('app.name') }}</title>
    <link href="{{ asset(config('setting.admin.path_css') . 'select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset(config('setting.admin.path_css') . 'bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset(config('setting.admin.path_css') . 'dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset(config('setting.admin.path_css') . 'style.min.css') }}" rel="stylesheet">
    <!-- Add start ThangTGM 11/10/2018 -->
    <link href="{{ asset(config('setting.admin.path_css') . 'custom.css') }}" rel="stylesheet">
    <!-- Add end -->
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
	    	@include('back.layouts.breadcrumb')
				@yield('content')
				<div id="ajax-messases-loading">Loading........</div>
	      <footer class="footer text-center">
	        All Rights Reserved. Copyright {{ date('Y') }}
	      </footer>
      </div>
    </div>
    <script src="{{ asset(config('setting.admin.path_js') . 'jquery.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'popper.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'bootstrap.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'waves.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'select2.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'jquery.form.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'ajax-form.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'custom.js') }}"></script>
    @yield('scripts')
    @isset($template['form-datatable'])
    <script type="text/javascript">
        $('#table-data-content').DataTable(optionsDataTable);
    </script>
    @endisset
  </body>
</html>