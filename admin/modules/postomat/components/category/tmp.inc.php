<div class="page-heading">
   <div class="page-title">
       <div class="row">
         <div class="col-12 col-md-12 order-md-1 order-last">
            <h3>Изменение весов и приоритетов категорий</h3>
         </div>
                        
       </div>
   </div>
                
   <section class="section">
      <div class="card">
        <div class="card-body" style="overflow-x: auto; min-height: 500px;">
             <form method="post" action="" id="form_jsEditWeight">
               <table class="table table-hover mb-0">
                <thead>
                 <tr>
                  <th>#</th>
                  <th>КАТЕГОРИЯ</th>
                  <th>ВЕС <a href="<?=DOMAIN;?>/admin/postomat/category?weight=1">&#9650;</a> <a href="<?=DOMAIN;?>/admin/postomat/category?weight=2">&#9660;</a></th>
                  <th>ПРИОРИТЕТ <a href="<?=DOMAIN;?>/admin/postomat/category?priority=1">&#9650;</a> <a href="<?=DOMAIN;?>/admin/postomat/category?priority=2">&#9660;</a></th>
                 </tr>
                </thead>
               <tbody>
               <?foreach($cat as $v):?>
               <tr>
                <td><img src="<?=DOMAIN;?>/admin/img/icons/<?=$v['img'];?>" width="35" alt="" /></td>
                <td class="text-bold-500"><?=$v['category'];?></td>
                <td><input type="text" name="weight-<?=$v['id'];?>" value="<?=$v['weight']?>" class="form-control"></td>
                <td><input type="text" name="priority-<?=$v['id'];?>" value="<?=$v['priority']?>" class="form-control"></td>
              </tr>
    <?endforeach;?>                 
   </tbody>
</table>

<div class="row mt-3">
   <div class="col-md-6 col-12">
     <div class="form-group">
       <label for="first-name-vertical">Модель</label>
         <fieldset class="form-group">
           <select class="form-select" name="model_id">
           <?if($models!=false):?>
           <?foreach($models as $m):?>
           <option value="<?=$m['id'];?>"><?=$m['name'];?></option>
           <?endforeach;?>
           <?endif;?>
           </select>
           </fieldset>
     </div>
   </div>   
                   
   <div class="col-md-6 col-12">
     <div class="form-group">
     <label for="first-name-vertical">Диаметр</label>
     <fieldset class="form-group">
       <select class="form-select" name="sq_diametr">
          <option value="400">400</option>
          <option value="200">200</option>
          <option value="100">100</option>          
       </select>
     </fieldset>
     </div>
   </div>
</div>

      <input type="hidden" name="module" value="postomat" />
      <input type="hidden" name="component" value="category" />
      <input type="hidden" name="alert" value="0" />
      <input type="hidden" name="ajaxMessage" value="Идёт пересчёт индексов..." />
      <input type="hidden" name="ok" value="Данные сохранены" />

      <div class="col-8 d-flex justify-content-end" style="float: right; margin-top: 10px;">
        <button type="button" name="save" class="send_form btn btn-primary" id="jsEditWeight" style="margin-right: 10px;">Сохранить</button>
        <button type="button" name="generate" class="send_form btn btn-secondary" id="jsEditWeight">Пересчитать</button>
      </div>



</form>
            </div>

          
          
          
          
        </div>
      </div>          
   </section>
                
</div>
