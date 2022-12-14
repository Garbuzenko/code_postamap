<?php
define('DOMAIN', 'https://'.$_SERVER['HTTP_HOST']);
define('YANDEX_API_KEY', '');
define('PASS_STR', '');

define('MOSCOW_PEOPLES', '12635466'); // население москвы на 2022 год
define('MOSCOW_HOUSES_AREA', '289550000'); // количество квадратных метров жилой недвижимости в москве

$xc = array();

// данные для подключения к БД
$xc['db_host'] = 'localhost';
$xc['db_name'] = '';
$xc['db_user'] = '';
$xc['db_pass'] = '';

$xc['update'] = true; 
$xc['noMainTmp'] = false;
$xc['admin_panel_only'] = true; // если нужна только админка, то при заходе на сайт будет сразу перенаправлять туда
$xc['admin_main_module'] = 'dashbord/postamat'; // модуль по умолчанию (для главной страницы в админке)

$xc['ya_map'] = false; // яндекс карты
$xc['bottom_popup_window'] = false;
$xc['no_metrika'] = false;

$xc['title'] = '';
$xc['canonical'] = null;