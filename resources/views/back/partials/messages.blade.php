@if (session('status'))
  <div class="alert alert-success">
    {{ session('status') }}
  </div>
@endif

@if (session('messages'))
  <div class="alert alert-success">
    {{ session('messages') }}
  </div>
@endif