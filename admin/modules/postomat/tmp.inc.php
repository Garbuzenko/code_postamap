<?if($xc['noMainTmp'] == true):?>
<div style="width: 95%; margin: 20px auto;">
<?endif;?>

<div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-12 order-md-1 order-last">
                            <h3><?=$address;?></h3>
                            <?if($xc['noMainTmp'] == false):?>
                            <form method="post" action="" id="form_jsCreatePdf">
                            <input type="hidden" name="module" value="print" />
                            <input type="hidden" name="component" value="" />
                            <input type="hidden" name="ajaxMessage" value="Идёт формирование PDF файла..." />
                            <input type="hidden" name="url" value="<?=DOMAIN;?>/admin/postomat?id=<?=$postomat[0]['id'];?>&print=1" />
                            <button type="button" id="jsCreatePdf" class="send_form mb-3 btn btn-primary">Скачать PDF</button>
                            </form>
                            <?endif;?>
                        </div>
                    </div>
                </div>
                

                 <section class="section">
                   <div class="row">
                     <div class="col-md-3">
                      <div class="card">
                       <div class="card-body">
                         <h4 class="card-title"><span style="font-size: 25px;">&#402;</span> население</h4>
                         <p class="tmpBigText" style="color: #ff3d64;"><?=round($postomat[0]['w_people'],2);?></p>
                       </div>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title"><span style="font-size: 25px;">&#402;</span> инфраструкт-а</h4>
                         <p class="tmpBigText" style="color: #4da2f1;"><?=round($postomat[0]['w_infrastructure'],2);?></p>  
                       </div>
                       </div>
                     </div>
                     <div class="col-md-3">
                      <div class="card">
                        <div class="card-body">
                         <h4 class="card-title"><span style="font-size: 25px;">&#402;</span> транспорт</h4>
                         <p class="tmpBigText" style="color: #be2443;"><?=round($postomat[0]['w_transport'],2);?></p>  
                       </div>
                      </div>
                     </div>
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title"><span style="font-size: 25px;">&#402;</span> конкуренция</h4>
                         <p class="tmpBigText" style="color: #0fa08d;"><?=round($postomat[0]['w_comercial_postsmat'],2);?></p>  
                       </div>
                       </div>
                     </div>
                   </div>
                 </section>
                 
        
                  <section class="section">
                  <div class="row">
                  
                  <div class="col-md-6">
                     <div class="card" style="height: 540px;">
                        <div class="card-header">
                           <h4>Востребованность</h4>
                        </div>
                        <div class="card-body">
                           <div id="radialGradient"></div>
                        </div>
                     </div>
                  </div>
                  
                  <div class="col-md-6">
                     <div class="card" style="height: 540px;">
                        <div class="card-header">
                           <h4>Модель &laquo;<a href="<?=$modelsDoc[ $postomat[0]['model_id'] ]['url'];?>" target="_blank"><?=$modelsDoc[ $postomat[0]['model_id'] ]['name'];?></a>&raquo;</h4>
                        </div>
                        <div class="card-body">
                           <ul class="list-group list-group-flush">
                           
                             <li class="list-group-item">Адм. округ: <strong><?=$postomat[0]['adm_area'];?></strong></li>
                             <li class="list-group-item">Район: <strong><?=$postomat[0]['district'];?></strong></li>
                             <?if(!empty($address)):?>
                             <li class="list-group-item">Адрес: <strong><?=$address;?></strong></li>
                             <?endif;?>
                             <li class="list-group-item">Координаты: <strong><?=$postomat[0]['lat'];?>, <?=$postomat[0]['lng'];?></strong></li>
                             <li class="list-group-item">Радиус: <strong><?=$radius1;?> м.</strong></li>
                             <li class="list-group-item">Приоритет локации размещения: <strong><?=intval($postomat[0]['priority']);?>%</strong></li>
                             <li class="list-group-item">Население: <strong><?=$peoples_all;?> чел.</strong></li>
                             <li class="list-group-item">Количество квартир: <strong><?=$quarters_count_all;?> (<?=$areaResidentialAll;?> м<sup style="font-size: 7px;">2</sup>)</strong></li>
                             <li class="list-group-item">Дневной пассажиропоток: <strong><?=$sumPeopleAll;?> чел.</strong></li>
                             <li class="list-group-item">Объектов инфраструктуры: <strong><?=count($infrastructure);?></strong></li>
                             <li class="list-group-item">Конкуренты: <strong><?=count($postamats);?></strong></li>
                           </ul>
                        </div>
                     </div>
                  </div>
                  
                  <?if(!empty($houses)):?>
                  <div class="col-md-12">
                     <h3>Пешие маршруты в радиусе <?=$radius1;?> м.</h3>
                     <div id="map" style="width: 100%; height: 630px;"></div>
                  </div>
                  <?endif;?>
                  
                  
                </div>
                </section>
                <br />
                
                <?if($xc['noMainTmp'] == false):?>
                <section class="section">
                   <div class="row">
                     <div class="col-md-3">
                      <div class="card">
                       <div class="card-body">
                         <h4 class="card-title">Радиус</h4>
                         <p class="tmpBigText" style="color: #ff3d64; font-size: 35px;"><?=$radius1;?> м.</p>
                       </div>
                       </div>
                     </div>
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Приоритет</h4>
                         <p class="tmpBigText" style="color: #4da2f1; font-size: 35px;"><?=intval($postomat[0]['priority']);?>%</p>  
                       </div>
                       </div>
                     </div>
                     <div class="col-md-3">
                      <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Население</h4>
                         <p class="tmpBigText" style="color: #be2443; font-size: 35px;"><?=$peoples_all;?> ч.</p>  
                       </div>
                      </div>
                     </div>
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Пассажиропоток</h4>
                         <p class="tmpBigText" style="color: #0fa08d; font-size: 35px;"><?=$sumPeopleAll;?> ч.</p>
                       </div>
                       </div>
                     </div>
                     
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Кол-во квартир</h4>
                         <p class="tmpBigText" style="color: #9400D3; font-size: 35px;"><?=$quarters_count_all;?></p>
                       </div>
                       </div>
                     </div>
                     
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Жилая площадь</h4>
                         <p class="tmpBigText" style="color: #D2691E; font-size: 35px;"><?=$areaResidentialAll;?> м<sup style="font-size: 16px;">2</sup></p>
                       </div>
                       </div>
                     </div>
                     
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Объектов инф-ры</h4>
                         <p class="tmpBigText" style="color: #FF69B4; font-size: 35px;"><?=count($infrastructure);?></p>
                       </div>
                       </div>
                     </div>
                     
                     <div class="col-md-3">
                       <div class="card">
                        <div class="card-body">
                         <h4 class="card-title">Конкуренты</h4>
                         <p class="tmpBigText" style="color: #FFD700; font-size: 35px;"><?=count($postamats);?></p>
                       </div>
                       </div>
                     </div>
                     
                   </div>
                 </section>
                 <br />
                 <?endif;?>
                
                <?if($xc['noMainTmp'] == false):?>
                 <section class="section">
                  <div class="row">
                    <div class="col-md-12">
                      <iframe src="https://datalens.yandex/wdj5knnln7omn?model_id=<?=$postomat[0]['model_id'];?>&sq_diametr=<?=$postomat[0]['SQ_DIAMETR'];?>&SQ_ID=<?=$postomat[0]['SQ_ID'];?>" width="100%" height="800"></iframe>
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
                <br />
                <?endif;?>
                
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
                
                <?if($xc['noMainTmp'] == false && MOBILE==false):?>
                 <section class="section">
                  
                    <div class="card" style="padding-bottom: 30px;">
                      <div class="card-header">
                            Деловая активность
                      </div>
                      <div style="overflow: hidden; width: 900px; height: 500px; margin: 0 auto;">
                       <iframe style="margin-left: -500px; margin-top: -180px;" width="1400" height="680" src="https://www.avito.ru/moskva/odezhda_obuv_aksessuary/zhenskaya_odezhda/kupalniki-ASgBAgICAkSmAbpL3gLWCw?cd=1&geoCoords=<?=$lat;?>,<?=$lng;?>&map=e30%3D&radius=1"></iframe>
                     </div>
                    </div>
                  
                 </section>
                 <?endif;?>
                
            </div>

<?if($xc['noMainTmp'] == true):?>
</div>
<?endif;?>