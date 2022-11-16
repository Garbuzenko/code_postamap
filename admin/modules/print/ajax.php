<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/lib/convertapi-php/lib/ConvertApi/autoload.php';
use \ConvertApi\ConvertApi;


if (isset($_POST['form_id']) && ($_POST['form_id'] == 'form_jsShowBtn' || $_POST['form_id'] == 'form_jsCreatePdf') ) {
    
    $url = $_POST['url'];
    $file_id = time();
    
    # set your api secret
    ConvertApi::setApiSecret('');

    # Example of converting Web Page URL to PDF file
    # https://www.convertapi.com/web-to-pdf

    $fromFormat = 'web';
    $conversionTimeout = 180;
    $dir = $_SERVER['DOCUMENT_ROOT'].'/admin/files/pdf/';//sys_get_temp_dir();

    $result = ConvertApi::convert(
    'pdf',
    [
        'Url' => $url,
        'FileName' => 'otchet-'.$file_id,
        'ConversionDelay' => 10
    ],
    $fromFormat,
    $conversionTimeout
    );

    $savedFiles = $result->saveFiles($dir);
    
    //$root = dirname(__FILE__);
    //$request = $_SERVER['REQUEST_URI'];
    $filename = 'otchet-'.$file_id.'.pdf';
    $path = $_SERVER['DOCUMENT_ROOT'].'/admin/files/pdf/'.$filename;
  
    if (file_exists($path)) {
        
    $fileurl = DOMAIN.'/admin/files/pdf/'.$filename;
    $html = '<div class="popupMessageDiv"><a href="'.$fileurl.'" target="_blank">Скачать PDF</a></div>';
    
     $popup = 'popup';
     $width = 400;
     $height = 250;
    
    if (MOBILE == true) {
        $popup = 'popupMob';
        $width = '100%';
        $height = '100%';
    }
    
    $arr = array(
      0 => $popup,
      1 => $html,
      2 => $width,
      3 => $height,
      4 => 100000
    );
    
    $h = callbackFunction($arr);
    exit($h);
    
    
    /*
    if (ob_get_level()) {
        ob_end_clean();
    }
    header("Content-Type: application/pdf; charset=UTF-8");
    header("Content-Length: ".filesize($path));
    header("Content-Disposition: attachment; filename=\"{$filename}\"");
    header("Content-Transfer-Encoding: binary");
    header("Cache-Control: must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile($path);
    */
}
    
}