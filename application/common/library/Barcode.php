<?php

namespace app\common\library;


use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;

class Barcode
{
    const STORE_PATH = 'barcode/cache';

    public static $barCode = null;

    public static $qrCode = null;

    //条码
    public static function getBarCodeInstance()
    {
        if(self::$barCode === null){
            self::$barCode = new DNS1D();
            self::$barCode->setStorPath(ROOT_PATH . self::STORE_PATH);
        }
        return self::$barCode;
    }

    //二维码
    public static function getQrCodeInstance()
    {
        if(self::$qrCode === null){
            self::$qrCode = new DNS2D();
            self::$qrCode->setStorPath(ROOT_PATH . self::STORE_PATH);
        }
        return self::$qrCode;
    }

    public static function getBarCode($code)
    {
        $bar = self::getBarCodeInstance();
        return $bar->getBarcodePNG($code, 'C128', 2, 60);
    }

    public static function getQrCode($code)
    {
        $bar = self::getQrCodeInstance();
        return $bar->getBarcodePNG($code, 'QRCODE', 6, 6);
    }
}