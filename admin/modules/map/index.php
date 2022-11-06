<?php defined('DOMAIN') or exit(header('Location: /'));

// данные для карты
require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/main/components/map/index.php';
// ----------------------------------------------------------------------------


$admAreaName = array();
$districtsAdmArea = array();

// административные округа
$admArea = db_query("SELECT * FROM mln_adm_area");

if ($admArea != false) {
    foreach($admArea as $k=>$v) {
        $admAreaName[ $v['id'] ] = $v['adm_area'];
    }
}
// ---------------------------------------------------------------------------

// Районы
$districts = db_query("SELECT id, district_name, id_adm_area FROM mln_districts ORDER BY id_adm_area");

if ($districts != false) {
    foreach($districts as $k=>$v) {
        $districtsAdmArea[ $v['id_adm_area'] ][ $v['id'] ] = $v['district_name'];
    }
}
// ---------------------------------------------------------------------------

// типы объектов
$objType = db_query("SELECT * FROM mln_objects_type");

// модели расчёта
$models = db_query("SELECT id, name FROM mln_model");