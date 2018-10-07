@if ($errors->any())
  <div class="alert alert-danger">
    <ul class="mc-no-margin-bottom">
    @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
    @endforeach
      </ul>
  </div>
@endif