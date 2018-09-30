@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
  <script type="text/javascript">
    optionsDataTable = {
      "ajax": "{{ route('api.get_user') }}",
      "language": languageDatatable,
      "processing": true,
      "serverSide": true,
      "columns": [
        { "data": "name" },
        { "data": "email" },
      ]
    };
  </script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Basic Datatable</h5>
          <table id="table-data-content" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Name</th>
                <th>email</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection