<?php

$pagename = $xc['url']['pdf'];

if (empty($pagename))
  exit(header('Location: /admin/'));

$map = db_query("SELECT * FROM mos_maps WHERE pagename='".$pagename."' LIMIT 1");

if ($map == false)
  exit(header('Location: /admin/'));
  
//$title = $map[0]['title'];