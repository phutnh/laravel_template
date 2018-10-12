@extends('back.layouts.app')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="block-header">
            <h5 class="card-title">Thông tin nhân sự</h5>
          </div>
            <div class="d-flex flex-row comment-row">
                <div class="p-2"><img src="{{URL('public/image/5.jpg')}}" alt="user" width="50" class="rounded-circle"></div>
                <div class="comment-text w-100">
                    <h6 class="font-medium">Nguyễn Thương Tính</h6>
                    <span class="m-b-15 d-block">Lorem Ipsum is simply dummy text of the printing and type setting industry. </span>
                    <div class="comment-footer">
                        <span class="text-muted float-right">Ngày đăng ký 2017-05-11 07:23:11</span> 
                        <span class="badge badge-primary">Nhân viên</span>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection