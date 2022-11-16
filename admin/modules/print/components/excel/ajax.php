<?php

/// формирование excel файла
if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsCreateExcel') {
        
   // Подключаем класс для работы с excel
   require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/Classes/PHPExcel.php';
   // Подключаем класс для вывода данных в формате excel
   require_once $_SERVER['DOCUMENT_ROOT'] .'/lib/Classes/PHPExcel/Writer/Excel5.php';
        
        
   $excelPrice = '/admin/files/excel/postamats-' . time() .'.xls';
   $col = 8;
   
   // получаем фильтры по которым генерируют постаматы
   $filter = json_decode($_POST['filter'],true);
   
   if (!empty($filter['admArea'])) {
        $xc['where'] .= " AND a.adm_area_id IN (".implode(',',$filter['admArea']).")";
    }
    
    if (!empty($filter['district'])) {
        if (!empty($filter['admArea'])) {
            $xc['where'] = " AND ( a.district_id IN (".implode(',',$filter['district']).") OR a.adm_area_id IN (".implode(',',$filter['admArea']).") )";
        }
        
        else {
            $xc['where'] .= " AND a.district_id IN (".implode(',',$filter['district']).")";
        }
    }
    
    if (!empty($filter['category'])) {
        $xc['where'] .= " AND a.category_id IN (".implode(',',$filter['category']).") ";
    }
    
    if (!empty($filter['relevance_start'])) {
        $xc['where'] .= " AND a.w_relevance >= ".intval($filter['relevance_start'])." ";
    }
    
    if (!empty($filter['relevance_finish'])) {
        $xc['where'] .= " AND a.w_relevance <= ".intval($filter['relevance_finish'])." ";
    }
    
    $xc['where'] .= " AND a.SQ_DIAMETR=".intval($filter['sq_diametr'])." ";
    $xc['where'] .= " AND a.model_id=".intval($filter['model_id'])." ";
    
    $xc['where'] = str_replace_once('AND', 'WHERE', $xc['where']);
   
    $data = db_query("SELECT a.*,
    mln_category.category AS cat,
    mln_model.name AS modelName,
    infrastructure.adres AS address,
    infrastructure.city,
    mos_realty.address AS houseAddress 
    FROM postamats AS a 
    LEFT JOIN mln_category ON a.category_id = mln_category.id 
    LEFT JOIN mln_model ON a.model_id = mln_model.id 
    LEFT JOIN infrastructure ON (a.lng = infrastructure.lng AND a.lat = infrastructure.lat) 
    LEFT JOIN mos_realty ON (a.lng = mos_realty.lng AND a.lat = mos_realty.lat) 
    ".$xc['where']." 
    ORDER BY w_relevance DESC 
    LIMIT 10000");
    
    if ($data != false) {
        
       $i = 1;
        
       foreach ($data as $b) {
               
               $address = null;
               
               if (!empty($b['city'])) {
                  $address = $b['city'];
               }
               
               
               if (!empty($b['address'])) {
                
                  if (!empty($address)) {
                    $address .= ', '.$b['address'];
                  }
                  
                  else {
                     $address = $b['address'];
                  }
               }
               
               if (empty($address) && !empty($b['houseAddress'])) {
                  $address = $b['houseAddress'];
               }
               
               $a[] = array(
                 0 => $i,
                 1 => $b['adm_area'],
                 2 => $b['district'],
                 3 => $b['cat'],
                 4 => $b['lat'].' '.$b['lng'],
                 5 => $address,
                 6 => $b['modelName'],
                 7 => round($b['w_relevance']).'%'
               );

               $i++;
            }
        }
        
        
        $objReader = new PHPExcel_Reader_Excel5();
        $xls = $objReader->load($_SERVER['DOCUMENT_ROOT'] .'/admin/files/temp/printForExcel.xls');
        
        // Устанавливаем индекс активного листа
        $xls->setActiveSheetIndex(0);
        // Получаем активный лист
        $sheet = $xls->getActiveSheet();
        
        $j = 2;
           
        foreach ($a as $f) {

           for ($i = 0; $i < $col; $i++) {
             $sheet->setCellValueByColumnAndRow($i, $j, $f[$i]);
           }

           $j++;
       }
       
       $xls->setActiveSheetIndex(0);

       $objWriter = new PHPExcel_Writer_Excel5($xls);
       $objWriter->save($_SERVER['DOCUMENT_ROOT'] . $excelPrice);
        
       if (file_exists($_SERVER['DOCUMENT_ROOT'] . $excelPrice)) {
            
            $fileurl = DOMAIN.$excelPrice;
            $html = '<div class="popupMessageDiv"><a href="'.$fileurl.'" target="_blank">Скачать Excel</a></div>';
    
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


?>