<?php

namespace ghopunk\Helpers;

class Str {
	
	const MINUTE_IN_SECONDS = 60;
	const HOUR_IN_SECONDS 	= 60 * 60;
	const DAY_IN_SECONDS 	= 24 * 60 * 60;
	const WEEK_IN_SECONDS 	= 7 * 24 * 60 * 60;
	const MONTH_IN_SECONDS 	= 30 * 24 * 60 * 60;
	const YEAR_IN_SECONDS 	= 365 * 24 * 60 * 60;
	
	public static function trim( $text ){
		if( is_array($text) ){
			return array_map( '\\' . __METHOD__, $text );
		} elseif( is_string($text) ){
			$text = trim($text);
		}
		return $text;
	}
	
	public static function addslashes( $text ){
		if( is_array($text) ){
			return array_map( '\\' . __METHOD__, $text );
		} elseif( is_string($text) ){
			$text = addslashes($text);
		}
		return $text;
	}
	
	public static function stripslashes( $text ){
		if( is_array($text) ){
			return array_map( '\\' . __METHOD__, $text);
		} elseif( is_string($text) ){
			$text = stripslashes($text);
		}
		return $text;
	}
	
	public static function strip_tags( $text, $allowable_tags=null){
		if( is_array($text) ){
			return array_map( '\\' . __METHOD__, $text,(array)$allowable_tags );
		}
		return strip_tags( $text, $allowable_tags );
	}
	
	public static function str_replace( $from, $to, $text ){
		if( is_string($text) ){
			$text = str_replace( $from, $to, $text );
		}
		return $text;
	}
	
	public static function trailingslashit( $string ) {
		return static::untrailingslashit( $string ) . '/';
	}
	
	public static function untrailingslashit( $string ) {
		return rtrim( $string, '/\\' );
	}
	
	public static function mb_strtolower($text){
		if( function_exists('mb_strtolower') ){
			return mb_strtolower( $text, 'UTF-8' );
		} else {
			return strtolower( $text );
		}
	}
	
	public static function mb_strtoupper( $text ){
		if( function_exists('mb_strtoupper ')){
			return mb_strtoupper ( $text, 'UTF-8' );
		} else {
			return strtoupper( $text );
		}
	}
	
	public static function trimLastNonAscii( $text ){
		$regex = '/((?:[\x00-\x7F]|[\xC0-\xDF][\x80-\xBF]|[\xE0-\xEF][\x80-\xBF]{2}|[\xF0-\xF7][\x80-\xBF]{3}){1,100})|./x';
		$text = preg_replace( $regex, '$1', $text );
		return $text;
	}
	
	public static function randomAlphabeth( $length = 5 ) {
		$input = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $length; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
		return $random_string;
	}
	
	public static function randomNumeric( $length = 5 ) {
		$input = '0123456789';
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $length; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
		return $random_string;
	}
	
	public static function randomAlphaNumeric($length = 5) {
		$input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$input_length = strlen($input);
		$random_string = '';
		for($i = 0; $i < $length; $i++) {
			$random_character = $input[mt_rand(0, $input_length - 1)];
			$random_string .= $random_character;
		}
		return $random_string;
	}
	
	public static function htmlspecialchars($text){
		if( is_array($text) ){
			return array_map( '\\' . __METHOD__, $text);
		} elseif( is_string($text) ){
			$text = htmlspecialchars($text);
		}
		return $text;
	}
	
	public static function json_decode_nice( $json, $assoc = TRUE ){
		$json = str_replace(array("\n","\r"),"\\n",$json);
		$json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
		$json = preg_replace('/(,)\s*}$/','}',$json);
		return json_decode($json,$assoc);
	}
	
	public static function jsonp_decode($jsonp, $assoc = false) { // PHP 5.3 adds depth as third parameter to json_decode
		if( $jsonp[0] !== '[' && $jsonp[0] !== '{' ) { // we have JSONP
		   $jsonp = substr( $jsonp, strpos($jsonp, '(') );
		}
		return json_decode( trim($jsonp,'();'), $assoc );
	}
	
	public static function jsonp_decode_nice( $json, $assoc = TRUE){
		$json = str_replace(array("\n","\r"),"\\n",$json);
		$json = str_replace('} , {','},{',$json);
		$json = str_replace('\\"','strip_quote',$json);
		$json = preg_replace('/\s"([^,"]+),([^:"]+):([^"]+)"\s/','"$1strip_comma$2strip_colon$3"',$json);
		$json = preg_replace('/([{,]+)(\s*)([^"]+?)\s*:/','$1"$3":',$json);
		$json = preg_replace('/(,)\s*}$/','}',$json);
		$json = str_replace('strip_quote','\\"',$json);
		$json = str_replace('strip_comma',',',$json);
		$json = str_replace('strip_colon',':',$json);
		return static::jsonp_decode($json,$assoc);
	}
	
	//return array
	public static function count_chars( $string ){
		$result = [];
		foreach ( count_chars($string, 1) as $str => $value) {
			$result[]	= [
							'char'	=> chr($str),
							'count'	=> $value
						];
		}
		return $result;
	}
	
}