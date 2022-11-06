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
        <div class="card-body" style="overflow-x: auto; min-height: 500px;">
          <form method="post" action="" id="form_jsShowFactorWeight" class="form form-vertical">
            <div class="form-body">
              <div class="row">
                   <div class="col-md-6 col-12">
                     <div class="form-group">
                       <label for="first-name-vertical">Модель</label>
                       <fieldset class="form-group">
                         <select class="form-select jsClickFactorBtn" name="model_id" data-btn="#jsShowFactorWeight" id="jsSelect1">
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
                   
                   <div class="col-md-6 col-12">
                     <div class="form-group">
                       <label for="first-name-vertical">Диаметр</label>
                       <fieldset class="form-group">
                         <select class="form-select jsClickFactorBtn" name="sq_diametr" data-btn="#jsShowFactorWeight" id="jsSelect2">
                           <option value="">Выбрать</option>
                           <option value="100">100</option>
                           <option value="200">200</option>
                           <option value="400">400</option>
                         </select>
                       </fieldset>
                     </div>
                   </div>
                                                        
                   <div class="col-8 d-flex justify-content-end">
                     <input type="hidden" name="module" value="postomat" />
                     <input type="hidden" name="component" value="generate" />
                     <input type="hidden" name="ajaxLoad" value="jsFactorWeightTabDiv" />
                     <input type="hidden" name="opaco" value="1" />
                     <input type="hidden" name="alert" value="0" />
                     <button type="button" class="send_form hidden" id="jsShowFactorWeight"></button>
                     
                   </div>
              </div>
            </div>
          </form>
          
          <div id="jsFactorWeightTabDiv"></div>
          
          
        </div>
      </div>          
   </section>
                
</div>
