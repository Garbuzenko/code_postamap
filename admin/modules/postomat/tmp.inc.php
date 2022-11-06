<div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3>Постомат</h3>
                            <!--<p class="text-subtitle text-muted">A chart for user </p>-->
                        </div>
                    </div>
                </div>
                
                
                
                 <section class="section">
                   <div class="row">
                     <div class="col-md-3">
                      <div class="card">
                       <div class="card-body">
                         <h4 class="card-title">Население</h4>
                         <p class="tmpBigText" style="color: #ff3d64;"><?=round($postomat[0]['w_people'],2);?></p>
                       </div>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Инфраструктура</h4>
                         <p class="tmpBigText" style="color: #4da2f1;"><?=round($postomat[0]['w_infrastructure'],2);?></p>  
                       </div>
                       </div>
                     </div>
                     <div class="col-md-3">
                      <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Транспорт</h4>
                         <p class="tmpBigText" style="color: #be2443;"><?=round($postomat[0]['w_transport'],2);?></p>  
                       </div>
                      </div>
                     </div>
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Конкуренция</h4>
                         <p class="tmpBigText" style="color: #0fa08d;"><?=round($postomat[0]['w_comercial_postsmat'],2);?></p>  
                       </div>
                       </div>
                     </div>
                   </div>
                 </section>
                 
        
                  <section class="section">
                  <div class="row">
                  
                  <div class="col-md-6">
                     <div class="card" style="height: 400px;">
                        <div class="card-header">
                           <h4>Востребованность</h4>
                        </div>
                        <div class="card-body">
                           <div id="radialGradient"></div>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-md-6">
                     <div class="card" style="height: 400px;">
                        <div class="card-header">
                           <h4>Модель &laquo;<a href="<?if($postomat[0]['model_id']==0):?>https://docs.google.com/document/d/e/2PACX-1vTcdcIas0NugCZjwl9xouEk404Xlm8g6fe3Ov8wzf3rj0KEKcBLBzVg39nouwvSckgZu0aLJDmZAA7n/pub?embedded=true<?endif;?><?if($postomat[0]['model_id']==1):?>https://docs.google.com/document/d/e/2PACX-1vTcdcIas0NugCZjwl9xouEk404Xlm8g6fe3Ov8wzf3rj0KEKcBLBzVg39nouwvSckgZu0aLJDmZAA7n/pub?embedded=true<?endif;?>" target="_blank"><?=$postomat[0]['model'];?></a>&raquo;</h4>
                        </div>
                        <div class="card-body">
                           <ul class="list-group list-group-flush">
                             <li class="list-group-item">Административный округ: <?=$postomat[0]['adm_area'];?></li>
                             <li class="list-group-item">Район: <?=$postomat[0]['district'];?></li>
                             <li class="list-group-item">Категория объекта: <?=$postomat[0]['category'];?></li>
                             <li class="list-group-item">Рубрика: <?=$postomat[0]['rubrica_text'];?></li>
                             <li class="list-group-item">Приоритет размещения: <?=$postomat[0]['priority'];?></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-md-12">
                     <div id="map" style="width: 100%; height: 430px;"></div>
                  </div>
                  
                  
                  <!--
                  <div class="col-md-6">
                      <div class="card">
                        <div class="card-header">
                           <h4>Индексы</h4>
                        </div>
                        <div class="card-body">
                           <div id="bar"></div>
                        </div>
                      </div>
                  </div>
                  -->
                  
                </div>
                </section>
                <br />
                
                 <?if(!empty($transport)):?>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            Объекты транспортной инфраструктуры (<?=count($transport);?> в радиусе <?=$radius1;?> м.)
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Наименование</th>
                                        <th>Расстояние</th>
                                        <th>Входящий пассажиропоток</th>
                                        <th>Исходящий пассажиропоток</th>
                                        <th>Категория</th>
                                        <th>Вес</th>
                                        <th>Индекс</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?foreach($transport as $k=>$v):?>
                                    <tr>
                                        <td><?=$v['name'];?></td>
                                        <td><?=$v['distance'];?> м.</td>
                                        <td><?=$v['input_people'];?></td>
                                        <td><?=$v['output_people'];?></td>
                                        <td><?=$v['category'];?></td>
                                        <td><?=$v['weight'];?></td>
                                        <td><?=$v['index'];?></td>
                                    </tr>
                                    <?endforeach;?>
                                    
                                    <tr>
                                        <td colspan="6" style="text-align: right;"><strong>Итоговый индекс:</strong></td>
                                        <td>
                                        <span class="badge bg-success"><?=$trIndex;?></span>
                                      </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
                <?endif;?>
                
                <?if(!empty($infrastructure)):?>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            Объекты инфраструктуры (<?=count($infrastructure);?> в радиусе <?=$radius1;?> м.)
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Адрес</th>
                                        <th>Широта</th>
                                        <th>Долгота</th>
                                        <th>Расстояние</th>
                                        <th>Категория</th>
                                        <th>Вес</th>
                                        <th>Индекс инфраструктуры</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?foreach($infrastructure as $k=>$v):?>
                                    <tr>
                                        <td><?=$v['address'];?></td>
                                        <td><?=$v['lat'];?></td>
                                        <td><?=$v['lng'];?></td>
                                        <td><?=$v['distance'];?> м.</td>
                                        <td><?=$v['category'];?></td>
                                        <td><?=$v['weight'];?></td>
                                        <td><?=$v['index'];?></td>
                                    </tr>
                                    <?endforeach;?>
                                    
                                    <tr>
                                        <td colspan="6" style="text-align: right;"><strong>Итоговый индекс:</strong></td>
                                        <td>
                                        <span class="badge bg-success"><?=$infIndex;?></span>
                                      </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
                <?endif;?>
                
                
                <?if(!empty($postamats)):?>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            Постоматы конкурентов (<?=count($postamats);?> в радиусе <?=$radius1;?> м.)
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Наименование</th>
                                        <th>Адрес</th>
                                        <th>Широта</th>
                                        <th>Долгота</th>
                                        <th>Расстояние</th>
                                        <th>Вес</th>
                                        <th>Индекс</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?foreach($postamats as $k=>$v):?>
                                    <tr>
                                        <td><?=$v['name'];?></td>
                                        <td><?=$v['address'];?></td>
                                        <td><?=$v['lat'];?></td>
                                        <td><?=$v['lng'];?></td>
                                        <td><?=$v['distance'];?> м.</td>
                                        <td><?=$v['weight'];?></td>
                                        <td><?=$v['index'];?></td>
                                    </tr>
                                    <?endforeach;?>
                                    
                                    <tr>
                                        <td colspan="6" style="text-align: right;"><strong>Итоговый индекс:</strong></td>
                                        <td>
                                        <span class="badge bg-success"><?=$comIndex;?></span>
                                      </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
                <?endif;?>
                
                <?if(!empty($houses)):?>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            Население (проживает <?=$peoples_all;?> чел. в радиусе <?=$radius1;?> м.)
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Адрес</th>
                                        <th>Расстояние</th>
                                        <th>Количество квартир</th>
                                        <th>Общ. площадь квартир</th>
                                        <th>Жильцов</th>
                                        <th>Индекс</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?foreach($houses as $k=>$v):?>
                                    <tr>
                                        <td><?=$v['address'];?></td>
                                        <td><?=$v['distance'];?></td>
                                        <td><?=$v['living_quarters_count'];?></td>
                                        <td><?=$v['area_residential'];?></td>
                                        <td><?=$v['peoples'];?></td>
                                        <td><?=$v['index'];?></td>
                                    </tr>
                                    <?endforeach;?>
                                    
                                    <tr>
                                      <td colspan="5" style="text-align: right;"><strong>Итоговый индекс:</strong></td>
                                      <td>
                                        <span class="badge bg-success"><?=$peopleIndex;?></span>
                                      </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>
                <?endif;?>
                
                <section class="section">
                  <div class="row">
                    <div class="col-md-12">
                      <iframe src="https://datalens.yandex/wdj5knnln7omn?model_id=<?=$postomat[0]['model_id'];?>&sq_diametr=<?=$postomat[0]['SQ_DIAMETR'];?>&SQ_ID=<?=$postomat[0]['SQ_ID'];?>" width="100%" height="400"></iframe>
                    </div>
                  </div>
                </section>
                <br />
                <br />
                <section class="section">
                  <div class="row">
                    <div class="col-md-7">
                       <iframe style="margin-top: -40px;" src="https://datalens.yandex/yfg5anfd7ufyp?model_id=<?=$postomat[0]['model_id'];?>&district_id=<?=$postomat[0]['district_id'];?>&sq_diametr=<?=$postomat[0]['SQ_DIAMETR'];?>" width="100%" height="500" frameborder="0"></iframe>
                    </div>
                    
                    <div class="col-md-5">
                        <iframe style="margin-top: -40px;" src="https://datalens.yandex/7oqutm4t1cs8y?model_id=<?=$postomat[0]['model_id'];?>&district_id=<?=$postomat[0]['district_id'];?>&sq_diametr=<?=$postomat[0]['SQ_DIAMETR'];?>" width="100%" height="500" frameborder="0"></iframe>
                    </div>
                  
                  </div>
                </section>
            </div>
