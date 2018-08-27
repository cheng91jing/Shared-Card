<?php
/**
 * Created by PhpStorm.
 * User: chenjing
 * Date: 2018/8/26
 * Time: 上午10:52
 */

namespace app\common\library;


class EncryptAndDecrypt
{

    public static function convBase($numberInput, $fromBaseInput, $toBaseInput)
    {
        if ($fromBaseInput == $toBaseInput) return $numberInput;
        $fromBase  = str_split($fromBaseInput, 1);
        $toBase    = str_split($toBaseInput, 1);
        $number    = str_split($numberInput, 1);
        $fromLen   = strlen($fromBaseInput);
        $toLen     = strlen($toBaseInput);
        $numberLen = strlen($numberInput);
        $retval    = '';
        if ($toBaseInput == '0123456789') {
            $retval = 0;
            for ($i = 1; $i <= $numberLen; $i++)
                $retval = bcadd($retval, bcmul(array_search($number[$i - 1], $fromBase), bcpow($fromLen, $numberLen - $i)));
            return $retval;
        }
        if ($fromBaseInput != '0123456789')
            $base10 = self::convBase($numberInput, $fromBaseInput, '0123456789');
        else
            $base10 = $numberInput;
        if ($base10 < strlen($toBaseInput))
            return $toBase[$base10];
        while ($base10 != '0') {
            $retval = $toBase[bcmod($base10, $toLen)] . $retval;
            $base10 = bcdiv($base10, $toLen, 0);
        }
        return $retval;
    }

    /**
     * 大数字字符串转换为对应进制
     *
     * @param $str string 需要转换的字符串
     * @param int $frombase 字符串原进制
     * @param int $tobase 需要转换的进制
     *
     * @return int|string
     */
    public static function str_baseconvert($str, $frombase = 10, $tobase = 36)
    {
        $str = trim($str);
        if (intval($frombase) != 10) {
            $len = strlen($str);
            $q   = 0;
            for ($i = 0; $i < $len; $i++) {
                $r = base_convert($str[$i], $frombase, 10);
                $q = bcadd(bcmul($q, $frombase), $r);
            }
        } else $q = $str;

        if (intval($tobase) != 10) {
            $s = '';
            while (bccomp($q, '0', 0) > 0) {
                $r = intval(bcmod($q, $tobase));
                $s = base_convert($r, 10, $tobase) . $s;
                $q = bcdiv($q, $tobase, 0);
            }
        } else $s = $q;

        return $s;
    }

    public static function strToNumberEncode($s)
    {
        preg_match_all('/([a-z]+)|([0-9]+)|([^0-9a-z]+)/i', $s, $t);
        $r = [];
        foreach ($t[0] as $v) {
            foreach (str_split($v, 1) as $c)
                $r[] = (ord($c) > 127 ? 1255 : 999) - ord($c);
        }
        return implode('', $r);
    }

    public static function strToNumberDecode($s)
    {
        preg_match_all('/1?\d{3}/', $s, $t);
        $r = '';
        foreach ($t[0] as $v)
            $r .= chr(($v{0} == 1 ? 1255 : 999) - $v);
        return $r;
    }

}