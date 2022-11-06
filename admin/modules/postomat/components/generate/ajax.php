<?php

if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsEditWeight') {
    
    $model_id = intval($_POST['model_id']);
    $sq_diametr = intval($_POST['sq_diametr']);
    $factor_id = intval($_POST['factor_id']);
    $weight = intval($_POST['weight']);
    
    $popup = 'popup';
    $width = 400;
    $height = 250;
    
    if (MOBILE == true) {
        $popup = 'popupMob';
        $width = '100%';
        $height = '100%';
    }
    
    $upd = db_query("UPDATE mln_factor_weight 
    SET weight='".$weight."' 
    WHERE model_id='".$model_id."' 
    AND SQ_DIAMETR='".$sq_diametr."' 
    AND factor_id='".$factor_id."' 
    LIMIT 1","u");
    
    if ($upd == false) {
        $mesage = '<div class="popupMessageDiv">Не получается обновить вес. Ошибка: '.$upd.'</div>';
        $arr = array(
         0 => $popup,
         1 => $html,
         2 => $width,
         3 => $height,
         4 => 1010
        );
    
        $h = callbackFunction($arr);
        exit($h);
    }
    
    // делаем пресчёn параметров с учётом нового веса
    $jenerateAjax = true;
    require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/calc/index.php';
    
    exit('ok');
}