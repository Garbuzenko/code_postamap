<form method="post" action="" id="form_jsEditWeight">
<table class="table table-hover mb-0">
  <thead>
    <tr>
      <th>МОДЕЛЬ</th>
      <th>ДИАМЕТР</th>
      <th>ФАКТОР</th>
      <th>МАКСИМУМ</th>
      <th>МИНИМУМ</th>
      <th>ВЕС</th>
    </tr>
  </thead>
  <tbody>
    <?foreach($data as $v):?>
    <tr>
      <td class="text-bold-500"><?=$models[ $v['model_id'] ];?></td>
      <td><?=$v['SQ_DIAMETR'];?></td>
      <td class="text-bold-500"><?=$v['factor'];?></td>
      <td><?=$v['max'];?></td>
      <td class="text-bold-500"><?=$v['min'];?></td>
      <td>
        <input type="text" name="weight-<?=$v['id'];?>" value="<?=$v['weight']?>" class="form-control">
      </td>
    </tr>
    <?endforeach;?>                 
   </tbody>
</table>

<input type="hidden" name="module" value="postomat" />
<input type="hidden" name="component" value="generate" />
<input type="hidden" name="model_id" value="<?=$model_id;?>" />
<input type="hidden" name="sq_diametr" value="<?=$sq_diametr;?>" />
<input type="hidden" name="alert" value="0" />
<input type="hidden" name="ok" value="Веса обновлены" />
<input type="hidden" name="ajaxMessage" value="Идёт пересчёт релевантности..." />
<div class="col-8 d-flex justify-content-end" style="float: right; margin-top: 10px;">
                     
  <button type="button" name="save" class="send_form btn btn-primary" id="jsEditWeight" style="margin-right: 10px;">Сохранить</button>
  <button type="button" name="generate" class="send_form btn btn-secondary" id="jsEditWeight">Сгенерировать</button>
                     
</div>



</form>