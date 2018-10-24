@extends('back.layouts.app')
@section('styles')
@endsection
@section('scripts')
@endsection
@section('content')
<div class="container-fluid">
 <div class="row">
    <div class="col-md-12">
    	<div class="card card-body printableArea">
          <div class="row">
            <div class="col-md-12">
      	   <h3>Chi tiết doanh thu</h3>
				   <hr>
			      @include('back.doanhthu.table', ['doanhthu' => $doanhthu])
				    </div>
				  </div>
				  <div class="col-md-12">
		        <div class="text-right">
		         <a class="btn btn-secondary" href="{{ route('admin.doanhthu.index') }}">Quay lại</a>
		        </div>
		     </div>
			</div>
    </div>
 </div>
</div>
@endsection