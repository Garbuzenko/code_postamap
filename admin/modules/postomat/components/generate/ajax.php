<?php

// подгрузка данных по выбранным праметрам
if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsShowFactorWeight') {
    
    $where = null;
    
    if ($_POST['model_id']!='') {
        $model_id = intval($_POST['model_id']);
        $where .= " AND model_id='".$model_id."' ";
    }
    
    if (!empty($_POST['sq_diametr'])) {
        $sq_diametr = intval($_POST['sq_diametr']);
        $where .= " AND SQ_DIAMETR='".$sq_diametr."' ";
    }
    
    if (!empty($where)) {
        
        $where = str_replace_once('AND','WHERE',$where);
        
        $data = db_query("SELECT * FROM mln_factor_weight ".$where);
        
        if ($data != false) {
            
            $models = array();
            $m = db_query("SELECT id, name FROM mln_model");
            
            foreach($m as $b) {
                $models[ $b['id'] ] = $b['name'];
            }
            
            ob_start();
            require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/postomat/components/generate/includes/dataTab.inc.php';
            $html = ob_get_clean();
            
            exit($html);
        }
        
    }
    
    
    exit();
    
    
}

if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsEditWeight') {
    
    $updData = false;
    $model_id = intval($_POST['model_id']);
    $sq_diametr = intval($_POST['sq_diametr']);
    $btn = $_POST['but'];
    
    foreach($_POST as $k=>$v) {
        
        if(preg_match('/weight/is',$k)) {
            $t = explode('-',$k);
            $id = $t[1];
            
            $upd = db_query("UPDATE mln_factor_weight 
            SET weight='".$v."' 
            WHERE id='".$id."' 
            LIMIT 1","u");
            
            if ($upd == true) {
                $updData = true;
            }
        }
        
    }
    
    if ($btn == 'generate') {
        
    
     $weight = array();
     $const = array();
     $constants = db_query("SELECT * FROM constants");
   
     if ($constants != false) {
        foreach($constants as $b) {
            $const[ $b['name'] ] = $b['value'];
        }
     }
    
       $a = db_query("update mln_factor_weight set max=(select max(relevance) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR ) where factor_id = 0","u");
        
       $a = db_query("update mln_factor_weight set max=(select max(people) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR ) where factor_id = 1","u");
        
       $a = db_query("update mln_factor_weight set max=(select max(infrastructure) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) where factor_id = 2","u");
        
       $a = db_query("update mln_factor_weight set max=(select max(transport) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) where factor_id = 3","u");
        
       $a = db_query("update mln_factor_weight set max=(select max(comercial_postsmat) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) where factor_id = 4","u");
        
       $a = db_query("update mln_factor_weight set min=(select min(relevance) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) where factor_id = 0","u");
        
       $a = db_query("update mln_factor_weight set min=(select min(people) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) where factor_id = 1","u");
       
       $a = db_query("update mln_factor_weight set min=(select min(infrastructure) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) where factor_id = 2","u");
        
       $a = db_query("update mln_factor_weight set min=(select min(transport) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) where factor_id = 3","u");
        
       $a = db_query("update mln_factor_weight set min=(select min(comercial_postsmat) from relevant_places where model_id = mln_factor_weight.model_id and  SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) where factor_id = 4","u");   
    
    // таблица весов
    $wh = db_query("SELECT * FROM mln_factor_weight 
    WHERE model_id=".$model_id." 
    AND SQ_DIAMETR='".$sq_diametr."'");
    
    if ($wh != false) {
        
        foreach($wh as $b) {
            
            $weight[ $b['factor_id'] ] = array(
              'weight' => $b['weight'], 
              'max' => $b['max'],
              'min' => $b['min']
              );
        }
    }

    //Удаляем записи из таблицы канибализации
    $can = db_query("DELETE FROM `cannibalization` 
    WHERE SQ_DIAMETR='".$sq_diametr."' 
    AND MODEL_ID='".$model_id."'","d");

    //Выбираем значения из таблицы POSTAMATS по модели и диаметру.
    $postamats = db_query("SELECT * 
    FROM postamats 
    WHERE SQ_DIAMETR='".$sq_diametr."' 
    AND MODEL_ID='".$model_id."' ORDER BY SQ_ID");

     if ($postamats != false) {
        
        foreach($postamats as $p) {
	    
        //Делаем SELECT из таблицы relevant_places по MODEL_ID, SQ_DIAMETR, SQ_ID
 	    $obj = db_query("SELECT * 
         FROM relevant_places 
         WHERE SQ_ID='".$p['SQ_ID']."' 
         AND SQ_DIAMETR='".$p['SQ_DIAMETR']."'
         AND MODEL_ID='".$p['MODEL_ID']."'");
    
         if ($obj != false) {
            
            foreach($obj as $b) {
            
                $relevance = 0;
                
                $infrastructureIndexResult = ($b['infrastructure'] - $weight[2]['min']) / ($weight[2]['max'] - $weight[2]['min']);
                $infrastructureIndexResult = $infrastructureIndexResult * $weight[2]['weight'];
                
                $comPostamatsIndexResult = ($b['comercial_postsmat'] - $weight[4]['min']) / ($weight[4]['max'] - $weight[4]['min']);
                $comPostamatsIndexResult = $comPostamatsIndexResult * $weight[4]['weight'];
                
                $transportIndexResult = ($b['transport'] - $weight[3]['min']) / ($weight[3]['max'] - $weight[3]['min']);
                $transportIndexResult = $transportIndexResult * $weight[3]['weight'];
                
                $peopleIndexResult = ($b['people'] - $weight[1]['min']) / ($weight[1]['max'] - $weight[1]['min']);
                $peopleIndexResult = $peopleIndexResult * $weight[1]['weight'];
                
                // радиус по которому будем считать
                $radius = ($b['SQ_DIAMETR'] * $const['w_select_cannibalization']) / 2;//$b['SQ_DIAMETR'];

                $lat_r = (0.000899352 * $radius)/100;
	            $lng_r = (0.001608967 * $radius)/100;

                $lat_min = $b['lat'] - $lat_r;
    	        $lat_max = $b['lat'] + $lat_r;
    
    	        $lng_min = $b['lng'] - $lng_r;
    	        $lng_max = $b['lng'] + $lng_r;
                
                $cannibalization_field = 0;
                $w_cannibalization = 0;
                $cannibalization_d = 0;
                
                    
                //Считаем параметр relevant_places-cannibalization по формуле:
	            //Выбираем значения из cannibalization на расстоянии SQ_DIAMETR 
	            $cannibalization = db_query("SELECT * 
                FROM cannibalization 
                WHERE SQ_DIAMETR='".$p['SQ_DIAMETR']."' 
                AND MODEL_ID='".$p['MODEL_ID']."' 
                AND (lat BETWEEN '".$lat_min."' AND '".$lat_max."') 
                AND (lng BETWEEN '".$lng_min."' AND '".$lng_max."')");
                
                if ($cannibalization == false) {
                    $cannibalization_d = $p['SQ_DIAMETR'];
                }
                
                
                if ($cannibalization != false) {
                    
                    $cannibalization_d = 100000;
                 
                    foreach($cannibalization as $can) {
                        
                        // считаем расстояние от текущей точки в метрах
                       $distance = distance($b['lat'],$b['lng'],$can['lat'],$can['lng']) * 1000;
                       
                       if ($cannibalization_d > $distance) {
                         $cannibalization_d = $distance;
                       }
                       
                       $cannibalization_field += $can['w_relevance'] / ($distance + $const['R0_cannibalization']);
                   
                    }
                }


                $cannibalizationIndexResult = $cannibalization_field * $weight[6]['weight'];
                $w_cannibalization = $cannibalizationIndexResult;
                
                $resultIndex = $cannibalizationIndexResult + $infrastructureIndexResult + $comPostamatsIndexResult + $transportIndexResult + $peopleIndexResult;
                $relevance = $b['priority'] * $resultIndex;
                
                // зануляем релевантность для постоматов расположенных ближе чем минимальное расстояние между постоматами
                if ($cannibalization_d < $weight[7]['weight']) {
                    $relevance = 0;
                    $cannibalization_field = 0;
                    $w_cannibalization = 0;
                    $cannibalization_d = 0;
                }
                
                if ($relevance < 0) {
                    $relevance = 0;
                }


                $upd = db_query("UPDATE relevant_places 
                SET relevance='".$relevance."',
                w_infrastructure='".$infrastructureIndexResult."',
                w_people='".$peopleIndexResult."',
                w_transport='".$transportIndexResult."',
                w_comercial_postsmat='".$comPostamatsIndexResult."',
                cannibalization='".$cannibalization_field."',
                w_cannibalization='".$w_cannibalization."',
                cannibalization_d='".$cannibalization_d."'
                WHERE id='".$b['id']."' 
                LIMIT 1","u");
                           
        }
        
        // после цикла по sq_id находим максимальные значения по этому sq_id и вставляем строку в таб. cannibalization
        $add = db_query("INSERT INTO cannibalization (SELECT * FROM relevant_places 
        WHERE SQ_ID='".$p['SQ_ID']."' 
        AND SQ_DIAMETR='".$p['SQ_DIAMETR']."'
        AND MODEL_ID='".$p['MODEL_ID']."'
        ORDER BY w_relevance DESC 
        LIMIT 1)","i");
        
	   }
     }

        
        // обновляем max для relevance
        $updMaxRelevance = db_query("UPDATE mln_factor_weight 
        SET max=(SELECT max(relevance) FROM relevant_places WHERE model_id = mln_factor_weight.model_id AND SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
        WHERE factor_id = 0");
        
        // обновляем min для relevance
        $updMinRelevance = db_query("UPDATE mln_factor_weight 
        SET min=(SELECT min(relevance) FROM relevant_places WHERE model_id = mln_factor_weight.model_id AND SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
        WHERE factor_id = 0");
        
        // обновляем max для relevance
        $updMaxRelevance = db_query("UPDATE mln_factor_weight 
        SET max=(SELECT max(cannibalization) FROM relevant_places WHERE model_id = mln_factor_weight.model_id AND SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
        WHERE factor_id = 6");
        
        // обновляем min для relevance
        $updMinRelevance = db_query("UPDATE mln_factor_weight 
        SET min=(SELECT min(cannibalization) FROM relevant_places WHERE model_id = mln_factor_weight.model_id AND SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
        WHERE factor_id = 6");
        
        // обновляем max для relevance
        $updMaxRelevance = db_query("UPDATE mln_factor_weight 
        SET max=(SELECT max(cannibalization_d) FROM relevant_places WHERE model_id = mln_factor_weight.model_id AND SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
        WHERE factor_id = 7");
        
        // обновляем min для relevance
        $updMinRelevance = db_query("UPDATE mln_factor_weight 
        SET min=(SELECT min(cannibalization_d) FROM relevant_places WHERE model_id = mln_factor_weight.model_id AND SQ_DIAMETR = mln_factor_weight.SQ_DIAMETR) 
        WHERE factor_id = 7");
        
        // достаём из базы новые веса
        $weight = array();
        
        $wh = db_query("SELECT * FROM mln_factor_weight 
        WHERE model_id=".$model_id." 
        AND SQ_DIAMETR='".$sq_diametr."'");
    
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
         $obj = db_query("SELECT id, relevance 
         FROM relevant_places 
         WHERE SQ_DIAMETR='".$sq_diametr."' 
         AND MODEL_ID='".$model_id."'");
    
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
        and SQ_ID = postamats.SQ_ID 
        ORDER BY w_relevance DESC LIMIT 1)","u");
        
        
        $a = db_query("UPDATE postamats 
INNER JOIN relevant_places 
ON relevant_places.id = postamats.relevant_places_id 
set postamats.district_id=relevant_places.district_id, 
postamats.adm_area_id=relevant_places.adm_area_id,
postamats.district=relevant_places.district,
postamats.adm_area=relevant_places.adm_area,
postamats.lng=relevant_places.lng,
postamats.lat=relevant_places.lat,
postamats.relevance=relevant_places.relevance,
postamats.infrastructure=relevant_places.infrastructure,
postamats.people=relevant_places.people,
postamats.people_count=relevant_places.people_count,
postamats.transport=relevant_places.transport,
postamats.comercial_postsmat=relevant_places.comercial_postsmat,
postamats.category=relevant_places.category,
postamats.category_id=relevant_places.category_id,
postamats.model=relevant_places.model,
postamats.cannibalization=relevant_places.cannibalization,
postamats.w_cannibalization=relevant_places.w_cannibalization,
postamats.cannibalization_d=relevant_places.cannibalization_d,
postamats.w_infrastructure=relevant_places.w_infrastructure,
postamats.w_people=relevant_places.w_people,
postamats.w_transport=relevant_places.w_transport,
postamats.w_comercial_postsmat=relevant_places.w_comercial_postsmat,
postamats.priority=relevant_places.priority,
postamats.w_relevance=relevant_places.w_relevance,
postamats.model_id=relevant_places.model_id","u");

        $a = db_query("set @val = 0;update  postamats set rating = (@val:=@val+1) where model_id = '".$model_id."' and sq_diametr = '".$sq_diametr."' order by relevance DESC;","u");
      
      }
      
      $html = '<div class="popupMessageDiv">Релевантность пересчитана</div>';
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
    
    exit('ok');
}