<?php
namespace ghopunk\Helpers;

use ghopunk\Helpers\Str;
use DateTime;

class Tme {
	
	public static function humanTimeDiff( $from, $to = 0 ) {
		if ( empty( $to ) ) {
			$to = time();
		}
		
		$origin 	= new DateTime( date( 'Y-m-d H:i:s', $from ) );
		$target 	= new DateTime( date( 'Y-m-d H:i:s', $to ) );
		$interval	= $origin->diff( $target );
		$since 		= array();
		$is_hour 	= true;
		if( $interval->y >= 1 ){
			$is_hour = false;
			$since[] = $interval->y;
			$since[] = $interval->y <= 1? 'year' : 'years';
		}
		if( $interval->m >= 1 ){
			$is_hour = false;
			$since[] = $interval->m;
			$since[] = $interval->m <= 1? 'month' : 'months';
		}
		if( $interval->d >= 1 ){
			if( $interval->d >= 3 ){
				$is_hour = false;
			}
			$since[] = $interval->d;
			$since[] = $interval->d <= 1? 'day' : 'days';
		}
		if( $is_hour ) {
			$since[] = $interval->format( '%H:%I' );
			$since[] = $interval->h <= 1? 'hour' : 'hours';
		}
		return implode( ' ', $since );
	}

	public static function humanTime( $seconds ) {
		$output = [];
		$day	= floor( $seconds / (3600 * 24) );
		if( $day > 0 ) {
			$output[] = $day . ' ' . ( $day > 1 ? 'days' : 'day' );
		}
		$hour	= floor( $seconds / 3600 % 24 );
		if( $hour > 0 || $day > 0 ) {
			$output[] = $hour . ' ' . ( $hour > 1 ? 'hours' : 'hour' );
		}
		$minute		= floor( $seconds / 60 % 60 );
		$output[]	= $minute . ' ' . ( $minute > 1 ? 'minutes' : 'minute' );
		$second		= floor( $seconds % 60 );
		$output[]	= $second . ' ' . ( $second > 1 ? 'seconds' : 'second' );
		
		$output		= implode( ' ' , $output );
		return $output;
	}

	public static function secondsToTime( $seconds ) {
		$seconds	= round( $seconds );
		$output 	= sprintf( '%02d:%02d:%02d', ( $seconds / 3600 ), ( $seconds / 60 % 60 ), $seconds % 60 );
		return $output;
	}
	
}