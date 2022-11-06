<?php

if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsSearchInMap') {
    
    if (!empty($_POST['admArea'])) {
        $xc['where'] .= " AND adm_area_id IN (".implode(',',$_POST['admArea']).")";
    }
    
    if (!empty($_POST['district'])) {
        $xc['where'] .= " AND district_id IN (".implode(',',$_POST['district']).")";
    }
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/main/components/map/index.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/main/components/map/tmp.inc.php';
    $html = ob_get_clean();
    
    exit($html);
    
}