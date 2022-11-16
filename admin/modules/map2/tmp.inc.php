<!--  <div class="page-heading">
                <h3>Карта</h3>
            </div> -->
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                    
                        <form method="post" action="" id="form_jsSearchInMap">
                        <div class="row">
                            <div class="col-12 col-lg-4 col-md-12">
                                
                                <div class="form-group">
                                   <label>Административный округ</label>

                                   <div class="form-group">
                                     <select name="admArea[]" class="js-select choices form-select multiple-remove" multiple="multiple">
                                       <?if ($admArea != false):?>
                                       <?foreach($admArea as $k=>$v):?>
                                       <option value="<?=$v['id'];?>"><?=$v['adm_area'];?></option>
                                       <?endforeach;?>
                                       <?endif;?>     
                                      </select>
                                   </div>
                                </div>
                            
                            </div>
                            
                             <div class="col-12 col-lg-4 col-md-12">
                                
                                <div class="form-group">
                                   <label>Район</label>

                                   <div class="form-group">
                                     <select name="district[]" class="js-select choices form-select multiple-remove" multiple="multiple">
                                       <?if (!empty($districtsAdmArea)):?>
                                       <?foreach($districtsAdmArea as $adm_id=>$val):?>
                                       <optgroup label="<?=$admAreaName[$adm_id];?> административный округ">
                                         <?foreach($val as $district_id=>$district):?>
                                         <option value="<?=$district_id;?>"><?=$district;?></option>
                                         <?endforeach;?>
                                       </optgroup>
                                       <?endforeach;?>
                                       <?endif;?>     
                                      </select>
                                   </div>
                                </div>
                            
                            </div>
                             
                            <div class="col-12 col-lg-4 col-md-12 mb-3">
                                <fieldset>
                                  <label for="basicInput">Востребованность</label>
                                  <div class="input-group input-group-lg">
                                    <input type="number" name="relevance_start" maxlength="2" aria-label="от" class="form-control" placeholder="от" style="border-radius: 0; font-size: 15px; padding: 0.7rem 1rem;">
                                    <input type="number" name="relevance_finish" maxlength="3" aria-label="до" class="form-control" placeholder="до" style="border-radius: 0; font-size: 15px;">
                                    </div>
                                  </fieldset>
                            </div>
                             
                             
                            <div class="col-12 col-lg-4 col-md-12">
                                
                                <div class="form-group">
                                   <label>Тип объекта</label>

                                   <div class="form-group">
                                     <select name="category[]" class="js-select choices form-select multiple-remove" multiple="multiple">
                                       <?if ($objType != false):?>
                                       <?foreach($objType as $k=>$v):?>
                                       <option value="<?=$v['id'];?>"><?=$v['category'];?></option>
                                       <?endforeach;?>
                                       <?endif;?>   
                                      </select>
                                   </div>
                                </div>
                            
                            </div>
                            
                            <div class="col-12 col-lg-2 col-md-12">
                                
                                <div class="form-group">
                                   <label>Радиус</label>
                                   
                                   <div class="form-group">
                                     <select name="sq_diametr" class="choices form-select">
                                      <option value="400">200</option>
                                      <option value="200">100</option>
                                      <option value="100">50</option>              
                                    </select>
                                  </div>
                                </div>
                            
                            </div>
                            
                            <div class="col-12 col-lg-4 col-md-12">
                                <label>Модель</label>
                             
                                <div class="form-group">
                                  <select name="model_id" class="choices form-select">
                                    <?if($models!=false):?>
                                    <?foreach($models as $v):?>
                                    <option value="<?=$v['id'];?>"><?=$v['name'];?></option>
                                    <?endforeach;?>
                                    <?endif;?>                  
                                  </select>
                                </div>
                            </div>
                            
                            <div class="col-12 col-lg-2 col-md-12">
                               <input type="hidden" name="module" value="main" />
                               <input type="hidden" name="component" value="map2" />
                               <input type="hidden" name="ajaxLoad" value="ajaxLoadMap" />
                               <input type="hidden" name="opaco" value="1" />
                               
                               <button type="button" id="jsSearchInMap" style="width: 100%; height: 42px; margin-top: 25px;" class="send_form btn btn-primary me-1 mb-3">Показать</button>
                               
                            </div>
                             

                        </div>
                        </form>

                        <div class="row">
                            <div class="col-12">
                                <div class="card" id="ajaxLoadMap">
                                   <?require_once $_SERVER['DOCUMENT_ROOT'].'/admin/modules/main/components/map2/tmp.inc.php';?>
                                </div>
                            </div>
                        </div>

                          
                        
                    </div>
                </section>
            </div>