<?php
namespace ghopunk\Helpers;

use ghopunk\Helpers\Str;
use ghopunk\Helpers\Arr;

class Form {
	
	public static function getChecked( $key, $value, $default = false ){
		$return = false;
		if( is_object($value) ){
			$res 	= Arr::objectToArray($value);
			$return = call_user_func_array( '\\' . __METHOD__, array( $key, $res, $default ) );
		} elseif( is_array($value) && in_array($key, $value) ){
			$return = 'checked';
		} elseif($key == $value || !empty($default) && $key == $default){
			$return = 'checked';
		}
		return $return;
	}

	public static function getSelected( $key, $value, $default = false ){
		$return = false;
		if( is_object($value) ){
			$res 	= Arr::objectToArray($value);
			$return = call_user_func_array( '\\' . __METHOD__, array( $key, $res, $default ) );
		} elseif( is_array($value) && in_array($key, $value) ){
			$return = 'selected';
		} elseif( $key == $value || !empty($default) && $key == $default ){
			$return = 'selected';
		}
		return $return;
	}

	public static function getDisabled( $key, $value, $default = false ){
		$return = false;
		if( is_object($value) ){
			$res 	= Arr::objectToArray($value);
			$return = call_user_func_array( '\\' . __METHOD__, array( $key, $res, $default ) );
		} elseif( is_array($value) && in_array($key, $value) ){
			$return = 'disabled';
		} elseif( $key == $value || !empty($default) && $key == $default ){
			$return = 'disabled';
		}
		return $return;
	}

	public static function getResultKey( $result, $key, $default = false ){
		if( is_object($result) ){
			$res 	= Arr::objectToArray($result);
			return call_user_func_array( '\\' . __METHOD__, array( $res, $key, $default) );
		} elseif( is_array($result) ){
			$result = array_change_key_case($result);
			$key 	= strtolower($key);
		}
		$text	= isset($result[$key]) ? Str::trim($result[$key]) : $default;
		return $text;
	}
	
}