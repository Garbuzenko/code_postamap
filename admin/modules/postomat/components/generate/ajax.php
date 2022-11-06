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
    
    ob_start();
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
        // делаем пресчёn параметров с учётом нового веса
        $jenerateAjax = true;
        require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/calc/index.php';
    }
    
    exit('ok');
}