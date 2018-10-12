<?php

if (! function_exists('responseFormData')) {
	function responseFormData($messages)
	{
		return response()->json(['messages' => $messages], 200);
	}
}

if (! function_exists('uploadFileData')) {
	function uploadFileData($file, $path)
	{
		$path = public_path() . '/' . $path;
		$name = uniqid() . time() . '.' .$file->getClientOriginalExtension();
		$file->move($path, $name);
    return $name;
	}
}

if(!function_exists('formatDateData'))
{
	function formatDateData($date, $format = 'd-m-Y')
	{
		if($date == null)
			return date($format, strtotime(date($format)));
		return date($format, strtotime($date));
	}
}

if(!function_exists('formatMoneyData'))
{
	function formatMoneyData($money)
	{
		return number_format($money, 0, ',', '.');
	}
}

if(!function_exists('redirectBackErrorData'))
{
	function redirectBackErrorData($error)
	{
		return redirect()->back()->with('error', $error)->with('danger', 'true')->withInput();
	}
}

if(!function_exists('redirectBackSuccessData'))
{
	function redirectBackSuccessData($messages)
	{
		return redirect()->back()->with('success', $messages);
	}
}

if(!function_exists('getNhanVienID'))
{
	function getNhanVienID()
	{
		return Auth::id();
	}
}


if(!function_exists('getQuyenNhanVien'))
{
	function getQuyenNhanVien()
	{
		return Auth::user()->phanquyen;
	}
}