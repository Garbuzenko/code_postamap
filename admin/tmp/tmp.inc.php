<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$xc['title'];?></title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?=DOMAIN;?>/admin/themplate/dist/assets/css/bootstrap.css">

    <link rel="stylesheet" href="<?=DOMAIN;?>/admin/themplate/dist/assets/vendors/iconly/bold.css">

    <link rel="stylesheet" href="<?=DOMAIN;?>/admin/themplate/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?=DOMAIN;?>/admin/themplate/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?=DOMAIN;?>/admin/themplate/dist/assets/css/app.css">
    <link rel="stylesheet" href="<?=DOMAIN;?>/admin/themplate/dist/assets/vendors/apexcharts/apexcharts.css">
    
    <link rel="shortcut icon" href="<?=DOMAIN;?>/admin/img/favicon.ico" type="image/x-icon">
    
    <!-- Свои стили -->
    <link type="text/css" href="<?=DOMAIN;?>/admin/css/<?=$xc['style'];?>" rel="stylesheet">
    
    <!-- Если в отдельном модуле надо что то добавить в head -->
    <?=$xc['head'];?>
</head>

<body>

<?=$xc['popup'];?>

<?if($xc['noMainTmp']==false):?>
     <div id="app">
                    
                <!-------------------------- Меню -------------------------------------->
                <?=$xc['menu'];?>
                <!---------------------------------------------------------------------->

               <div id="main">
               
                <!-------------------------- header ------------------------------------>
                <?=$xc['header'];?>
                <!---------------------------------------------------------------------->
                                  
                <!-------------------------- content ----------------------------------->
                <?=$xc['content'];?>
                <!---------------------------------------------------------------------->
                        
                <!-------------------------- footer ------------------------------------>
                <?=$xc['footer'];?>
                <!---------------------------------------------------------------------->

               </div>
     </div>

    <!--------------------------------- Подключение js файлов -------------------------->
    <?=$xc['js'];?>
    <!---------------------------------------------------------------------------------->
    
    <?else:?>
    
    <?=$xc['content'];?>
    
    <!-- Свои скрипты -->
    <script src="<?=DOMAIN;?>/lib/js/jquery/jquery.min.js"></script>
    <script src="<?=DOMAIN;?>/admin/js/<?=$xc['scripts'];?>"></script>
    
    <?endif;?>
    
    <!----------------- Подключение js файлов отдельного модуля ------------------------>
    <?=$xc['body'];?>
    <!---------------------------------------------------------------------------------->
    
</body>

</html>