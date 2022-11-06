<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />

	<title><?=$xc['title'];?></title>
    
    <link rel="stylesheet" href="<?=DOMAIN;?>/admin/css/<?=$xc['style'];?>" />
    
    <?=$xc['head'];?>
</head>

<body>
<?=$xc['popup'];?>

<?if($xc['noMainTmp'] == false):?>

   <?=$xc['header'];?>

   <?=$xc['content']?>

   <?=$xc['footer'];?>

<?else:?>
   
   <?=$xc['content']?>
   
<?endif;?>

<?=$xc['js'];?>
<?=$xc['body'];?>
</body>
</html>