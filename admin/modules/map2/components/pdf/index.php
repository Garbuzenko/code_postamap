<?php
     
    $ajaxFilter = true;
    
    if (!empty($xc['url']['adm_area'])) {
        $xc['where'] .= " AND adm_area_id IN (".str_replace('-',',',$xc['url']['adm_area']).")";
        $xc['filter'] .= " AND id_adm_area IN (".str_replace('-',',',$xc['url']['adm_area']).") ";
    }
    
    if (!empty($xc['url']['district'])) {
        $xc['where'] .= " AND district_id IN (".str_replace('-',',',$xc['url']['district']).")";
        $xc['filter'] .= " AND  id IN (".str_replace('-',',',$xc['url']['district']).")";
    }
    
    if (!empty($xc['url']['category'])) {
        $xc['where'] .= " AND category_id IN (".str_replace('-',',',$xc['url']['category']).") ";
    }
    
    if (!empty($xc['url']['relevance_start'])) {
        $xc['where'] .= " AND w_relevance >= ".intval($xc['url']['relevance_start'])." ";
    }
    
    if (!empty($xc['url']['relevance_finish'])) {
        $xc['where'] .= " AND w_relevance <= ".intval($xc['url']['relevance_finish'])." ";
    }
    
    $xc['where'] .= " AND SQ_DIAMETR=".intval($xc['url']['sq_diametr'])." ";
    $xc['where'] .= " AND model_id=".intval($xc['url']['model_id'])." ";
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/main/components/map2/index.php';