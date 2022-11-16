<?

if (empty($_COOKIE['data'])) {
    $value = time() . mt_rand(10000, 1000000);
    setcookie('data', $value, time() + 3600 * 24 * 30, '/');

    $dataJson = 'data-' . $value . '.json';
} else {
    $dataJson = 'data-' . clearData($_COOKIE['data'], 'int') . '.json';
}

if ($ajaxFilter == true) {

    if (!empty($xc['where'])) {
        $xc['where'] = str_replace_once('AND', 'WHERE', $xc['where']);
    }
    
    if (!empty($xc['filter'])) {
        $xc['filter'] = str_replace_once('AND', 'WHERE', $xc['filter']);
    }

    //$imgPath = '/admin/img/icons/';

    // достаём постаматы
    
    $sq_polygons = array();
    $arr = array();
    $arr['type'] = 'FeatureCollection';

    $postamats = db_query("SELECT * 
    FROM postamats" . $xc['where'] . " 
    ORDER BY w_relevance DESC 
    LIMIT 10000");

    if ($postamats != false) {
        foreach ($postamats as $b) {
            
            // полигоны квадратов
            $sq_polygons[ $b['SQ_ID'] ] = array('polygon' => $b['polygons'], 'descr' => 'Квадрат с радиусом '.($b['SQ_DIAMETR']/2).' м.' );
            
            $b['w_comercial_postsmat'] = round($b['w_comercial_postsmat'],2);
            $b['w_infrastructure'] = round($b['w_infrastructure'],2);
            $b['w_people'] = round($b['w_people'],2);
            $b['w_transport'] = round($b['w_transport'],2);
            
            $arr['features'][] = array(
                'type' => 'Feature',
                'id' => $b['id'],
                'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $b['lat'], 1 => $b['lng'])),
                'properties' => array(
                    'type' => 'postomat',
                    'balloonContent' => '<div class="balloonContentDiv"><p>Страница постамата: <a href="'.DOMAIN.'/admin/postomat?id='.$b['id'].'" target="_blank">смотреть</a></p><p>Релевантность: <strong>'.round($b['w_relevance']).'%</strong></p><p>Модель расчёта: <strong>'.$b['model'].'</strong></p><p>Радиус квадрата: <strong>'.($b['SQ_DIAMETR']/2).'</strong> м.</p><p>Административный округ: <strong>'.$b['adm_area'].'</strong></p><p>Район: <strong>'.$b['district'].'</strong></p><p><strong>Индексы релевантности:</strong></p><ul><li>Конкуренция: <strong>'.$b['w_comercial_postsmat'].'</strong></li><li>Инфраструктура: <strong>'.$b['w_infrastructure'].'</strong></li><li>Население: <strong>'.$b['w_people'].'</strong></li><li>Транспорт: <strong>'.$b['w_transport'].'</strong></li></ul></div>',
                    'clusterCaption' => 'Постоматы',
                    'hintContent' => 'Релевнтность: '.round($b['w_relevance']).'%'),
                'options' => array('preset' => 'islands#blueCircleDotIconWithCaption'));

        }

        $json = json_encode($arr, true);
        file_put_contents($_SERVER['DOCUMENT_ROOT'] .'/admin/modules/main/components/map2/files/' . $dataJson, $json);
        $filter = true;
    }
    
    else {
        $html = '<div class="popupMessageDiv">По заданным параметрам не нашлось подходящих постаматов</div>';
        
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
    }

}


// получаем районы из БД
$districtVisible = array();

$district = db_query("SELECT * FROM mln_districts".$xc['filter']);

if ($district != false) {
    foreach ($district as $dst) {
       $districtVisible[$dst['id']] = $dst;
    }
}

// получаем данные по домам Москвы и плотности населения
//$mos_realty = db_query("SELECT id, lng, lat, area_residential, address FROM mos_realty" .$xc['where']);
?>