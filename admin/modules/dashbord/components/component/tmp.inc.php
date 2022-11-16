<?if($pagename == 'postamat' && MOBILE == false):?>
<section class="section">
      <div class="card" style="margin-bottom: 50px;">
        <div class="card-body">

        <form method="post" action="" id="form_jsShowBtn">
         <input type="hidden" name="module" value="print" />
         <input type="hidden" name="component" value="" />
         <input type="hidden" name="url" value="<?=DOMAIN;?>/admin/dashbord/print?pdf=postamat" />
         <input type="hidden" name="ajaxMessage" value="Идёт формирование PDF файла..." />
         <button class="send_form btn btn-primary btn-sm" id="jsShowBtn">Сохранить в PDF</button>
        </form>

     </div>
     </div>
</section>

<?endif;?>

<div style="width: <?if(MOBILE==true):?>117%<?else:?>100%<?endif;?>; height: 100%; margin: 0 auto; <?if(MOBILE==true):?>margin-left: -8%;<?endif;?>">
<?=$map[0]['iframe'];?>
</div>