@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
<script type="text/javascript">
$('#data-notifications').DataTable({
  "language": languageDatatable,
  "scrollX": true,
});
</script>
@endsection

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Danh sách thông báo</h5>
           <table id="data-notifications" class="table table-striped table-bordered" style="width: 100%">
              <thead>
               <tr>
                  <th class="nowrap">Người gửi</th>
                  <th class="nowrap">Nội dung</th>
                  <th class="nowrap">Trạng thái</th>
                  <th class="nowrap" width="80">Chi tiết</th>
               </tr>
              </thead>
              <tbody>
                @foreach ($notifications as $notification)
                <tr>
                  <td class="nowrap">{{ $notification->data['sender'] }}</td>
                  <td class="nowrap">{{ $notification->data['action'] .' '. $notification->data['title'] .' '. $notification->data['content'] }}</td>
                  <td class="nowrap">{{ $notification->read_at ? 'Đã đọc' : 'Chưa đọc' }}</td>
                  <td width="80" class="nowrap">
                    <a class="btn btn-info btn-sm" href="" target="_blank">
                      <i class="mdi mdi-link"></i>Chi tiết
                    </a>
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