<?php

if (empty($_COOKIE['data'])) {
    $value = time().mt_rand(10000,1000000);
    setcookie('data', $value, time() + 3600 * 24 * 30, '/');
    
    $dataJson = 'data-'.$value.'.json';
    
}

else {
    $dataJson = 'data-'.clearData($_COOKIE['data'],'int').'.json';
}

$postamat_id = intval($xc['url']['id']);


$postomat = db_query("SELECT a.*,
 relevant_places.rubrica_text,
 infrastructure.adres AS address,
 infrastructure.city,
 mos_realty.address AS houseAddress 
 FROM postamats AS a 
 LEFT JOIN relevant_places ON a.relevant_places_id = relevant_places.id 
 LEFT JOIN infrastructure ON (a.lng = infrastructure.lng AND a.lat = infrastructure.lat) 
 LEFT JOIN mos_realty ON (a.lng = mos_realty.lng AND a.lat = mos_realty.lat) 
 WHERE a.id=".$postamat_id." 
 LIMIT 1");

$diametr = $postomat[0]['SQ_DIAMETR'];
$lat = $postomat[0]['lat'];
$lng = $postomat[0]['lng'];
$model = $postomat[0]['model_id'];
$percent = round($postomat[0]['relevance']);

$radius1 = $diametr / 2;
$radius = $radius1 / 1000; // переводим радиус в километры
  
$title = 'Постомат';

// достаём список всех объектов инфраструктуры
$infrastructure = array();
$postamats = array();
$weight = array();

$infIndex = 0;
$comIndex = 0;
$trIndex = 0;
$peopleIndex = 0;

$i=0;
$postomatsObj = 'Постомат';
$arr = array();
$arr['type'] = 'FeatureCollection';


$arr['features'][] = array(
  'type' => 'Feature',
  'id' => $i,
  'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $lat, 1 => $lng)),
  'properties' => array(
  'type' => 'postomat',
  'balloonContent' => 'Постомат',
  'clusterCaption' => 'Постомат',
  'hintContent' => 'Постомат',
  'iconCaption' => 'Постомат'
  ),
  'options' => array('preset' => 'islands#redCircleDotIconWithCaption')
);

$i++;


$inf = db_query("SELECT a.*,
 mln_category.category AS catName,
 mln_category.weight 
 FROM infrastructure AS a 
 LEFT JOIN mln_category ON a.category_id = mln_category.id");

if ($inf != false) {
    
    // таблица весов
    $wh = db_query("SELECT * FROM mln_factor_weight WHERE model_id=".$model);
    
    if ($wh != false) {
        foreach($wh as $b) {
            $weight[ $b['factor_id'] ] = array(
              'weight' => $b['weight'], 
              'max' => $b['max'],
              'min' => $b['min']
              );
        }
    }
    
    foreach($inf as $b) {
        
        $index = null;
        $distance = distance($lat,$lng,$b['lat'],$b['lng']);
        
        
        if ($distance <= $radius) {
            
            $distance1 = round($distance * 1000);
            $index = calcIndex($b['weight'],$distance1);
            
            if ($b['category_id'] == 6) {
                $postamats[] = array(
                  'address' => $b['adres'],
                  'name' => $b['name'],
                  'lng' => $b['lng'],
                  'lat' => $b['lat'],
                  'category' => $b['catName'],
                  'distance' => $distance1,
                  'weight' => $b['weight'],
                  'index' => $index
                );
                
                $comIndex += $index;
                
                 // для карты
                 $arr['features'][] = array(
                  'type' => 'Feature',
                  'id' => $i,
                  'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $b['lat'], 1 => $b['lng'])),
                  'properties' => array(
                    'type' => 'com_postomat',
                    'balloonContent' => 'Конкуренты',
                    'clusterCaption' => 'Постомат конкурента',
                    'iconCaption' => $b['name']
                   ),
                  'options' => array('preset' => 'islands#orangeCircleDotIconWithCaption')
                 );

                 $i++;
                // ----------------------------------------------------
                
            }
            
            else {
                $infrastructure[] = array(
                  'address' => $b['adres'],
                  'name' => $b['name'],
                  'lng' => $b['lng'],
                  'lat' => $b['lat'],
                  'category' => $b['catName'],
                  'distance' => $distance1,
                  'weight' => $b['weight'],
                  'index' =>  $index
                );
                
                $infIndex += $index;
                
                // для карты
                 $arr['features'][] = array(
                  'type' => 'Feature',
                  'id' => $i,
                  'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $b['lat'], 1 => $b['lng'])),
                  'properties' => array(
                    'type' => 'infrastructure',
                    'balloonContent' => 'Инфраструктура',
                    'hintContent' => $b['name']
                   ),
                  'options' => array('preset' => 'islands#greenCircleDotIconWithCaption')
                 );

                 $i++;
                // ----------------------------------------------------
            }
            
            
        }
    }
}
// -------------------------------------------------------------------------

// достаём все транспортные объекты
$transport = array();
$sumPeopleAll = 0;

$tr = db_query("SELECT * FROM transport");

if ($tr != false) {
    foreach($tr as $b) {
        
        $index = null;
        $distance = distance($lat,$lng,$b['Latitude_WGS84'],$b['Longitude_WGS84']);
        
        if ($distance <= $radius) {
            
            $distance1 = round($distance * 1000);
            $sumPeople = $b['input_people'] + $b['output_people'];
            
            $sumPeopleAll += $sumPeople;
            
            $index = calcIndex($sumPeople,$distance1);
            
            $transport[] = array(
              'category' => $b['type_transport'],
              'name' => $b['Name'],
              'lng' => $b['Longitude_WGS84'],
              'lat' => $b['Latitude_WGS84'],
              'distance' => $distance1,
              'input_people' => number_format($b['input_people'],0,'',' '),
              'output_people' => number_format($b['output_people'],0,'',' '),
              'index' => $index
            );
            
            $trIndex += $index;
            
            // транспорт
                 $arr['features'][] = array(
                  'type' => 'Feature',
                  'id' => $i,
                  'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $b['lat'], 1 => $b['lng'])),
                  'properties' => array(
                    'type' => 'transport',
                    'balloonContent' => 'Транспорт',
                    'hintContent' => $b['Name']
                   ),
                  'options' => array('preset' => 'islands#redCircleDotIconWithCaption')
                 );

                 $i++;
           // ----------------------------------------------------
            
        }
    }
    
    if (!empty($sumPeopleAll)) {
        $sumPeopleAll = round($sumPeopleAll / 90);
        $sumPeopleAll = number_format($sumPeopleAll,0,'',' ');
    }
}
// -------------------------------------------------------------------------

// достаём все дома
$houses = array();
$peoples_all = 0;
$quarters_count_all = 0;
$areaResidentialAll = 0;

$tr = db_query("SELECT * FROM mos_realty");

if ($tr != false) {
    foreach($tr as $b) {
        
        $index = null;
        $distance = distance($lat,$lng,$b['lat'],$b['lng']);
        
        if ($distance <= $radius) {
            
            $peoples = null;
            
            $peoples = round($b['w_FUNC_PEOPLE']);
            $peoples_all += $peoples;
            
            if (!empty($b['living_quarters_count'])) {
                $quarters_count_all += $b['living_quarters_count'];
            }
            
            if (!empty($b['area_residential'])) {
                $areaResidentialAll += $b['area_residential'];
            }
            
            $distance1 = round($distance * 1000);
            $index = calcIndex($peoples,$distance1);
            
            $houses[] = array(
              'id' => $b['id'],
              'address' => $b['address'],
              'lng' => $b['lng'],
              'lat' => $b['lat'],
              'distance' => round($distance * 1000),
              'living_quarters_count' => $b['living_quarters_count'],
              'area_residential' => $b['area_residential'],
              'peoples' => $peoples,
              'index' => $index
            );
            
            $peopleIndex += $index;
            
        }
    }
    
    if (!empty($peoples_all)) {
        $peoples_all = number_format($peoples_all,0,'',' ');
    }
    
    if (!empty($areaResidentialAll)) {
        $areaResidentialAll = number_format($areaResidentialAll,0,'',' ');
    }
    
    if (!empty($quarters_count_all)) {
        $quarters_count_all = number_format($quarters_count_all,0,'',' ');
    }
}
// -------------------------------------------------------------------------


// для карты
$json = json_encode($arr, true);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/admin/modules/postomat/files/'.$dataJson,$json);


// ссылки на документацию по моделям
$modelsDoc = array();

$modDoc = db_query("SELECT * FROM mln_model");

if ($modDoc != false) {
    foreach($modDoc as $b) {
        $modelsDoc[ $b['id'] ] = array('name' => $b['name'],'url' => $b['URL']);
    }
}

// цвета маршрутов

$colorsRoute = array(
  1 => '#DC143C',
  2 => '#FF1493',
  3 => '#FF4500',
  4 => '#FFD700',
  5 => '#32CD32',
  6 => '#006400',
  7 => '#008B8',
  8 => '#4682B4',
  9 => '#00008B',
  10 => '#00FFFF',
  11 => '#FF00FF',
  12 => '#800000',
  13 => '#8B4513',
  14 => '#F4A460',
  15 => '#4B0082',
  16 => '#DA70D6',
  17 => '#D2691E',
  18 => '#A0522D',
  19 => '#008000',
  20 => '#20B2AA',
  21 => '#1E90FF',
  22 => '#483D8B',
  23 => '#EE82EE',
  24 => '#B8860B',
  25 => '#32CD32',
  26 => '#DC143C',
  27 => '#FF1493',
  28 => '#FF4500',
  29 => '#FFD700',
  30 => '#32CD32',
  31 => '#006400',
  32 => '#008B8',
  33 => '#4682B4'
);

if (!empty($xc['url']['print'])) {
    $xc['noMainTmp'] = true;
}

$address = null;
               
if (!empty($postomat[0]['city'])) {
   $address = $postomat[0]['city'];
}
               
if (!empty($postomat[0]['address'])) {     
  if (!empty($address)) {
     $address .= ', '.$postomat[0]['address'];
  }
                  
  else {
     $address = $postomat[0]['address'];
  }
}
               
if (empty($address) && !empty($postomat[0]['houseAddress'])) {
   $address = $postomat[0]['houseAddress'];
}