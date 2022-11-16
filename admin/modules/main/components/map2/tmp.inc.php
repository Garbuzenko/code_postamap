
<?if ($ajaxFilter == true && $xc['component']!='components/pdf/'):?>
<div class="row mt-2 mb-2" style="padding-left: 20px;">
  <div class="col-md-2">
  <form method="post" action="" id="form_jsCreatePdf" style="float: left; margin-right: 10px;">
    <input type="hidden" name="module" value="print" />
    <input type="hidden" name="component" value="" />
    <input type="hidden" name="ajaxMessage" value="Идёт формирование PDF файла..." />
    <input type="hidden" name="url" value="<?=DOMAIN;?>/admin/map2/pdf<?=$ajaxUrl;?>" />
    <button class="send_form btn btn-primary btn-sm" id="jsCreatePdf">PDF</button>
  </form>
  
  <form method="post" action="" id="form_jsCreateExcel" style="float: left;">
    <input type="hidden" name="module" value="print" />
    <input type="hidden" name="component" value="excel" />
    <input type="hidden" name="filter" value='<?=$excelData;?>' />
    <input type="hidden" name="alert" value="0" />
    <button class="send_form btn btn-primary btn-sm" id="jsCreateExcel">EXCEL</button>
  </form>
  </div>
  
</div>
<?endif;?>

<div id="map" style="width: 100%; height: <?if($xc['component']=='components/pdf/'):?>900<?else:?>800<?endif;?>px;"></div>
        

<script>

    ymaps.ready(function () {

        // создаем яндекс-карту с координатами центра Москвы
        var myMap = new ymaps.Map('map', {
            center: [55.75026, 37.6147],
            zoom: 9,
            controls: ['zoomControl']
        }, {
            searchControlProvider: 'yandex#search'
        }),
        
           
        polygon = null;

        // добавляем полигоны районов Москвы
        <?$i = 0; foreach ($districtVisible as $b):?>
        polygon = new ymaps.Polygon(<?=$b['polygons']?>, {
            hintContent: "<?=str_replace('"', '', $b['district'])?>"
        }, {
            fillColor: '#6699ff',
            interactivityModel: 'default#transparent',
            strokeWidth: 1,
            opacity: 0.2
        });
        myMap.geoObjects.add(polygon);
        //myMap.setBounds(polygon.geometry.getBounds());
        <?$i++; endforeach;?>
        
          <?if($ajaxFilter == true):?>
          polygon2 = null;

          // добавляем полигоны Квадратов
          <?foreach ($sq_polygons as $k=>$b):?>
          polygon2 = new ymaps.Polygon(<?=$b['polygon']?>, {
             hintContent: "<?=$b['descr'];?>"
          }, {
            fillColor: '#F4A460',
            interactivityModel: 'default#transparent',
            strokeWidth: 2,
            opacity: 0.4
          });
          myMap.geoObjects.add(polygon2);
         <?endforeach;?>
         <?endif;?>
        
        <?if ($filter == true):?>
        
          // добавляем метки с координатами объектов инфраструктуры
          objectManager = new ymaps.ObjectManager({
            // Чтобы метки начали кластеризоваться, выставляем опцию.
            clusterize: true,
            // ObjectManager принимает те же опции, что и кластеризатор.
            gridSize: 32,
            clusterDisableClickZoom: false,
            clusterIconLayout: "default#pieChart"
          });
         
          myMap.geoObjects.add(objectManager);
          

         $.ajax({
           url: "/admin/modules/main/components/map2/files/<?=$dataJson;?>"
         }).done(function (data) {
        
             objectManager.add(data);
        
             myMap.setBounds(objectManager.getBounds(), {
               checkZoomRange: true
             });
          });
          
           

        // добавляем кнопки на карту
        buttons = {
            heatmap: new ymaps.control.Button({
                data: {
                    content: 'Тепловая карта',
                    image: '/admin/modules/main/components/map2/img/heatmap_icon.png'
                },
                options: {
                    selectOnClick: true,
                    maxWidth: 250,
                    size: 'large'
                }
            })

        };
        
         // подключаем модуль тепловой карты
        ymaps.modules.require(['Heatmap'], function (Heatmap) {

            // загружаем в массив javascript из php-массива $mos_realty данные о плотности населения
            heatmap_data = {
                type: 'FeatureCollection',
                features: [
                <?$i = 0; foreach ($postamats as $b):?>
                    {
                        id: 'id<?=$b['id']?>',
                        type: 'Feature',
                        geometry: {
                            type: 'Point',
                            coordinates: [<?=$b['lat']?>, <?=$b['lng']?>]
                        },
                        properties: {
                            weight: <?=$b['w_relevance']?>
                        }
                    }<?if (count($postamats) > $i):?>,<?endif;?>
                <?$i++; endforeach;?>
                ]
            };

            gradients = [{
                0.1: 'rgba(128, 255, 0, 0.7)',
                0.2: 'rgba(255, 255, 0, 0.8)',
                0.7: 'rgba(234, 72, 58, 0.9)',
                1.0: 'rgba(162, 36, 25, 1)'
            }, {
                0.1: 'rgba(162, 36, 25, 0.7)',
                0.2: 'rgba(234, 72, 58, 0.8)',
                0.7: 'rgba(255, 255, 0, 0.9)',
                1.0: 'rgba(128, 255, 0, 1)'
            }],
            radiuses = [20, 40, 80, 160],
            opacities = [0.4, 0.6, 0.8, 1];

            // создаем тепловую карту
            var heatmap = new Heatmap(heatmap_data,
             {
                gradient: gradients[0],
                radius: radiuses[2],
                opacity: opacities[2],
                dissipating: false
            });

            // создаем событие нажатия на кнопку "Тепловая карта" для отображения тепловой карты
            buttons.heatmap.events.add('press', function () {
                heatmap.setMap(
                    heatmap.getMap() ? null : myMap
                );
            });
            
            
 
            // добавляем на карту созданные кнопки
            for (var key in buttons) {
                if (buttons.hasOwnProperty(key)) {
                    myMap.controls.add(buttons[key]);
                }
            }

        });
        
        <?endif;?>
});


</script>