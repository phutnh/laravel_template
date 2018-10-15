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


if(!function_exists('isAdminCP'))
{
	function isAdminCP()
	{
		return Auth::user()->phanquyen == 1 ? true : false;
	}
}


if(!function_exists('formatDateTimeData'))
{
	function formatDateTimeData($date, $format = 'd-m-Y H:i:s')
	{
		if($date == null)
			return date($format, strtotime(date($format)));
		return date($format, strtotime($date));
	}
}


if(!function_exists('formatDateSqlData'))
{
	function formatDateSqlData($date)
	{
		if($date == null)
			return date('Y-m-d', strtotime(date($format)));
		$dates = explode('/', $date);
		$data = $dates[2].'/'.$dates[1].'/'.$dates[0];
		return $data;
	}
}


if(!function_exists('getFristDayOfMonth'))
{
	function getFristDayOfMonth()
	{
		$date = date('Y-m-d');
		return date("Y-m-01", strtotime($date));
	}
}

if(!function_exists('getLastDayOfMonth'))
{
	function getLastDayOfMonth()
	{
		$date = date('Y-m-d');
		return date("Y-m-t", strtotime($date));
	}
}