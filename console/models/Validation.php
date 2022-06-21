<?php

namespace console\models;

class Validation
{
	public static function url_exists($url)
	{
		$h = get_headers($url);
		$status = [];
		preg_match('/HTTP\/.* ([0-9]+) .*/', $h[0], $status);
		if ($status[1] != 200) {
			return false;
		}
		return true;
	}

	public static function file_exist($path)
	{
		if (!file_exists($path)) {
			return false;
		}
		return true;
	}

	public static function isJson($string)
	{
		json_decode($string);
		if (json_last_error() == JSON_ERROR_NONE) {
			return true;
		}
		return false;
	}
}
