<?php
namespace ghopunk\Helpers;

class Num {
	
	//membulatkan ke kelipatan($significance)
	//ceiling( 6, 5 ) => 10
	//return int or false
	public static function ceiling( $number, $significance = 1 )
	{
		return ( is_numeric($number) && is_numeric($significance) ) ? (ceil($number/$significance)*$significance) : false;
	}
	
	//pangkat
	public static function pow($number, $exponent)
	{
		//positifkan dahulu
		$abs 		= abs($exponent);
		$floor_abs	= floor(abs($exponent));
		$selisih	= $abs-$floor_abs;
		if( $selisih > 0 ) { //pangkat decimal
			$akar 	= 1/$selisih;
			$result	= self::nthSqrt( $number, $akar );
		} else {
			$result = 1;
			for ( $i = 1; $i <= abs($exponent); $i++ ) {
				$result *= $number;
			}
			if( $exponent < 0 ) { //pangkat negatif
				$result = 1/$result;
			}
		}
		return $result;
	}
	
	//akar
	public static function sqrt( $number )
	{
		if( $number > 2 ) {
			$y = $number;
			$z = ($y + ($number/$y))/2;
			while( abs($y-$z)>=0.000001 ){
				$y = $z;
				$z = ($y + ($number/$y))/2;
			}
			return $z;
		}
		return $number;
	}
	
	//akar pangkat
	public static function nthSqrt( $number, $nthRoot = 2 )
	{
		return pow( $number, (1/$nthRoot) );
	}
	
	//floor decimal
	public static function floorDec( $number, $decimals = 2 )
	{    
		return floor( $number * pow( 10, $decimals ) ) / pow( 10, $decimals );
	}
}