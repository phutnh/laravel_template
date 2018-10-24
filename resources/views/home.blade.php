@extends('front.layouts.app')

@section('content')
	<a href="{{ route('login') }}">Đăng nhập</a><br/>
	<a href="{{ route('user.register.index') }}">Đăng ký</a>
@endsection
