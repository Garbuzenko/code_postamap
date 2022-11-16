<div class="row mb-2">
<div class="col-sm-12 col-md-3">
 <div class="dataTables_info" id="datatable-buttons_info" role="status" aria-live="polite">
    Всего объектов: <strong><?=number_format($col,0,'',' ');?></strong>
 </div>
</div>

<div class="col-sm-12 col-md-2 mb-2">
<div class="dt-buttons btn-group" style="width: 100%;">
<a style="padding: .290rem .75rem;" class="btn btn-primary buttons-copy buttons-html5" tabindex="0" aria-controls="datatable-buttons" href="<?=DOMAIN;?>/admin/files/csv/postamats.csv"><span>Скачать CSV</span></a>
</div>
</div>

<div style="overflow-x: auto;">
<table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
  <thead>
    <tr>
      <th>url</th>
      <th>Модель</th>
      <th>Диаметр</th>
      <th>Адм. округ</th>
      <th>Район</th>
      <th>Релевантность</th>
      <th>Конкуренция</th>
      <th>Инфраструктура</th>
      <th>Население</th>
      <th>Транспорт</th>
    </tr>
  </thead>
            
  <tbody>
    <?foreach($data as $b):?>
    <tr>
      <td>
       <a class="dataObjectLink" href="/admin/postomat?id=<?=$b['id'];?>" target="_blank">
        Смотреть
       </a>
      </td>
      <td><?=$b['model']?></td>
      <td><?=$b['SQ_DIAMETR']?></td>
      <td><?=$b['adm_area']?></td>
      <td><?=$b['district']?></td>
      <td><?=round($b['w_relevance'],2);?></td>
      <td><?=round($b['w_comercial_postsmat'],2);?></td>
      <td><?=round($b['w_infrastructure'],2);?></td>
      <td><?=round($b['w_people'],2);?></td>
      <td><?=round($b['w_transport'],2);?></td>
    </tr>
    <?endforeach;?>                                        
  </tbody>
</table>

<?=$nav;?>
</div>                                            
