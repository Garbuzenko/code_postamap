<?php

if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsEditWeight') {
    

    $btn = $_POST['but'];
    $arr = array();
    
    foreach($_POST as $k=>$v) {
        
        if(preg_match('/weight/is',$k)) {
            $t = explode('-',$k);
            $id = $t[1];
            $arr[ $id ]['weight'] = $v;
        }
        
        if(preg_match('/priority/is',$k)) {
            $t = explode('-',$k);
            $id = $t[1];
            $arr[ $id ]['priority'] = $v;
        }
    }
    
    foreach($arr as $cat_id=>$val) {
        $upd = db_query("UPDATE mln_category 
        SET weight='".$val['weight']."',
        priority='".$val['priority']."' 
        WHERE id='".$cat_id."' 
        LIMIT 1","u");
    }
    
    
    
    if ($btn == 'generate') {
        // делаем пресчёn параметров с учётом нового веса и приоритета
        
        $sq_diametr = intval($_POST['sq_diametr']);
        $model_id = intval($_POST['model_id']);

        $updWeight = db_query("UPDATE infrastructure SET weight=(SELECT weight FROM  mln_category WHERE id=infrastructure.category_id)","u");

        // достаём объекты для расчёта
       $obj = db_query("SELECT * 
       FROM relevant_places 
       WHERE SQ_DIAMETR='".$sq_diametr."' 
       AND MODEL_ID='".$model_id."'");

       if ($obj != false) {
          foreach($obj as $b) {
        
           // радиус по которому будем считать
           $radius = $b['SQ_DIAMETR'] / 2;

           $lat_r = (0.000899352 * $radius)/80;
	       $lng_r = (0.001608967 * $radius)/80;

           $lat_min = $b['lat'] - $lat_r;
	       $lat_max = $b['lat'] + $lat_r;

	       $lng_min = $b['lng'] - $lng_r;
	       $lng_max = $b['lng'] + $lng_r;
 
	       $infrastructure = db_query("SELECT id, 
           lat, 
           lng, 
           weight,
           category_id 
           FROM infrastructure 
           WHERE (lat BETWEEN '".$lat_min."' AND '".$lat_max."') 
           AND (lng BETWEEN '".$lng_min."' AND '".$lng_max."')");
           // ----------------------------------------------------------------------------------
        
          // вычисляем общий индекс инфраструктуры входящей в заданный радиус
          $infrastructureIndex = 0;
          $postamatsIndex = 0;
        
          if ($infrastructure != false) {
        
           // перебираем объекты инфраструктуры
           foreach($infrastructure as $k=>$v) {
            
            // считаем расстояние от текущей точки (в км)
            $distance = distance($b['lat'],$b['lng'],$v['lat'],$v['lng']);
            
            // переводим расстояние в метры
            $distance1 = round($distance * 1000);
            
            // если постамат входит в заданный радиус
            if ($distance1 <= $radius) {
                
                // считаем индекс этого объекта инфраструктуры
                $index = calcIndex($v['weight'],$distance1);
                
                // суммируем инекс постамата с другими постаматами входящими в заданный радиус
                if ($v['category_id'] == 6) {
                    $postamatsIndex += $index;
                }
                
                else {
                    $infrastructureIndex += $index;
                }
              }
            }
        }
        // ----------------------------------------------------------------------------------
        
        
        // вычисляем общий индекс по населению, проживающему в заданном радиусе
        $peoplesIndex = 0;
        $people_count = 0;
        
        $houses = db_query("SELECT w_FUNC_PEOPLE, lat, lng 
        FROM mos_realty 
        WHERE (lat BETWEEN '".$lat_min."' AND '".$lat_max."') 
        AND (lng BETWEEN '".$lng_min."' AND '".$lng_max."')");
        
        if ($houses != false) {
        
        // перебираем объекты транспорта
        foreach($houses as $k=>$v) {
            
            // считаем расстояние от текущей точки (в км)
            $distance = distance($b['lat'],$b['lng'],$v['lat'],$v['lng']);
            
            // переводим расстояние в метры
            $distance1 = round($distance * 1000);
            
            // если постамат входит в заданный радиус
            if ($distance1 <= $radius) {
                
                if (!empty($v['w_FUNC_PEOPLE'])) {
                   $people_count += $v['w_FUNC_PEOPLE'];
                }
                
                // считаем индекс этого объекта
                $index = calcIndex($v['w_FUNC_PEOPLE'],$distance1);
                
                // суммируем инекс постамата с другими постаматами входящими в заданный радиус
                $peoplesIndex += $index;
            }
        }
        
          if (!empty($people_count)) {
            $people_count = round($people_count);
          }
        
        }
        // ----------------------------------------------------------------------------------
        
        // вычисляем общий индекс точек метро входящих в заданный радиус
        $transport = db_query("SELECT transport_id, 
        Longitude_WGS84, 
        Latitude_WGS84, 
        input_people, 
        output_people 
        FROM transport  
        WHERE (Latitude_WGS84 BETWEEN '".$lat_min."' AND '".$lat_max."') 
        AND (Longitude_WGS84 BETWEEN '".$lng_min."' AND '".$lng_max."')");
        
        $transportIndex = 0;
        
        if ($transport != false) {
        
        // перебираем объекты транспорта
        foreach($transport as $k=>$v) {
            
            $weight = 0;
            $weight = $v['input_people'] + $v['output_people'];
            
            // считаем расстояние от текущей точки (в км)
            $distance = distance($b['lat'],$b['lng'],$v['Latitude_WGS84'],$v['Longitude_WGS84']);
            
            // переводим расстояние в метры
            $distance1 = round($distance * 1000);
            
            // если постамат входит в заданный радиус
            if ($distance1 <= $radius) {
                
                // считаем индекс этого объекта
                $index = calcIndex($weight,$distance1);
                
                // суммируем инекс постамата с другими постаматами входящими в заданный радиус
                $transportIndex += $index;
            }
         }
        
        }
        // ----------------------------------------------------------------------------------

        // добавляем полученные индексы в базу
        $upd = db_query("UPDATE relevant_places 
        SET infrastructure='".$infrastructureIndex."',
        people='".$peoplesIndex."',
        transport='".$transportIndex."',
        comercial_postsmat='".$postamatsIndex."',
        people_count='".$people_count."' 
        WHERE id='".$b['id']."' 
        LIMIT 1
        ","u");
        
    }
    
    $html = '<div class="popupMessageDiv">Индексы пересчитаны</div>';
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
    
    exit('ok');
}