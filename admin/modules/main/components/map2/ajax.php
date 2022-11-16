<?php

if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsSearchInMap') {
    
    $ajaxFilter = true;
    $ajaxUrl = null;
    
    if (!empty($_POST['admArea'])) {
        $xc['where'] .= " AND adm_area_id IN (".implode(',',$_POST['admArea']).")";
        $xc['filter'] .= " AND id_adm_area IN (".implode(',',$_POST['admArea']).") ";
        
        $ajaxUrl .= '&adm_area='.implode('-',$_POST['admArea']);
    }
    
    if (!empty($_POST['district'])) {
        
        if (!empty($_POST['admArea'])) {
            $xc['where'] = " AND ( district_id IN (".implode(',',$_POST['district']).") OR adm_area_id IN (".implode(',',$_POST['admArea']).") )";
        }
        
        else {
            $xc['where'] .= " AND district_id IN (".implode(',',$_POST['district']).")";
        }
        
        
        $xc['filter'] .= " AND  id IN (".implode(',',$_POST['district']).")";
        $ajaxUrl .= '&district='.implode('-',$_POST['district']);
    }
    
    if (!empty($_POST['category'])) {
        $xc['where'] .= " AND category_id IN (".implode(',',$_POST['category']).") ";
        $ajaxUrl .= '&category='.implode('-',$_POST['category']);
    }
    
    if (!empty($_POST['relevance_start'])) {
        $xc['where'] .= " AND w_relevance >= ".intval($_POST['relevance_start'])." ";
        $ajaxUrl .= '&relevance_start='.intval($_POST['relevance_start']);
    }
    
    if (!empty($_POST['relevance_finish'])) {
        $xc['where'] .= " AND w_relevance <= ".intval($_POST['relevance_finish'])." ";
        $ajaxUrl .= '&relevance_finish='.intval($_POST['relevance_finish']);
    }
    
    $xc['where'] .= " AND SQ_DIAMETR=".intval($_POST['sq_diametr'])." ";
    $xc['where'] .= " AND model_id=".intval($_POST['model_id'])." ";
    
    $ajaxUrl .= '&sq_diametr='.intval($_POST['sq_diametr']);
    $ajaxUrl .= '&model_id='.intval($_POST['model_id']);
    
    $ajaxUrl = str_replace_once('&','?',$ajaxUrl);
    $excelData = json_encode($_POST,true);
    
    ob_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/main/components/map2/index.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/main/components/map2/tmp.inc.php';
    $html = ob_get_clean();
    
    exit($html);
    
}