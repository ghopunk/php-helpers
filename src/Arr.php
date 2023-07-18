<?php

namespace ghopunk\Helpers;

class Arr {
	
	public static function array_unique( $text ){
		if( is_array($text) ){
			foreach ($text as &$value){
				if ( is_array($value) ){
					$value = call_user_func( '\\' . __METHOD__, $value );
				}
			}
			$text = array_unique($text); 
		}
		return $text;
	}
	
	public static function implode( $sep = '', $arr ){
		if( is_array($arr) ){
			$arr = implode( $sep, $arr );
		}
		return $arr;
	}
	
	public static function explode( $sep = '', $text ){
		if( is_string($text) ){
			$text = explode( $sep, $text );
		}
		return $text;
	}
	
	public static function array_filter( $arr, $callback = null ) {
		if( is_array($arr) ){
			foreach ($arr as &$value){
				if ( is_array($value) ){
					$value = call_user_func_array( '\\' . __METHOD__, array($value, $callback) );
				}
			}
			$arr = array_filter($arr); 
		}
		return $arr; 
	}
	
	public static function rand_value( $arr ) {
	   if( is_array($arr) && !empty($arr) ){
			$key 	= array_rand($arr);
			$arr	= $arr[$key];
		}
		return $arr;
	}
	
	public static function objectToArray($d) {
		if ( is_object($d) ) {
			$d = get_object_vars($d);
		}
		if ( is_array($d) ) {
			return array_map( '\\' . __METHOD__, $d );
		} else {
			return $d;
		}
	}
	
	public static function shuffle_assoc( $list ) {
		if ( !is_array($list) ) {
			return $list;
		}
		$keys	= array_keys($list);
		shuffle($keys);
		$random = array();
		foreach ($keys as $key){
			$random[$key] = $list[$key];
		}
		return $random;
	}

	public static function fixedShuffle( $items, $seed = false ){
		if ( !is_array($items) ) {
			return $items;
		}
		if( !empty($seed) && is_numeric($seed) ) {
			@mt_srand($seed);
		}
		$items	= array_values($items);
		for ($i = count($items) - 1; $i > 0; $i--){
			$j		= @mt_rand(0, $i);
			$tmp 	= $items[$i];
			$items[$i] = $items[$j];
			$items[$j] = $tmp;
		}
		return $items;
	}
	
	public static function flatten( $arr ) { 
		if ( !is_array($arr) ) { 
			return $arr; 
		} 
		$list = array(); 
		foreach ( $arr as $key => $value ) { 
			if ( is_array($value) ) {
				$result	= call_user_func( '\\' . __METHOD__, $value);
				$list 	= array_merge( $list, $result ); 
			} else { 
				$list[$key] = $value; 
			} 
		} 
		return $list; 
	}
	
	public static function in_array_i( $needle, $haystack ) {
		$needle		= is_array($needle) ? array_map('strtolower', $needle) : strtolower($needle);
		$haystack 	= is_array($haystack) ? array_map('strtolower', $haystack) : array($haystack);
		if( is_array($needle) ){
			foreach( $needle as $key=>$val ){
				if( call_user_func_array( '\\' . __METHOD__, array($val, $haystack)) ){
					return true;
				}
			}
			return false;
		} else {
			return in_array($needle, $haystack);
		}
	}
	
	public static function array_key_exists( $keySearch, $array ){
		if( is_object($array) ) {
			$array = static::objectToArray($array);
		}
		if( !is_array($array) ) {
			return false;
		}
		foreach ( $array as $key => $value ) {
			if ( $key == $keySearch ) {
				return true;
			} else {
				if( is_object($value) ) {
					$value = static::objectToArray($value);
				}
				if ( is_array($value) && call_user_func_array( '\\' . __METHOD__, array($keySearch, $value)) ) {
					return true;
				}
			}
		}
		return false;
	}
	
	public static function in_array($valSearch, $array, $strict = false){
		if( is_object($array) ) {
			$array = static::objectToArray($array);
		}
		if( !is_array($array) ) {
			return false;
		}
		foreach ($array as $key=>$value) {
			if( is_object($value) ) {
				$value = static::objectToArray($value);
			}
			if ( ( $strict ? $value === $valSearch : $value == $valSearch ) 
				|| ( is_array($value) && call_user_func_array( '\\' . __METHOD__, array($valSearch, $value, $strict) ) )
			) {
				return true;
			}
		}
		return false;
	}
	
	public static function in_array_field($keySearch, $valSearch, $array, $strict = false) {
		if( is_object($array) ) {
			$array = static::objectToArray($array);
		}
		if( !is_array($array) ) {
			return false;
		}
		foreach ($array as $key=>$value) {
			if( is_object($value) ) {
				$value = static::objectToArray($value);
			}
			if ( isset($value[$keySearch]) && ($strict ? $value[$keySearch] === $valSearch : $value[$keySearch] == $valSearch) 
				|| ( is_array($value) && call_user_func_array( '\\' . __METHOD__, array($keySearch, $valSearch, $value, $strict) ) )
			) {
				return true;
			}
		}
		return false;
	}
	
	public static function array_value_field($keySearch, $valSearch, $array, $strict = false) {
		if( is_object($array) ) {
			$array = static::objectToArray($array);
		}
		if( !is_array($array) ) {
			return false;
		}
		foreach ($array as $key=>$value) {
			if( is_object($value) ) {
				$value = static::objectToArray($value);
			}
			if ( isset($value[$keySearch]) && ($strict ? $value[$keySearch] === $valSearch : $value[$keySearch] == $valSearch) 
				|| ( is_array($value) && call_user_func_array( '\\' . __METHOD__, array($keySearch, $valSearch, $value, $strict) ) )
			) {
				return $value;
			}
		}
		return false;
	}
	
	public static function array_key_field($keySearch, $valSearch, $array, $strict = false) {
		if( is_object($array) ) {
			$array = static::objectToArray($array);
		}
		if( !is_array($array) ) {
			return false;
		}
		foreach ($array as $key=>$value) {
			if( is_object($value) ) {
				$value = static::objectToArray($value);
			}
			if ( isset($value[$keySearch]) && ($strict ? $value[$keySearch] === $valSearch : $value[$keySearch] == $valSearch) 
				|| ( is_array($value) && call_user_func_array( '\\' . __METHOD__, array($keySearch, $valSearch, $value, $strict)) )
			) {
				return $key;
			}
		}
		return false;
	}
	
	public static function array_filter_unique($arr){
		if( is_array($arr) ) {
			$arr = array_map('trim', $arr);
			$arr = array_unique($arr);
			$arr = array_filter($arr);
		}
		return $arr;
	}
}