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
 relevant_places.rubrica_text  
 FROM postamats AS a 
 LEFT JOIN relevant_places ON a.relevant_places_id = relevant_places.id 
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
                    'balloonContent' => 'Постомат конкурента',
                    'clusterCaption' => 'Постомат конкурента',
                    'hintContent' => $b['name'],
                    'iconCaption' => $b['name']
                   ),
                  'options' => array('preset' => 'islands#blueCircleDotIconWithCaption')
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
                    'type' => 'com_postomat',
                    'balloonContent' => 'Инфраструктура',
                    'clusterCaption' => 'Постомат',
                    'hintContent' => $b['name'],
                    'iconCaption' => $b['name']
                   ),
                  'options' => array('preset' => 'islands#blackCircleDotIconWithCaption')
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

$tr = db_query("SELECT * FROM transport");

if ($tr != false) {
    foreach($tr as $b) {
        
        $index = null;
        $distance = distance($lat,$lng,$b['Latitude_WGS84'],$b['Longitude_WGS84']);
        
        if ($distance <= $radius) {
            
            $distance1 = round($distance * 1000);
            $sumPeople = $b['input_people'] + $b['output_people'];
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
            
        }
    }
}
// -------------------------------------------------------------------------

// достаём все дома
$houses = array();

$count = round(MOSCOW_HOUSES_AREA / MOSCOW_PEOPLES); // считаем сколько квадратов приходится на 1 человека
$peoples_all = 0;

$tr = db_query("SELECT * FROM mos_realty");

if ($tr != false) {
    foreach($tr as $b) {
        
        $index = null;
        $distance = distance($lat,$lng,$b['lat'],$b['lng']);
        
        if ($distance <= $radius) {
            
            $peoples = null;
            
            if (!empty($b['area_residential'])) {
                $peoples = round( $b['area_residential'] / $count );
                $peoples_all += $peoples;
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
    
    
}
// -------------------------------------------------------------------------

// считаем итоговый процент востребованности



// -------------------------------------------------------------------------

// для карты
$json = json_encode($arr, true);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/admin/modules/postomat/files/'.$dataJson,$json);