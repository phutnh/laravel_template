<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('setting.admin.path_css') . '/icons/logo-icon.png') }}">
    <title>{{ $template['title'] }} - {{ config('app.name') }}</title>
    <link href="{{ asset(config('setting.admin.path_css') . 'select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset(config('setting.admin.path_css') . 'bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset(config('setting.admin.path_css') . 'dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset(config('setting.admin.path_css') . 'style.min.css') }}" rel="stylesheet">
    <link href="{{ asset(config('setting.admin.path_css') . 'bootstrap-notifications.css') }}" rel="stylesheet">
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
				<div id="ajax-messases-loading">Đang xữ lý........</div>
	      <footer class="footer text-center">
	        All Rights Reserved. Copyright {{ date('Y') }}
	      </footer>
      </div>
    </div>
    <script src="{{ asset(config('setting.admin.path_js') . 'jquery.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'popper.min.js') }}"></script>
    <script src="{{ asset(config('setting.admin.path_js') . 'pusher.min.js') }}"></script>
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
    <script type="text/javascript">
      var notificationsCountElem = $('.notification_count');
      var notificationsCount     = parseInt(notificationsCountElem.data('count'));
      var notifications          = $('.notifications');

      // Enable pusher logging - don't include this in production
      Pusher.logToConsole = true;

      var pusher = new Pusher('{{env('PUSHER_APP_KEY')}}', {
        encrypted: true,
        cluster: 'ap1',
      });

      // Subscribe to the channel we specified in our Laravel Event
      var channel = pusher.subscribe('Notify');

      // Bind a function to a Event (the full Laravel class)
      channel.bind('notify-constract-action', function(data) {
        var existingNotifications = notifications.html();
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var newNotificationHtml = `
          <li class="notification active">
            <div class="media">
              <img src="https://api.adorable.io/avatars/71/100.png" class="mr-2 img-circle" alt="${data.sender}">
              <div class="media-body">
                <strong class="notification-title">
                  <a href="#">${data.sender}</a> ${data.action} <a href="#">${data.title}</a>
                </strong>
                <p class="notification-desc">${data.content}</p>
                <div class="notification-meta">
                  <small class="timestamp">${data.created_at}</small>
                </div>
              </div>
            </div>
          </li>
        `;
        notifications.html(newNotificationHtml + existingNotifications);
        notificationsCount += 1;
        notificationsCountElem.attr('data-count', notificationsCount);
        notificationsCountElem.text(notificationsCount);
      });
    </script>
    @isset($template['form-datatable'])
    <script type="text/javascript">
        $('#table-data-content').DataTable(optionsDataTable);
    </script>
    @endisset
  </body>
</html>