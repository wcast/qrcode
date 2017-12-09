<?php
/**
 * Created by PhpStorm.
 * User: roger
 * Date: 12/9/17
 * Time: 4:01 PM
 */

namespace wcast\QRcoding;

$QR_BASEDIR = dirname(__FILE__).DIRECTORY_SEPARATOR;

// Required libs

include "libs/qrconst.php";
include "libs/qrconfig.php";
include "libs/qrtools.php";
include "libs/qrspec.php";
include "libs/qrimage.php";
include "libs/qrinput.php";
include "libs/qrbitstream.php";
include "libs/qrsplit.php";
include "libs/qrrscode.php";
include "libs/qrmask.php";
include "libs/qrencode.php";

//set it to writable location, a place for temp generated PNG files
define('PNG_TEMP_DIR', dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR);

//html PNG location prefix
define('PNG_WEB_DIR','./');


class QRcoding
{
    public function make($path ='qrcodes/',$level = 'H',$size = 5,$ID = 1,$data = 'http://wcast.com.br'){
        //ofcourse we need rights to create temp dir
        if (!file_exists($path))
            mkdir($path);
        $filename =  PNG_WEB_DIR.$path.$ID.'png';
        //remember to sanitize user input in real-life solution !!!
        $errorCorrectionLevel = 'L';
        if (isset($level) && in_array($level, array('L','M','Q','H')))
            $errorCorrectionLevel = $level;
        $matrixPointSize = 4;
        if (isset($size))
            $matrixPointSize = min(max((int)$size, 1), 10);
        if (isset($data)) {
            //it's very important!
            if (trim($data) == '')
                die('Por favor informe o conteúdo do QRCode! <a href="?">back</a>');
            // user data
            \QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
        }
        //display generated file
        echo '<img src="'.$filename.'" />';
    }
}