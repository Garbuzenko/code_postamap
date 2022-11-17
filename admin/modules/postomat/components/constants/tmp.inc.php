<div class="page-heading">
   <div class="page-title">
       <div class="row">
         <div class="col-12 col-md-6 order-md-1 order-last">
            <h3>Константы</h3>
         </div>
                        
       </div>
   </div>
                
   <section class="section">
      <div class="card">
        <div class="card-body" style="overflow-x: auto; min-height: 500px;">
             <form method="post" action="" id="form_jsEditConstants">
               <table class="table table-hover mb-0">
                <thead>
                 <tr>
                  <th>КОНСТАНТА</th>
                  <th>ЗНАЧЕНИЕ</th>
                 </tr>
                </thead>
               <tbody>
               <?foreach($const as $v):?>
               <tr>
                <td class="text-bold-500"><?=$v['text'];?></td>
                <td><input type="text" name="value-<?=$v['id'];?>" value="<?=$v['value']?>" class="form-control"></td>
              </tr>
    <?endforeach;?>                 
   </tbody>
</table>

      <input type="hidden" name="module" value="postomat" />
      <input type="hidden" name="component" value="constants" />
      <input type="hidden" name="alert" value="0" />
      <input type="hidden" name="ok" value="Значения констант сохранены" />

      <div class="col-8 d-flex justify-content-end" style="float: right; margin-top: 10px;">
        <button type="button" name="save" class="send_form btn btn-primary" id="jsEditConstants" style="margin-right: 10px;">Сохранить</button>
        <!--<button type="button" name="generate" class="send_form btn btn-secondary" id="jsEditConstants">Пересчитать</button>-->
      </div>



</form>
            </div>

          
          
          
          
        </div>
      </div>          
   </section>
                
</div>
