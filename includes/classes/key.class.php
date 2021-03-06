<?php
/**
 * 文件名：key.class.php
 * 加密算法的二次封装，感谢山东建材学院马老师提供此算法。
 * 功能：加解密字符串
 *
 * @author  dengyong <dy810810@hotmail.com>
 * @version  $Id: key.class.php,v 1.3 2008/06/27 00:26:17 dengyong Exp $
 * @access  static public
 * @see 
 * @package common
 */
final class key
{
	/**
	 * 加密算法的密钥
	 *
	 * @var string
	 * @access private
	 */
	private static $_mStrKey="FGHIOPOITYEDFGNJM9876TGHJK";
	
	/**
	 * 给出一个加密后的字符串，该字符串经base64编码
	 *
	 * @param string $enString
	 * @return string
	 * @access public
	 */
	public static function GetEncrypt($enString)
	{
		return base64_encode(self::_encrypt($enString,self::$_mStrKey));
	}
	/**
	 * 给出一个解密后的字符串，先base64反编码再解密
	 *
	 * @param string $deString
	 * @return unknown
	 */
	public static function GetDecrype($deString)
	{
		return self::_decrypt(base64_decode($deString),self::$_mStrKey);
	}
	
	private static function long2str($v, $w)
	{
		$len = count($v);
		$n = ($len - 1) << 2;
		if ($w) {
			$m = $v[$len - 1];
			if (($m < $n - 3) || ($m > $n)) return false;
			$n = $m;
		}
		$s = array();
		for ($i = 0; $i < $len; $i++) {
			$s[$i] = pack("V", $v[$i]);
		}
		if ($w) {
			return substr(join('', $s), 0, $n);
		}
		else {
			return join('', $s);
		}
	}
	private static function str2long($s, $w)
	{
		$v = unpack("V*", $s. str_repeat("\0", (4 - strlen($s) % 4) & 3));
		$v = array_values($v);
		if ($w) {
			$v[count($v)] = strlen($s);
		}
		return $v;
	}
	private static function int32($n)
	{
		while ($n >= 2147483648) $n -= 4294967296;
		while ($n <= -2147483649) $n += 4294967296;
		return (int)$n;
	}
	private static function _encrypt($str, $key)
	{
		if ($str == "") {
			return "";
		}
		$v = self::str2long($str, true);
		$k = self::str2long($key, false);
		if (count($k) < 4) {
			for ($i = count($k); $i < 4; $i++) {
				$k[$i] = 0;
			}
		}
		$n = count($v) - 1;
		$z = $v[$n];
		$y = $v[0];
		$delta = 0x9E3779B9;
		$q = floor(6 + 52 / ($n + 1));
		$sum = 0;
		while (0 < $q--) {
			$sum = self::int32($sum + $delta);
			$e = $sum >> 2 & 3;
			for ($p = 0; $p < $n; $p++) {
				$y = $v[$p + 1];
				$mx = self::int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
				$z = $v[$p] = self::int32($v[$p] + $mx);
			}
			$y = $v[0];
			$mx = self::int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$z = $v[$n] = self::int32($v[$n] + $mx);
		}
		return self::long2str($v, false);
	}
	private static function _decrypt($str, $key)
	{
		if ($str == "") {
			return "";
		}
		$v = self::str2long($str, false);
		$k = self::str2long($key, false);
		if (count($k) < 4) {
			for ($i = count($k); $i < 4; $i++) {
				$k[$i] = 0;
			}
		}
		$n = count($v) - 1;
		$z = $v[$n];
		$y = $v[0];
		$delta = 0x9E3779B9;
		$q = floor(6 + 52 / ($n + 1));
		$sum = self::int32($q * $delta);
		while ($sum != 0) {
			$e = $sum >> 2 & 3;
			for ($p = $n; $p > 0; $p--) {
				$z = $v[$p - 1];
				$mx = self::int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
				$y = $v[$p] = self::int32($v[$p] - $mx);
			}
			$z = $v[$n];
			$mx = self::int32((($z >> 5 & 0x07ffffff) ^ $y << 2) + (($y >> 3 & 0x1fffffff) ^ $z << 4)) ^ self::int32(($sum ^ $y) + ($k[$p & 3 ^ $e] ^ $z));
			$y = $v[0] = self::int32($v[0] - $mx);
			$sum = self::int32($sum - $delta);
		}
		return self::long2str($v, true);
	}
}
?>