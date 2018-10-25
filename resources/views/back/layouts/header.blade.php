<header class="topbar" data-navbarbg="skin5">
  <nav class="navbar top-navbar navbar-expand-md navbar-dark">
    <div class="navbar-header" data-logobg="skin5">
      <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
        <b class="logo-icon p-l-10">
          <img src="{{ asset('css/admincp/icons/logo-icon.png') }}" alt="homepage" class="light-logo logo-ad-w-h" />
        </b>
        <span class="logo-text">
          <img src="{{ asset('css/admincp/icons/logo-text.png') }}" alt="homepage" class="light-logo" />
        </span>
      </a>
      <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
    </div>
    <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
      <ul class="navbar-nav float-left mr-auto">
        <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <span class="d-none d-md-block">Truy cập nhanh <i class="fa fa-angle-down"></i></span>
          <span class="d-block d-md-none"><i class="fa fa-plus"></i></span>   
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="{{ route('admin.hopdong.index') }}">Hợp đồng</a>
            @if(isAdminCP())
            <a class="dropdown-item" href="{{ route('admin.doanhthu.thang') }}">Doanh thu</a>
            @endif
            <a class="dropdown-item" href="{{ route('admin.commission.history') }}">Lịch sữ nhận hoa hồng</a>
          </div>
        </li>
      </ul>
      <ul class="navbar-nav float-right">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-bell font-24"><span class="notification_count" style="font-size: 15px" data-count="{{ getCountNotifications() }}">{{ getCountNotifications() }}</span></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
            <div class="mc-notifications-header">
              <div class="left">Thông báo (<span class="notification_count">
                {{ getCountNotifications() }}
              </span>)</div>
              <div class="right">
                <a href="#">Đánh dấu đã đọc</a>
              </div>
            </div>
            <div class="mc-clear-both"></div>
            <ul class="notifications" style="max-height: 400px; overflow-y: auto;">
              @foreach (Auth::user()->unreadNotifications as $notification)
              <li class="notification">
                <div class="media">
                  <img src="https://api.adorable.io/avatars/71/100.png" class="mr-2 img-circle" alt="{{ $notification->data['sender'] }}">
                  <div class="media-body">
                    <strong class="notification-title">
                      <a href="#">{{ $notification->data['sender'] }}</a> {{ $notification->data['action'] }} <a href="#">{{ $notification->data['title'] }}</a>
                    </strong>
                    <p class="notification-desc">{{ $notification->data['content'] }}.</p>
                    <div class="notification-meta">
                      <small class="timestamp">{{ $notification['created_at'] }}</small>
                    </div>
                  </div>
                </div>
              </li>
              @endforeach
            </ul>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ asset('css/admincp/icons/account.png') }}" alt="user" class="rounded-circle" width="31"></a>
          <div class="dropdown-menu dropdown-menu-right user-dd animated">
            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-user m-r-5 m-l-5"></i> My Profile</a>
            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-wallet m-r-5 m-l-5"></i> My Balance</a>
            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-email m-r-5 m-l-5"></i> Inbox</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0)"><i class="ti-settings m-r-5 m-l-5"></i> Account Setting</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fa fa-power-off m-r-5 m-l-5"></i> Đăng xuất
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
            <div class="dropdown-divider"></div>
            <div class="p-l-30 p-10"><a href="{{ route('user.profile.view') }}" class="btn btn-sm btn-success btn-rounded">View Profile</a></div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>

<aside class="left-sidebar" data-sidebarbg="skin5">
  <div class="scroll-sidebar">
    <nav class="sidebar-nav">
      <ul id="sidebarnav" class="p-t-30">
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.dashboard') }}" aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Trang chủ</span></a></li>
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('user.profile.view') }}" aria-expanded="false"><i class="mdi mdi-account-circle"></i><span class="hide-menu">Thông tin cá nhân</span></a></li>
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.thamso.index') }}" aria-expanded="false"><i class="mdi mdi-flower"></i><span class="hide-menu">Quản lý tham số hoa hồng</span></a></li>
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.qlnhansu') }}" aria-expanded="false"><i class="mdi mdi-chart-bar"></i><span class="hide-menu">Quản lý nhân viên</span></a></li>
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.hopdong.index') }}" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Quản lý hợp đồng</span></a></li>
        <li class="sidebar-item">
          <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Quản lý doanh thu</span></a>
          <ul aria-expanded="false" class="collapse  first-level">
            <li class="sidebar-item"><a href="{{ route('admin.doanhthu.thang') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu">Doanh thu nhân viên</span></a></li>
            <li class="sidebar-item"><a href="{{ route('admin.doanhthu.index') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu">Doanh thu đã chốt</span></a></li>
            <li class="sidebar-item"><a href="{{ route('admin.doanhthu.action') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Chốt doanh thu</span></a></li>
          </ul>
        </li>
        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.commission.history') }}" aria-expanded="false"><i class="mdi mdi-border-inside"></i><span class="hide-menu">Lịch sử nhận hoa hồng</span></a></li>
        <li class="sidebar-item">
          <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Quản lý rút tiền</span></a>
          <ul aria-expanded="false" class="collapse  first-level">
            <li class="sidebar-item"><a href="{{ route('admin.trans.detail') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu">Quản lý rút tiền</span></a></li>
            <li class="sidebar-item"><a href="{{ route('admin.trans.applytrans') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu">Quản lý duyệt tiền</span></a></li>
          </ul>
        </li>

        <!--<li class="sidebar-item">-->
        <!--  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu">Báo cáo</span></a>-->
        <!--  <ul aria-expanded="false" class="collapse  first-level">-->
        <!--    <li class="sidebar-item"><a href="icon-material.html" class="sidebar-link"><i class="mdi mdi-emoticon"></i><span class="hide-menu"> Doanh thu tháng </span></a></li>-->
        <!--    <li class="sidebar-item"><a href="#" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Lịch sử nhận hoa hồng </span></a></li>-->
        <!--  </ul>-->
        <!--</li>-->
        <!--<li class="sidebar-item">-->
        <!--  <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-face"></i><span class="hide-menu">Thống kê</span></a>-->
        <!--  <ul aria-expanded="false" class="collapse  first-level">-->
        <!--    <li class="sidebar-item"><a href="icon-material.html" class="sidebar-link"><i class="mdi mdi-emoticon"></i><span class="hide-menu"> Nhân viên </span></a></li>-->
        <!--    <li class="sidebar-item"><a href="icon-fontawesome.html" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Lịch sử rút tiền </span></a></li>-->
        <!--    <li class="sidebar-item"><a href="icon-fontawesome.html" class="sidebar-link"><i class="mdi mdi-emoticon-cool"></i><span class="hide-menu"> Lịch sử chi tiền </span></a></li>-->
        <!--  </ul>-->
        <!--</li>-->
      </ul>
    </nav>
  </div>
</aside>