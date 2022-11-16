<?php

if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_jsEditConstants') {
    
    $btn = $_POST['but'];
    $arr = array();
    
    foreach($_POST as $k=>$v) {
        
        if(preg_match('/value/is',$k)) {
            $t = explode('-',$k);
            $id = $t[1];
            $arr[ $id ] = $v;
        }
    }
    
    foreach($arr as $id=>$val) {
        $upd = db_query("UPDATE constants 
        SET value='".$val."' 
        WHERE id='".$id."'  
        LIMIT 1","u");
    }
    
    if ($btn == 'generate') {
        
    }
    
    exit('ok');
}