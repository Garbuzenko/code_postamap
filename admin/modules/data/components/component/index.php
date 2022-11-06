<?php

$pagename = clearData($_GET['com'],'get');

if (empty($pagename))
  exit(header('Location: /admin/'));

  
$map = db_query("SELECT * FROM mos_data WHERE pagename='".$pagename."' LIMIT 1");

if ($map == false)
  exit(header('Location: /admin/'));

$navigation = false;
$num = 30;
$title = $map[0]['title'];

if ($map[0]['data_table'] == 'mos_realty') {
    
    $data = db_query("SELECT SQL_CALC_FOUND_ROWS 
    a.address,
    a.built_year,
    a.living_quarters_count,
    a.area_residential,
    a.lng,
    a.lat,
    mln_districts.district 
    FROM mos_realty AS a 
    LEFT JOIN mln_districts ON a.district_id = mln_districts.id 
    WHERE a.region_id='0c5b2444-70a0-4932-980c-b4dc0d3f02b5' 
    AND a.district_id!=0
    ORDER BY a.district_id 
    LIMIT 0, ".$num." 
    ");
    
    $address = null;
    $district = null;
    $house_id = null;
    $district_id = null;
    
}

if ($map[0]['data_table'] == 'infrastructure') {
    $data = db_query("SELECT SQL_CALC_FOUND_ROWS 
    a.*,
    mln_category.category AS catName,
    mln_districts.district 
    FROM infrastructure AS a 
    LEFT JOIN mln_category ON a.category_id = mln_category.id 
    LEFT JOIN mln_districts ON a.district_id = mln_districts.id 
    ORDER BY a.id  
    LIMIT 0, ".$num);
    
}

if ($map[0]['data_table'] == 'transport') {
    
    
    $data = db_query("SELECT SQL_CALC_FOUND_ROWS 
    a.*,
    mln_districts.district AS distName 
    FROM transport AS a 
    LEFT JOIN mln_districts ON a.district_id = mln_districts.id 
    ORDER BY a.id 
    LIMIT 0, ".$num);
    
}

if ($map[0]['data_table'] == 'mln_type_sport') {
    
    $data = db_query("SELECT SQL_CALC_FOUND_ROWS 
    id,
    type,
    popular,
    smile_html,
    category,
    season 
    FROM mln_type_sport
    ORDER BY type ASC 
    LIMIT 0, ".$num." 
    ");
    
}

if ($map[0]['data_table'] == 'mln_districts') {
    
    $data = db_query("SELECT SQL_CALC_FOUND_ROWS 
    id,
    district,
    adm_area 
    FROM mln_districts 
    ORDER BY id  
    LIMIT 0, ".$num." 
    ");
    
}

if ($map[0]['data_table'] == 'data_analiz_district') {
    
    $data = db_query("SELECT SQL_CALC_FOUND_ROWS 
    a.koeff_y,
    a.koeff_count_zone,
    mln_type_sport.type,
    mln_type_sport.smile_html,
    mln_districts.district 
    FROM data_analiz_district AS a 
    LEFT JOIN mln_type_sport ON a.sport_id = mln_type_sport.id 
    LEFT JOIN mln_districts ON a.district_id = mln_districts.id 
    ORDER BY a.koeff_y DESC   
    LIMIT 0, ".$num);
    
}

// ------------------------------- постраничная навигация -------------------------------


    $rows = db_query("SELECT FOUND_ROWS() AS cnt");
    $col = $rows[0]['cnt'];

    $nav = null;
    
    if ($col > $num) {
        $nav = pagination($num, $col, 1, $map[0]['data_table']);
    }
// --------------------------------------------------------------------------------------

if ($map[0]['data_table'] == 'mos_objects') {
    
    $sportZone = array();
    $sportType = array();
    
    if ($data!=false) {
        foreach($data as $b) {
            $sportZone[] = $b['object_id'];
        }
        
        $spz = db_query("SELECT a.object_id,
        a.sport_id,
        mln_type_sport.type  
        FROM mos_objects_sportzone AS a 
        LEFT JOIN mln_type_sport ON a.sport_id = mln_type_sport.id 
        WHERE a.object_id IN (".implode(',',$sportZone).")");
        
        if ($spz != false) {
            foreach($spz as $b) {
                if (!empty($b['type'])) {
                    $sportType[$b['object_id']][$b['sport_id']] = $b['type'];
                }
            }
        }
    }
}

if ($map[0]['data_table'] == 'mos_objects_sportzone') {
    
    $sportZone = array();
    $sportType = array();
    
    if ($data!=false) {
        foreach($data as $b) {
            $sportZone[] = $b['sportzone_id'];
        }
        
        $spz = db_query("SELECT a.sportzone_id,
        a.sport_id,
        mln_type_sport.type  
        FROM mos_objects_sportzone AS a 
        LEFT JOIN mln_type_sport ON a.sport_id = mln_type_sport.id 
        WHERE a.sportzone_id IN (".implode(',',$sportZone).")");
        
        if ($spz != false) {
            foreach($spz as $b) {
                if (!empty($b['type'])) {
                    $sportType[$b['sportzone_id']][$b['sport_id']] = $b['type'];
                }
            }
        }
    }
    
}