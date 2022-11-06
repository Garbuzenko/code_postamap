<div id="map" style="width: 100%; height: 800px;"></div>
        

<script>

    ymaps.ready(function () {

        // создаем яндекс-карту с координатами центра Москвы
        var myMap = new ymaps.Map('map', {
            center: [55.751574, 37.573856],
            zoom: 9,
            controls: ['zoomControl', 'searchControl']
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
        myMap.setBounds(polygon.geometry.getBounds());
        <?$i++; endforeach;?>
        
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
          
          
          // Создадим пункты выпадающего списка.
          var selectedStatus = true;
          
          var listBoxItems = ['Постомат','Инфраструктура','Активность','Транспорт']
            .map(function (title) {
                
                if (title == '<?if ($postomatsObj == true):?>Постомат<?else:?>Инфраструктура<?endif;?>') {
                    selectedStatus = true;
                }
                
                else {
                    selectedStatus = false;
                }
                
                return new ymaps.control.ListBoxItem({
                    data: {
                        content: title
                    },
                    state: {
                        selected: selectedStatus
                    }
                })
            }),
        reducer = function (filters, filter) {
            filters[filter.data.get('content')] = filter.isSelected();
            return filters;
        },
 
        
        
        // Теперь создадим список, содержащий 5 пунктов.
        listBoxControl = new ymaps.control.ListBox({
            data: {
                content: 'Фильтр',
                title: 'Фильтр'
            },
            items: listBoxItems,
            state: {
                // Признак, развернут ли список.
                expanded: true,
                filters: listBoxItems.reduce(reducer, {})
            }
        });
    
    myMap.controls.add(listBoxControl);
    
    <?if($postomatsObj==true):?>
    objectManager.setFilter('properties.type == "postomat"');
    <?else:?>
    objectManager.setFilter('properties.type == "infrastructure"');
    <?endif;?>

    // Добавим отслеживание изменения признака, выбран ли пункт списка.
    listBoxControl.events.add(['select', 'deselect'], function (e) {
        var listBoxItem = e.get('target');
        var filters = ymaps.util.extend({}, listBoxControl.state.get('filters'));
        filters[listBoxItem.data.get('content')] = listBoxItem.isSelected();
        listBoxControl.state.set('filters', filters);
    });

    var filterMonitor = new ymaps.Monitor(listBoxControl.state);
    filterMonitor.add('filters', function (filters) {
        // Применим фильтр.
        objectManager.setFilter(getFilterFunction(filters));
    });

    function getFilterFunction(categories) {
        return function (obj) {
            var content = obj.properties.balloonContent;
            return categories[content]
        }
    }

    $.ajax({
        url: "/admin/modules/main/components/map/files/<?=$dataJson;?>"
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
                    content: 'Население',
                    image: '/admin/modules/main/components/map/img/heatmap_icon.png'
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
                <?$i = 0; foreach ($mos_realty as $b):?>
                    {
                        id: 'id<?=$b['id']?>',
                        type: 'Feature',
                        geometry: {
                            type: 'Point',
                            coordinates: [<?=$b['lat']?>, <?=$b['lng']?>]
                        },
                        properties: {
                            weight: <?=$b['area_residential']?>
                        }
                    }<?if (count($mos_realty) > $i):?>,<?endif;?>
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
            radiuses = [5, 10, 20, 30],
            opacities = [0.4, 0.6, 0.8, 1];

            // создаем тепловую карту
            var heatmap = new Heatmap(heatmap_data,
             {
                gradient: gradients[0],
                radius: radiuses[2],
                opacity: opacities[2],
                dissipating: false
            });

            // создаем событие нажатия на кнопку "Плотность населения" для отображения тепловой карты
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

});
</script>