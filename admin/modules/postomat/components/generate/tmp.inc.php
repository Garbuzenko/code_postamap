<div class="page-heading">
   <div class="page-title">
       <div class="row">
         <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Генерация новых точек для постаматов</h3>
         </div>
                        
       </div>
   </div>
                
   <section class="section">
      <div class="card">
        <div class="card-body" style="overflow-x: auto;">
          <form method="post" action="" id="form_jsEditWeight" class="form form-vertical">
            <div class="form-body">
              <div class="row">
                   <div class="col-8">
                     <div class="form-group">
                       <label for="first-name-vertical">Модель</label>
                       <fieldset class="form-group">
                         <select class="form-select" name="model_id@">
                           <option value="">Выбрать</option>
                           <?if($models!=false):?>
                           <?foreach($models as $m):?>
                           <option value="<?=$m['id'];?>"><?=$m['name'];?></option>
                           <?endforeach;?>
                           <?endif;?>
                         </select>
                       </fieldset>
                     </div>
                   </div>   
                   
                   <div class="col-8">
                     <div class="form-group">
                       <label for="first-name-vertical">Диаметр</label>
                       <fieldset class="form-group">
                         <select class="form-select" name="sq_diametr@">
                           <option value="">Выбрать</option>
                           <option value="100">100</option>
                           <option value="200">200</option>
                           <option value="400">400</option>
                         </select>
                       </fieldset>
                     </div>
                   </div>
                   
                   <div class="col-8">
                     <div class="form-group">
                       <label for="first-name-vertical">Фактор</label>
                       <fieldset class="form-group">
                         <select class="form-select" name="factor_id@">
                           <option value="">Выбрать</option>
                           <?if($factors!=false):?>
                           <?foreach($factors as $f):?>
                           <option value="<?=$f['factor_id'];?>"><?=$f['factor'];?></option>
                           <?endforeach;?>
                           <?endif;?>
                         </select>
                       </fieldset>
                     </div>
                   </div>
                   
                   <div class="col-8">
                     <div class="form-group">
                       <label for="email-id-vertical">Вес</label>
                       <input type="number" class="form-control" name="weight@" placeholder="Задайте вес от 0 до 100">
                     </div>
                   </div>
                                                                                
                   <div class="col-8 d-flex justify-content-end">
                     <input type="hidden" name="module" value="postomat" />
                     <input type="hidden" name="component" value="generate" />
                     <input type="hidden" name="ok" value="Вес успешно обновлён" />
                     <input type="hidden" name="alert" value="0" />
                     <button type="button" class="send_form btn btn-primary me-1 mb-1" id="jsEditWeight">Сохранить</button>
                     <button type="reset" class="btn btn-light-secondary me-1 mb-1">Очистить</button>
                   </div>
              </div>
            </div>
          </form>
        </div>
      </div>          
   </section>
                
</div>
