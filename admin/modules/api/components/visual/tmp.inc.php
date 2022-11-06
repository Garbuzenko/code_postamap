<div class="page-heading">
  <div class="page-title">
     <div class="row">
       <div class="col-12 col-md-6 order-md-1 order-last">
          <h3>API. Документация.</h3>
       </div>
     </div>
  </div>
  
  <section class="section">
    <div class="card">
      <div class="card-body" style="overflow-x: auto;">
        
        <p><strong>Метод для получения списка административных округов</strong></p>
        <strong><a href="https://postamap.ru/admin/api?adm_area=list" target="blank">https://postamap.ru/admin/api?adm_area=list</a></strong>
        <p>Выдаёт список административных округов с их ID в формате JSON</p>
        
        <p><strong>Метод для получения списка районов</strong></p>
        <strong><a href="https://postamap.ru/admin/api?district=list" target="blank">https://postamap.ru/admin/api?district=list</a></strong>
        <p>Выдаёт список районов с их ID в формате JSON</p>
        
        <p><strong>Метод для получения списка допустимых диаметров</strong></p>
        <strong><a href="https://postamap.ru/admin/api?diametr=list" target="blank">https://postamap.ru/admin/api?diametr=list</a></strong>
        <p>Выдаёт список допустимых диаметров для рассчёта в формате JSON</p>
        
        <strong><a href="https://postamap.ru/admin/api?diametr=400" target="blank">https://postamap.ru/admin/api?diametr=400</a></strong>
        <p>Пример поиска постоматов в квадратах с длиной стороны 400 м.</p>
        
        <p><strong>Метод для получения списка категорий объектов, в которых можно размещать постоматы</strong></p>
        <strong><a href="https://postamap.ru/admin/api?category=list" target="blank">https://postamap.ru/admin/api?category=list</a></strong>
        <p>Выдаёт список категорий в формате JSON</p>
        
        <strong><a href="https://postamap.ru/admin/api?category=мфц" target="blank">https://postamap.ru/admin/api?category=мфц</a></strong>
        <p>Пример поиска постоматов, оторые можно разместить в МФЦ</p>
        
        <p><strong>Метод для получения списка постоматов по релевантности</strong></p>
        <strong><a href="https://postamap.ru/admin/api?relevance_start=50&relevance_finish=100" target="blank">https://postamap.ru/admin/api?relevance_start=50&relevance_finish=100</a></strong>
        <p>Допустимые значения от 1 до 100</p>
        
        <p><strong>Пример запроса</strong></p>
        <strong><a href="https://postamap.ru/admin/api?adm_area=1-5-8&relevance_start=50&diametr=400" target="blank">https://postamap.ru/admin/api?adm_area=1-5-8&relevance_start=50&diametr=400</a></strong>
        <p>Показывает потенциальные места для размещения постаматов в административных округах 1 (Восточный), 5 (Северный), 8 (Троицкий) с релевантность от 50 процетов в квадратах со сторонами 400 м.</p>
        
      </div>
      
      
  </section>
</div>