<div class="page-breadcrumb">
  <div class="row">
    <div class="col-12 d-flex no-block align-items-center">
      <h4 class="page-title">{{ $template['title-breadcrumb'] }}</h4>
      <div class="ml-auto text-right">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item">
              <a href="{{ route('admin.dashboard') }}">Trang chủ</a>
            </li>
            @foreach ($template['breadcrumbs'] as $breadcrumb)
            @if ($breadcrumb['active'])
            <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
            @else
            <li class="breadcrumb-item">
              <a href="{{ $breadcrumb['link'] }}">{{ $breadcrumb['name'] }}</a>
            </li>
            @endif
            
            @endforeach
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>