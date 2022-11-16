<div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <div class="d-flex justify-content-between">
                        <div class="logo">
                            <a href="/admin/">
                            <img src="<?=DOMAIN;?>/admin/themplate/dist/assets/images/logo/post1.png" alt="Logo" srcset="" style="height: 100px; margin-left: 5px;">
                            </a>
                        </div>
                        <div class="toggler">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <!-- <li class="sidebar-title">Menu</li> -->
                        
                        <li class="sidebar-item <?if($xc['module']=='dashbord'):?>active<?endif?><?if($mapsMenu!=false):?> has-sub<?endif;?>">
                        <a href="/admin/dashbord" class='sidebar-link'>
                           <i class="bi bi-stack"></i>
                           <span>Дашборд</span>
                        </a>
                          
                          <?if($mapsMenu!=false):?>
                          <ul class="submenu ">
                            <?foreach($mapsMenu as $m):?>
                            <li class="submenu-item">
                              <a href="/admin/dashbord/<?=$m['pagename'];?>"><?=$m['title'];?></a>
                            </li>
                            <?endforeach;?>
                          </ul>
                          <?endif;?>
                        </li>
                        
                        <li class="sidebar-item <?if($xc['module']=='main'):?>active<?endif?>">
                            <a href="/admin/map2" class='sidebar-link'>
                                <i class="bi bi-map-fill"></i>
                                <span>Карта</span>
                            </a>
                        </li>
                        
                        
                         <li class="sidebar-item <?if($xc['module']=='data'):?>active<?endif?><?if($dataList!=false):?> has-sub<?endif;?>">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-file-earmark-spreadsheet-fill"></i>
                                <span>Данные</span>
                            </a>
                             <?if($dataList!=false):?>
                             <ul class="submenu">
                               <?foreach($dataList as $d):?>
                                <li class="submenu-item ">
                                    <a href="/admin/data/<?=$d['pagename'];?>"><?=$d['title'];?></a>
                                </li>
                               <?endforeach;?>
                            </ul>
                            <?endif;?>
                        </li>
                        
                        <li class="sidebar-item <?if($xc['module']=='postomat' && ($_GET['com']=='category' || $_GET['com']=='generate' || $_GET['com']=='constants')):?>active<?endif?> has-sub">
                            <a href="index.html" class='sidebar-link'>
                                <i class="bi bi-pen-fill"></i>
                                <span>Настройки модели</span>
                            </a>
                             
                             <ul class="submenu">
                                <li class="submenu-item ">
                                    <a href="/admin/postomat/category">Категории</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="/admin/postomat/generate">Веса функций</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="/admin/postomat/constants">Константы</a>
                                </li>
                            </ul>
                            
                        </li>

                        <li class="sidebar-item <?if($xc['module']=='api'):?>active<?endif?>">
                            <a href="/admin/api/visual" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>API</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="https://docs.google.com/document/d/10rtYZ67qmT0E_riW1j-xUlto0DB6dKDQx6Pi_ibhE7I/edit#heading=h.3a2et3tot2yk" target="_blank" class='sidebar-link'>
                                <i class="bi bi-life-preserver"></i>
                                <span>Документация</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-item <?if($xc['module']=='presentation'):?>active<?endif?>">
                            <a href="/admin/presentation" class='sidebar-link'>
                                <i class="bi bi-image-fill"></i>
                                <span>Презентация</span>
                            </a>
                        </li>
                        
                        <li class="sidebar-item">
                            <a href="https://github.com/Garbuzenko/code_postamap" class='sidebar-link' target="_blank">
                                <i class="bi bi-puzzle"></i>
                                <span>Github</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>