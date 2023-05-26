<?php
namespace ghopunk\Helpers;

use ghopunk\Helpers\Str;

class FO {
	
	public static function codeErrorUploadMessage($code){
		switch ($code) {
			case UPLOAD_ERR_INI_SIZE:
				$message = "The uploaded file exceeds the upload_max_filesize directive in php.ini";
				break;
			case UPLOAD_ERR_FORM_SIZE:
				$message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form";
				break;
			case UPLOAD_ERR_PARTIAL:
				$message = "The uploaded file was only partially uploaded";
				break;
			case UPLOAD_ERR_NO_FILE:
				$message = "No file was uploaded";
				break;
			case UPLOAD_ERR_NO_TMP_DIR:
				$message = "Missing a temporary folder";
				break;
			case UPLOAD_ERR_CANT_WRITE:
				$message = "Failed to write file to disk";
				break;
			case UPLOAD_ERR_EXTENSION:
				$message = "File upload stopped by extension";
				break;
			default:
				$message = "Unknown upload error";
				break;
		}
		return $message;
	}
	
	//return 100 MB
	public static function getMaxUpload(){
		$upload_max_filesize	= ini_get("upload_max_filesize");
		$upload_max_filesize	= static::stringToBytes($upload_max_filesize);
		$post_max_size 			= ini_get("post_max_size");
		$post_max_size			= static::stringToBytes($post_max_size);
		$max 					= min($upload_max_filesize,$post_max_size);
		return static::formatBytes($max);
	}
	
	//1024 => 1 KB
	public static function formatBytes($bytes, $precision = 2) {
		if( !is_numeric($bytes) ){
			$bytes = static::fileSize2Bytes($bytes);
		}
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
		$bytes = max($bytes, 0);
		$bytes	= floatval($bytes);
		$pow = floor(($bytes ? log($bytes) : 0) / log(1024));
		$pow = min($pow, count($units) - 1);
		$bytes /= pow(1024, $pow);
		return round($bytes, $precision) . ' ' . $units[$pow];
	}
	
	//1MB / 1M /1 MB /1 M => 1048576
	public static function fileSize2Bytes($str) {
		$bytes = 0;
		$bytes_array = array(
			'B' => 1,
			'KB' => 1024,
			'MB' => 1024 * 1024,
			'GB' => 1024 * 1024 * 1024,
			'TB' => 1024 * 1024 * 1024 * 1024,
			'PB' => 1024 * 1024 * 1024 * 1024 * 1024,
		);
		$bytes = floatval($str);
		if ( preg_match('#([KMGTP]?B)$#si', $str, $matches) && !empty($bytes_array[$matches[1]]) ) {
			$bytes *= $bytes_array[$matches[1]];
		} elseif ( preg_match('#([KMGTP])$#si', $str, $matches) && !empty($bytes_array[$matches[1].'B']) ) {
			$bytes *= $bytes_array[$matches[1].'B'];
		}
		$bytes = intval(round($bytes, 2));
		return $bytes;
	}
	
	//1M / 1MB => 1048576
	public static function stringToBytes($from){
		$units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
		$number = substr($from, 0, -2);
		$suffix = strtoupper(substr($from,-2));
		if( is_numeric(substr($suffix, 0, 1)) ) {
			$units = ['B', 'K', 'M', 'G', 'T', 'P'];
			$number = substr($from, 0, -1);
			$suffix = strtoupper(substr($from,-1));
			if( is_numeric(substr($suffix, 0, 1)) ) {
				return preg_replace('/[^\d]/', '', $from);
			}
		}
		$exponent = array_flip($units)[$suffix] ?? null;
		if( $exponent === null ) {
			return null;
		}
		$number 	= floatval($number);
		$exponent 	= floatval($exponent);
		return $number * (1024 ** $exponent);
	}
	
	public static function getRealPath($filename){
		$paths 		= explode(PATH_SEPARATOR, getenv("PATH"));
		$pathexts 	= explode(PATH_SEPARATOR, getenv("PATHEXT"));
		
		$listfile 	= array();
		$is_file 	= false;
		$real_file 	= false;
		foreach ($paths as $path) {
			$file = Str::untrailingslashit($path) . DIRECTORY_SEPARATOR . basename($filename);
			if(is_file($file)){
				$real_file	= $file;
				break;
			} else {
				$listfile[] = $file;
			}
		}
		if(!$real_file && !empty($listfile)){
			foreach ($listfile as $file) {
				foreach ($pathexts as $ext) {
					$isfile = $file . $ext;
					if(is_file($isfile)){
						$is_file 	= true;
						$real_file	= $isfile;
						break;
					}
				}
				if( $is_file ) break;
			}
		}
		return $real_file;
	}

	public static function readFileChunk( $filename, $chunk_size=false, $retbytes=true, $data=false ) {
		if( empty($chunk_size) ) {
			$chunk_size	= 10 * ( 1024 * 1024 ); // how many bytes per chunk
		} else {
			$chunk_size = static::convertToBytes($chunk_size);
		}
		$size 	= filesize($filename);
		$buffer	= '';
		$cnt	= 0;
		$handle	= fopen( $filename, 'rb' );
		if ($handle === false) {
			return false;
		}
		if( $size > $chunk_size) {
			while ( !feof($handle) ) {
				$buffer	= fread( $handle, $chunk_size );
				echo $buffer;
				ob_flush();
				flush();
				if ( $retbytes ) {
					$cnt += strlen( $buffer );
				}
			}
		} else {
			$buffer	= fread( $handle, $size );
			echo $buffer;
			ob_flush();
			flush();
			if ( $retbytes ) {
				$cnt += strlen( $buffer );
			}
		}
		$status = fclose( $handle );
		if ( $retbytes && $status ) {
			return $cnt; // return num. bytes delivered like readfile() does.
		}
		return $status;
	}

}
