<!DOCTYPE HTML>
<head>
	
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="content-type" content="text/html" />
	<title><?=$xc['title'];?></title>
    
    <?if(!empty($xc['canonical'])):?>
    <link rel="canonical" href="<?=$xc['canonical'];?>"/>
    <?endif;?>

    
    <link rel="stylesheet" href="<?=DOMAIN;?>/css/<?=$xc['style'];?>" />
    
    <?=$xc['head'];?>
    
    <?if($xc['ya_map']==true):?>
    <script src="https://api-maps.yandex.ru/2.1/?apikey=<?=YANDEX_API_KEY;?>&lang=ru_RU"></script>
    <?endif;?>
</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="200">

<?if($xc['noMainTmp'] == false):?>

   <?=$xc['header'];?>

   <?=$xc['content']?>

   <?=$xc['footer'];?>

<?else:?>
   
   <?=$xc['content']?>
   
<?endif;?>

<?=$xc['js'];?>
<?=$xc['body'];?>

<?=$xc['popup'];?>

<?if($xc['no_metrika']==false):?>
  <?=$xc['office'][0]['counter'];?>
<?endif;?>
</body>
</html>