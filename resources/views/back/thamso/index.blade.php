@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script type="text/javascript">
  $(function() {
     $('#flash').delay(2500).fadeOut(800);
  });
</script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          @if (session()->has('success'))
           <div class="alert alert-success" role="alert" id="flash">
              <i class="mdi mdi-check"></i> {{session()->get('success')}}
           </div>
          @endif
          <div class="block-header">
            <h5 class="card-title">Danh sách tham số hoa hồng</h5>
            <div class="block-tool">
               <!--<a class="btn btn-success" href="#">Tạo mới</a> -->
            </div>
          </div>
          <div class="col-md-12">
          </div>
          <table id="table-data-content" class="table table-striped table-bordered">
            <thead>
              <tr>
                <th>Mã tham số</th>
                <th>Tên tham số</th>
                <th>Mô tả thông tin tham số</th>
                <th>Giá trị</th>
                <th>Chức năng</th>
              </tr>
            </thead>
            <tbody>
              @foreach($template['thamso'] as $thamso1)
                <tr>
                    <td>{{ $thamso1->mathamso }}</td>
                    <td>{{ $thamso1->tenthamso }}</td>
                    <td data-toggle="tooltip" data-placement="top" title="{{ $thamso1->mota }}">{{ str_limit($thamso1->mota, 50) }}</td>
                    <td>{{ $thamso1->giatrithamso }}</td>
                    <td>
                      <a href="{{ route('admin.thamso.update',$thamso1->id) }}" class="btn btn-info btn-sm">
                              <i class="mdi mdi-table-edit"></i> Edit
                      </a>
                      <!--<a type="button" class="btn btn-danger btn-sm" data-id="{{ $thamso1->id}}">-->
                      <!--  <i class="mdi mdi-delete-empty"></i> Delete-->
                      <!--</a>-->
                    </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection