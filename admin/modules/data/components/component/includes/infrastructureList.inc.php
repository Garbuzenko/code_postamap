<div class="row">
  <div class="col-sm-12 col-md-12 mb-2">
    <div class="dataTables_info" id="datatable-buttons_info">
      Всего объектов инфраструктуры: <strong><?=number_format($col,0,'',' ');?></strong>
    </div>
</div>
</div>


<div class="row">

<div class="col-sm-12 col-md-2 mb-2">
<div class="dt-buttons btn-group" style="width: 100%;">
<a style="padding: .290rem .75rem;" class="btn btn-primary buttons-copy buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="<?=DOMAIN;?>/admin/files/csv/infrastructure.csv"><span>Скачать CSV</span></a>
</div>
</div>

<div class="col-sm-12 col-md-10 mb-2">
<form method="post" action="" id="form_jsSportZoneSearch">
  <div id="datatable-buttons_filter" class="dataTables_filter">
  <div class="row">
  
  <div class="col-sm-12 col-md-6">
    <label style="width: 100%;"><input type="text" id="districtFilter" name="district" value="<?=$district;?>" class="form-control jsClear jsClearInput jsSelectList" placeholder="Поиск по району" aria-controls="datatable-buttons" autocomplete="off"></label>
    
    <input type="hidden" id="districtFilter_mod" value="data" />
    <input type="hidden" id="districtFilter_com" value="component" />
    <input type="hidden" id="districtFilter_arr" value="infrastructure" />
    <input type="hidden" name="district_id" id="districtFilter_id" class="jsClear" value="<?=$district_id;?>" />
     
    <div id="districtFilter2" class="tmpAjaxListDiv hidden" style="width: 360px; margin-top: 2px;"></div>
  
  </div> 
  
  <div class="col-sm-12 col-md-6">
    <label style="width: 100%;"><input type="text" id="sportType" name="sport" value="" class="form-control jsClear jsClearInput jsSelectList" placeholder="Категория" aria-controls="datatable-buttons" autocomplete="off"></label>
    
    <input type="hidden" id="sportType_mod" value="data" />
    <input type="hidden" id="sportType_com" value="component" />
    <input type="hidden" id="sportType_arr" value="infrastructure" />
    <input type="hidden" name="category_id" id="sportType_id" class="jsClear" value="" />
     
    <div id="sportType2" class="tmpAjaxListDiv hidden" style="width: 355px; margin-top: 2px;"></div>
  
  </div> 
  
  <input type="hidden" name="module" value="data" />
  <input type="hidden" name="component" value="component" />
  <input type="hidden" name="ajaxLoad" value="jsDataAjaxLoadDiv" />
  <input type="hidden" name="opaco" value="1" />
  
  <button class="send_form hidden" id="jsSportZoneSearch"></button>
  
  </div> 
  </div>
  
  </form>
</div>

</div>

<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  <thead>
    <tr>
      <th>Наименование</th>
      <th>Категория</th>
      <th>Район</th>
      <th>Адрес</th>
    </tr>
  </thead>
            
  <tbody>
    <?foreach($data as $b):?>
    <tr>
      <td><?=$b['name'];?></td>
      <td><?=$b['catName'];?></td>
      <td><?=$b['district'];?></td>
      <td><?=$b['adres'];?></td>
    </tr>
    <?endforeach;?>                                        
  </tbody>
</table>
                                            
<?=$nav;?>