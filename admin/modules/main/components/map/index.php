<?


if (empty($_COOKIE['data'])) {
    $value = time().mt_rand(10000,1000000);
    setcookie('data', $value, time() + 3600 * 24 * 30, '/');
    
    $dataJson = 'data-'.$value.'.json';
    $postamatsJson = 'postamats-'.$value.'.json';
    
}

else {
    $dataJson = 'data-'.clearData($_COOKIE['data'],'int').'.json';
    $postamatsJson = 'postamats-'.clearData($_COOKIE['data'],'int').'.json';
}

if (!empty($xc['where'])) {
    $xc['where'] =  str_replace_once('AND', 'WHERE', $xc['where']);
}

else {
    $xc['where'] = "  WHERE district_id=".$xc['default_district_id'];
}


$imgPath = '/admin/img/icons/';

// достаём постаматы
$postomatsObj = false;
$i = 0;
$arr = array();
$arr['type'] = 'FeatureCollection';

$postamats = db_query("SELECT * FROM postamats".$xc['where']);

if ($postamats != false) {
    foreach ($postamats as $b) {

        $arr['features'][] = array(
            'type' => 'Feature',
            'id' => $i,
            'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $b['lat'], 1 => $b['lng'])),
            'properties' => array(
                 'type' => 'postomat',
                 'balloonContent' => 'Постомат',
                 'clusterCaption' => 'Постомат',
                 'hintContent' => 'Постомат',
                 'iconCaption' => 'Постомат'
            ),
            'options' => array('preset' => 'islands#blueCircleDotIconWithCaption')
        );

        $i++;
    }

    $postomatsObj = true;
}



// получаем данные по инфраструктуре  из БД по умолчанию (без фильтров)
$category = array();

$infrastructure = db_query("SELECT * FROM infrastructure".$xc['where']);
//$infrastructure = false;
if ($infrastructure != false) {
    
    // достаём картинки категорий
    $cat = db_query("SELECT id, img FROM mln_category");
    
    if ($cat != false) {
        foreach($cat as $c) {
            $category[ $c['id'] ] = $c['img'];
        }
    }
    
    foreach ($infrastructure as $b) {
        
        $imgUrl = $imgPath.'26.png';
        
        if (!empty($category[ $b['category_id'] ])) {
            $imgUrl = $imgPath.$category[ $b['category_id'] ];
        }
        
        
        
        
        $arr['features'][] = array(
            'type' => 'Feature',
            'id' => $i,
            'geometry' => array('type' => 'Point', 'coordinates' => array(0 => $b['lat'], 1 => $b['lng'])),
            'properties' => array(
                'type' => 'infrastructure',
                'balloonContent' => 'Инфраструктура',
                'balloonContentBody' => $b['description'],
                'balloonContentFooter' => '<font size=1>Информация предоставлена: </font> <strong>этим балуном</strong>',
                'clusterCaption' => '<strong><s>Еще</s> одна</strong> метка',
                'hintContent' => '<strong>Текст  <s>подсказки</s></strong>',
                'img' => $imgUrl
                
        
            ),
            'options' => array(
                'iconLayout' => 'default#imageWithContent',
                'iconImageHref' => $imgUrl,
                'iconImageSize' => array(0=> 30, 1 => 30),
                'iconImageOffset' => array(0=> -30, 1 => -30),
                'iconContentLayout' => 'MyIconContentLayout',
                'iconContent' => '<strong>тест</strong>',
                'preset' => 'islands#blackCircleDotIconWithCaption'
            )   
        );


        $i++;
    }

}
// --------------------------------------------------------------------


$json = json_encode($arr, true);
file_put_contents($_SERVER['DOCUMENT_ROOT'] . '/admin/modules/main/components/map/files/'.$dataJson,$json);


// получаем районы из БД
$district = db_query("SELECT * FROM mln_districts");
$districtVisible = array();

foreach ($district as $dst) {
    if ((!empty($_POST['district']) and in_array($dst['id'], $_POST['district'])) or
        (!empty($_POST['admArea']) and in_array($dst['id_adm_area'], $_POST['admArea'])) or
        empty($_POST['district'])
       ) {
        $districtVisible[$dst['id']] = $dst;
    }
}

// получаем данные по домам Москвы и плотности населения
$mos_realty = db_query("SELECT id, lng, lat, area_residential, address FROM mos_realty" .$xc['where']);

?>