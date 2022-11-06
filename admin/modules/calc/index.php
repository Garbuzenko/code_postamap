<?php

if ( (!empty($xc['url']['val']) && $xc['url']['val'] == 'relevance' ) || $jenerateAjax == true ) {
    
    $weight = array();
    
    if ($jenerateAjax == true) {
        $model = $model_id;
        $diametr = $sq_diametr;
    }
    
    else {
       $model = intval($xc['url']['model']);
       $diametr = intval($xc['url']['diametr']);
    }
    
    
    $a = db_query("update mln_factor_weight set max=(select max(relevance) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR ) 
where factor_id = 0","u");
    
   $a = db_query("update mln_factor_weight set max=(select max(people) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR ) 
where factor_id = 1","u");
    
   $a = db_query("update mln_factor_weight set max=(select max(infrastructure) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
where factor_id = 2","u");
    
   $a = db_query("update mln_factor_weight set max=(select max(transport) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
where factor_id = 3","u");
    
   $a = db_query("update mln_factor_weight set max=(select max(comercial_postsmat) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
where factor_id = 4","u");
    
   $a = db_query("update mln_factor_weight set min=(select min(relevance) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
where factor_id = 0","u");
    
   $a = db_query("update mln_factor_weight set min=(select min(people) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
where factor_id = 1","u");
   
   $a = db_query("update mln_factor_weight set min=(select min(infrastructure) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
where factor_id = 2","u");
    
   $a = db_query("update mln_factor_weight set min=(select min(transport) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
where factor_id = 3","u");
    
   $a = db_query("update mln_factor_weight set min=(select min(comercial_postsmat) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
where factor_id = 4","u");   
    
    // таблица весов
    $wh = db_query("SELECT * FROM mln_factor_weight 
    WHERE model_id=".$model." 
    AND SQ_DIAMETR='".$diametr."'");
    
    if ($wh != false) {
        
        foreach($wh as $b) {
            
            $weight[ $b['factor_id'] ] = array(
              'weight' => $b['weight'], 
              'max' => $b['max'],
              'min' => $b['min']
              );
        }
    }
    
    else {
        exit('Не указан диаметр');
    }
    
    $obj = db_query("SELECT * FROM relevant_places WHERE SQ_DIAMETR='".$diametr."'");
    
    if ($obj != false) {
        foreach($obj as $b) {
            
            $relevance = 0;
            
            $infrastructureIndexResult = ($b['infrastructure'] - $weight[2]['min']) / ($weight[2]['max'] - $weight[2]['min']);
            $infrastructureIndexResult = $infrastructureIndexResult * $weight[2]['weight'];
            
            //$infrastructureIndexResult = $b['infrastructure'] * $weight[2]['weight'];
            //$infrastructureIndexResult = $infrastructureIndexResult / ($weight[2]['max'] - $weight[2]['min']);
            
            $comPostamatsIndexResult = ($b['comercial_postsmat'] - $weight[4]['min']) / ($weight[4]['max'] - $weight[4]['min']);
            $comPostamatsIndexResult = $comPostamatsIndexResult * $weight[4]['weight'];
            
            //$comPostamatsIndexResult = $b['comercial_postsmat'] * $weight[4]['weight'];
            //$comPostamatsIndexResult = $comPostamatsIndexResult / ($weight[4]['max'] - $weight[4]['min']);
            
            $transportIndexResult = ($b['transport'] - $weight[3]['min']) / ($weight[3]['max'] - $weight[3]['min']);
            $transportIndexResult = $transportIndexResult * $weight[3]['weight'];
            
            //$transportIndexResult = $b['transport'] * $weight[3]['weight'];
            //$transportIndexResult = $transportIndexResult / ($weight[3]['max'] - $weight[3]['min']);
            
            $peopleIndexResult = ($b['people'] - $weight[1]['min']) / ($weight[1]['max'] - $weight[1]['min']);
            $peopleIndexResult = $peopleIndexResult * $weight[1]['weight'];
            
            //$peopleIndexResult = $b['people'] * $weight[1]['weight'];
            //$peopleIndexResult = $peopleIndexResult / ($weight[1]['max'] - $weight[1]['min']);
            
            
            //$resultIndex = $infrastructureIndexResult + $comPostamatsIndexResult + $transportIndexResult + $peopleIndexResult;
            //$relevance = $b['priority'] * $resultIndex;
            //$relevance = $relevance - $weight[0]['min'];
            //$relevance = $relevance / ($weight[0]['max'] - $weight[0]['min']);
            
            $resultIndex = $infrastructureIndexResult + $comPostamatsIndexResult + $transportIndexResult + $peopleIndexResult;
            $relevance = $b['priority'] * $resultIndex;
            //$w_relevance = ($relevance - $weight[0]['min']) / ($weight[0]['max'] - $weight[0]['min']);
            
            $upd = db_query("UPDATE relevant_places 
            SET relevance='".$relevance."',
            w_infrastructure='".$infrastructureIndexResult."',
            w_people='".$peopleIndexResult."',
            w_transport='".$transportIndexResult."',
            w_comercial_postsmat='".$comPostamatsIndexResult." 
            WHERE id='".$b['id']."' 
            LIMIT 1","u");
        }
        
        // обновляем max для relevance
        $updMaxRelevance = db_query("UPDATE mln_factor_weight 
        SET max=(SELECT max(relevance) FROM relevant_places WHERE model_id = mln_factor_weight.model_id AND SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
        WHERE factor_id = 0");
        
        // обновляем min для relevance
        $updMinRelevance = db_query("UPDATE mln_factor_weight 
        SET min=(SELECT min(relevance) FROM relevant_places WHERE model_id = mln_factor_weight.model_id AND SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
        WHERE factor_id = 0");
        
        
        // достаём из базы новые веса
        $weight = array();
        
        $wh = db_query("SELECT * FROM mln_factor_weight 
        WHERE model_id=".$model." 
        AND SQ_DIAMETR='".$diametr."'");
    
        if ($wh != false) {
          foreach($wh as $b) {
            $weight[ $b['factor_id'] ] = array(
              'weight' => $b['weight'], 
              'max' => $b['max'],
              'min' => $b['min']
              );
           }
         }
         
         // снова достаём из базы объекты
         $obj = db_query("SELECT id, relevance FROM relevant_places WHERE SQ_DIAMETR='".$diametr."'");
    
         if ($obj != false) {
           // и перебираем их в цикле
           foreach($obj as $b) {
              
              // считаем w_relevance
              $w_relevance = ($b['relevance'] - $weight[0]['min']) / ($weight[0]['max'] - $weight[0]['min']);
              $w_relevance = $w_relevance * $weight[0]['weight'];
              
              // обеовляем значение w_relevance в relevant_places
              $upd = db_query("UPDATE relevant_places 
              SET w_relevance='".$w_relevance."' 
              WHERE id='".$b['id']."' 
              LIMIT 1","u");
              
           }
         }
        
        // обновляем таб. postamats
        $a = db_query("UPDATE postamats SET relevant_places_id = (SELECT id FROM relevant_places 
where MODEL_ID =  postamats.MODEL_ID 
and SQ_DIAMETR = postamats.SQ_DIAMETR 
and SQ_ID = postamats.SQ_ID ORDER BY relevance DESC LIMIT 1 )","u");
        
        
        $a = db_query("UPDATE postamats 
INNER JOIN relevant_places ON relevant_places.id = postamats.relevant_places_id 
set postamats.district_id=relevant_places.district_id,
postamats.adm_area_id=relevant_places.adm_area_id,
postamats.district=relevant_places.district,
postamats.adm_area=relevant_places.adm_area,
postamats.lng=relevant_places.lng,
postamats.lat=relevant_places.lat,
postamats.relevance=relevant_places.relevance,
postamats.infrastructure=relevant_places.infrastructure,
postamats.people=relevant_places.people,
postamats.transport=relevant_places.transport,
postamats.comercial_postsmat=relevant_places.comercial_postsmat,
postamats.category=relevant_places.category,
postamats.model=relevant_places.model,
postamats.w_infrastructure=relevant_places.w_infrastructure,
postamats.w_people=relevant_places.w_people,
postamats.w_transport=relevant_places.w_transport,
postamats.w_comercial_postsmat=relevant_places.w_comercial_postsmat,
postamats.priority=relevant_places.priority,
postamats.w_relevance=relevant_places.w_relevance,
postamats.model_id=relevant_places.model_id","u");

        

        $a = db_query("set @val = 0;update  postamats set rating = (@val:=@val+1) where model_id = 0 and sq_diametr = 100 order by relevance DESC;","u");

        $a = db_query("set @val = 0;update  postamats set rating = (@val:=@val+1) where model_id = 0 and sq_diametr = 200 order by relevance DESC;","u");
        
        $a = db_query("set @val = 0;update  postamats set rating = (@val:=@val+1) where model_id = 0 and sq_diametr = 400 order by relevance DESC;","u");
    }
    
    if ($jenerateAjax != true) {
      exit('ok');
    }
}



if (!empty($xc['url']['val']) && $xc['url']['val'] == 'index') {


$infrastructure = array();
$com_postamats = array();
$houses = array();
$transport = array();


// объекты инфраструктуры
$inf = db_query("SELECT a.*,
 mln_category.weight 
 FROM infrastructure AS a 
 LEFT JOIN mln_category ON a.category_id = mln_category.id");
 
 if ($inf != false) {
    
    foreach($inf as $b) {
        
        if ($b['category_id'] == 6) {
          $com_postamats[] = array(
            'id' => $b['id'],
            'lat' => $b['lat'],
            'lng' => $b['lng'],
            'weight' => $b['weight']
          );
        }
        
        else {
            $infrastructure[] = array(
              'id' => $b['id'],
              'lat' => $b['lat'],
              'lng' => $b['lng'],
              'category_id' => $b['category_id'],
              'weight' => $b['weight']
            );
        }  
    }
 }

// метро
$tr = db_query("SELECT * FROM transport");

if ($tr != false) {
    foreach($tr as $b) {
            
            $weight = 0;
            $weight = $b['input_people'] + $b['output_people'];
            
            $transport[] = array(
              'id' => $b['transport_id'],
              'lng' => $b['Longitude_WGS84'],
              'lat' => $b['Latitude_WGS84'],
              'weight' => $weight
            );

    }
}

$count = round(MOSCOW_HOUSES_AREA / MOSCOW_PEOPLES); // считаем сколько квадратов приходится на 1 человека

$tr = db_query("SELECT * FROM mos_realty");

if ($tr != false) {
    foreach($tr as $b) {
        
            $peoples = 0;
            
            if (!empty($b['area_residential'])) {
                $peoples = round( $b['area_residential'] / $count );
                
            }
            
            $houses[] = array(
              'id' => $b['id'],
              'lng' => $b['lng'],
              'lat' => $b['lat'],
              'area_residential' => $b['area_residential'],
              'weight' => $peoples
            );
        
    }

}

// достаём объекты для расчёта

$obj = db_query("SELECT * FROM relevant_places WHERE test2=0");

if ($obj != false) {
    foreach($obj as $b) {
        
        // радиус по которому будем считать
        $radius = $b['SQ_DIAMETR'] / 2;
        
        // вычисляем общий индекс постаматов конкурентов, которые находятся в заданном радиусе
        $postamatsIndex = 0;
        
        // перебираем постоматы конкурентов
        foreach($com_postamats as $k=>$v) {
            
            // считаем расстояние от текущей точки (в км)
            $distance = distance($b['lat'],$b['lng'],$v['lat'],$v['lng']);
            
            // переводим расстояние в метры
            $distance1 = round($distance * 1000);
            
            // если постамат входит в заданный радиус
            if ($distance1 <= $radius) {
                
                // считаем индекс этого постамата
                $index = calcIndex($v['weight'],$distance1);
                
                // суммируем инекс постамата с другими постаматами входящими в заданный радиус
                $postamatsIndex += $index;
            }
        }
        // ----------------------------------------------------------------------------------
        
        // вычисляем общий индекс инфраструктуры входящей в заданный радиус
        $infrastructureIndex = 0;
        
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
                $infrastructureIndex += $index;
            }
        }
        // ----------------------------------------------------------------------------------
        
        // вычисляем общий индекс точек метро входящих в заданный радиус
        $transportIndex = 0;
        
        // перебираем объекты транспорта
        foreach($transport as $k=>$v) {
            
            // считаем расстояние от текущей точки (в км)
            $distance = distance($b['lat'],$b['lng'],$v['lat'],$v['lng']);
            
            // переводим расстояние в метры
            $distance1 = round($distance * 1000);
            
            // если постамат входит в заданный радиус
            if ($distance1 <= $radius) {
                
                // считаем индекс этого объекта
                $index = calcIndex($v['weight'],$distance1);
                
                // суммируем инекс постамата с другими постаматами входящими в заданный радиус
                $transportIndex += $index;
            }
        }
        // ----------------------------------------------------------------------------------
        
        // вычисляем общий индекс по населению, проживающему в заданном радиусе
        $peoplesIndex = 0;
        
        // перебираем объекты транспорта
        foreach($houses as $k=>$v) {
            
            // считаем расстояние от текущей точки (в км)
            $distance = distance($b['lat'],$b['lng'],$v['lat'],$v['lng']);
            
            // переводим расстояние в метры
            $distance1 = round($distance * 1000);
            
            // если постамат входит в заданный радиус
            if ($distance1 <= $radius) {
                
                // считаем индекс этого объекта
                $index = calcIndex($v['weight'],$distance1);
                
                // суммируем инекс постамата с другими постаматами входящими в заданный радиус
                $peoplesIndex += $index;
            }
        }
        // ----------------------------------------------------------------------------------
        
        
        // добавляем полученные индексы в базу
        $upd = db_query("UPDATE relevant_places 
        SET infrastructure='".$infrastructureIndex."',
        people='".$peoplesIndex."',
        transport='".$transportIndex."',
        comercial_postsmat='".$postamatsIndex."',
        test2=1 
        WHERE id='".$b['id']."' 
        LIMIT 1
        ","u");
        
    }
}


}

if ($jenerateAjax != true) {
    exit();
} 