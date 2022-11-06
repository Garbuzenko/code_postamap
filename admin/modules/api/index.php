<?php

$where = null;

// административные округа
if (!empty($xc['url']['adm_area'])) {
    
    // метод для получения списка административных округов
    if ($xc['url']['adm_area'] == 'list') {
        $q = db_query("SELECT * FROM mln_adm_area");
        
        if ($q != false) {
            $arr = json_encode($q,true);
            exit($arr);
        }
        
        exit();
    }
    // ----------------------------------------------------------------------
    
    $adm_area = clearData($xc['url']['adm_area'],'date');
    
    $where .= " AND adm_area_id IN (".str_replace('-',',',$adm_area).") ";
}
// ---------------------------------------------------------------------

// районы
if (!empty($xc['url']['district'])) {
    
    // метод для получения списка районов
    if ($xc['url']['district'] == 'list') {
        $q = db_query("SELECT id, district FROM mln_districts");
        
        if ($q != false) {
            $arr = json_encode($q,true);
            exit($arr);
        }
        
        exit();
    }
    // ----------------------------------------------------------------
    
    $district = clearData($xc['url']['district'],'date');
    
    $where .= " AND district_id IN (".str_replace('-',',',$district).") ";
}
// ---------------------------------------------------------------------

// длина сторон квадрата
if (!empty($xc['url']['diametr'])) {
    
    // метод для получения списка доступных диаметров
    if ($xc['url']['diametr'] == 'list') {
        $q = db_query("SELECT SQ_DIAMETR FROM postamats GROUP BY SQ_DIAMETR");
        
        if ($q != false) {
            $arr = json_encode($q,true);
            exit($arr);
        }
        
        exit();
    }
    // ----------------------------------------------------------------
    
    $diametr = intval($xc['url']['diametr']);
    
    $where .= " AND SQ_DIAMETR='".$diametr."' ";
}
// ---------------------------------------------------------------------

// релевантность (задаётся от 1 до 100 процентов)
if (!empty($xc['url']['relevance_start'])) {
    $where .= " AND relevance >= '".intval($xc['url']['relevance_start'])."' ";
}

if (!empty($xc['url']['relevance_finish'])) {
    $where .= " AND relevance <= '".intval($xc['url']['relevance_finish'])."' ";
}
// ---------------------------------------------------------------------

// тип объекта для размещения постамата
if (!empty($xc['url']['category'])) {
    
    // метод для получения списка категорий
    if ($xc['url']['category'] == 'list') {
        $q = db_query("SELECT category FROM postamats WHERE category!='' GROUP BY category");
        
        if ($q != false) {
            $arr = json_encode($q,true);
            exit($arr);
        }
        
        exit();
    }
    // ----------------------------------------------------------------------
    
    $category = urldecode($xc['url']['category']);
    $category = clearData($category);
    
    $where .= " AND category='".$category."' ";
}
// ---------------------------------------------------------------------

if (!empty($where)) {
    $where = str_replace_once('AND','WHERE',$where);
    
    $q = db_query("SELECT * FROM postamats ".$where);
    
    if ($q != false) {
        $arr = json_encode($q,true);
        exit($arr);
    }
}

exit();