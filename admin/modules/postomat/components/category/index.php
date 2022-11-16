<?php

$order = " ORDER BY id";

if (!empty($xc['url']['weight'])) {
    if ($xc['url']['weight'] == 1) {
        $order = " ORDER BY weight DESC";
    }
    
    else {
        $order = " ORDER BY weight";
    }
}

if (!empty($xc['url']['priority'])) {
    if ($xc['url']['priority'] == 1) {
        $order = " ORDER BY priority DESC";
    }
    
    else {
        $order = " ORDER BY priority";
    }
}

$cat = db_query("SELECT * FROM mln_category".$order);

// достаём список моделей рассчёта из базы
$models = db_query("SELECT id, name FROM mln_model");