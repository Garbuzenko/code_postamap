<?php

$currentDir = __DIR__ . '/';

include_once $currentDir . 'sbPolyPointer.php';

$polygonBox = [[55.68403,37.55226],[55.68408,37.55232],[55.68428,37.55256],[55.68432,37.55261],[55.68435,37.55265],[55.68504,37.55353],[55.68549,37.5541],[55.68555,37.55417],[55.68561,37.55425],[55.68616,37.55491],[55.68662,37.55547],[55.68672,37.55558],[55.68706,37.55598],[55.68727,37.55624],[55.68736,37.55635],[55.68763,37.55668],[55.6884,37.55762],[55.68866,37.55792],[55.69102,37.56076],[55.69129,37.56111],[55.69148,37.56136],[55.69156,37.56146],[55.69194,37.56206],[55.692,37.56216],[55.69206,37.56225],[55.69223,37.56253],[55.69244,37.56289],[55.69252,37.56303],[55.69294,37.56378],[55.6932,37.56425],[55.69345,37.56469],[55.69361,37.56499],[55.69431,37.5662],[55.69445,37.56645],[55.69453,37.56657],[55.69461,37.56673],[55.69466,37.56682],[55.6955,37.56831],[55.69564,37.56856],[55.69602,37.56924],[55.69701,37.571],[55.69708,37.57113],[55.69716,37.57126],[55.69721,37.57135],[55.69766,37.57213],[55.69865,37.57387],[55.69914,37.57473],[55.69921,37.57485],[55.69932,37.57504],[55.69946,37.57529],[55.6997,37.5757],[55.70038,37.57691],[55.70075,37.57756],[55.70123,37.57837],[55.70159,37.57902],[55.70187,37.57948],[55.70221,37.58007],[55.70222,37.58009],[55.70231,37.58027],[55.70243,37.58047],[55.70245,37.5805],[55.70282,37.58117],[55.70304,37.58155],[55.70326,37.58194],[55.7042,37.58362],[55.70461,37.58434],[55.70505,37.58513],[55.7057,37.58624],[55.70571,37.58626],[55.70596,37.58663],[55.70605,37.5868],[55.70634,37.58731],[55.70611,37.5875],[55.70578,37.58782],[55.70549,37.58808],[55.70508,37.58846],[55.70444,37.58902],[55.70408,37.58934],[55.70351,37.58984],[55.70219,37.59097],[55.69987,37.59296],[55.6987,37.59398],[55.69761,37.5949],[55.69678,37.59562],[55.69607,37.59625],[55.69557,37.59673],[55.69523,37.5971],[55.69485,37.59756],[55.6944,37.59806],[55.69367,37.59896],[55.69345,37.59922],[55.6931,37.5996],[55.69271,37.60007],[55.6922,37.60068],[55.69178,37.60131],[55.69158,37.60162],[55.69153,37.60149],[55.69127,37.60084],[55.69105,37.60028],[55.69074,37.59946],[55.69053,37.59891],[55.69035,37.59845],[55.69014,37.5981],[55.68985,37.59768],[55.68877,37.59652],[55.68853,37.59624],[55.68791,37.59563],[55.6877,37.59541],[55.68759,37.59529],[55.68704,37.5947],[55.68598,37.59355],[55.68559,37.59312],[55.68551,37.59303],[55.68479,37.59224],[55.68465,37.59209],[55.6846,37.59203],[55.6841,37.5915],[55.6835,37.59084],[55.68314,37.59044],[55.68268,37.58994],[55.68231,37.58951],[55.68212,37.58931],[55.68171,37.58886],[55.68134,37.58844],[55.6805,37.58748],[55.68012,37.58687],[55.67999,37.5867],[55.67949,37.58642],[55.67929,37.58628],[55.67915,37.58614],[55.67905,37.58594],[55.67892,37.58556],[55.6789,37.58551],[55.67846,37.58421],[55.67833,37.58383],[55.67809,37.58312],[55.67767,37.58187],[55.67727,37.58069],[55.67693,37.57968],[55.67691,37.57951],[55.67675,37.57963],[55.67516,37.5803],[55.67513,37.58031],[55.67503,37.58033],[55.67486,37.58031],[55.67432,37.57975],[55.67397,37.57939],[55.67395,37.57937],[55.67356,37.57897],[55.67312,37.57852],[55.67296,37.57836],[55.67273,37.57813],[55.67269,37.57809],[55.67488,37.57171],[55.67568,37.56942],[55.676,37.56852],[55.67761,37.56381],[55.67789,37.56299],[55.67802,37.56275],[55.67843,37.56198],[55.68066,37.55812],[55.68213,37.55556],[55.68254,37.5548],[55.68403,37.55226]];

$sbPolygonEngine = new sbPolygonEngine($polygonBox);

$isCrosses = $sbPolygonEngine->isCrossesWith(55.746768, 37.625605);

print '$isCrosses: ' . (int) $isCrosses . '<br/>';

$isCrosses = $sbPolygonEngine->isCrossesWith(55.757139, 37.603484);

print '$isCrosses: ' . (int) $isCrosses . '<br/>';

print '<pre>' . print_r($sbPolygonEngine, true) . '</pre>';

?>