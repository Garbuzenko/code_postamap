<?php

// достаём список моделей рассчёта из базы
$models = db_query("SELECT id, name FROM mln_model");

// список факторов
$factors = db_query("SELECT factor_id, factor 
 FROM mln_factor_weight 
 WHERE factor_id!=0 
 GROUP BY factor_id 
 ORDER BY factor_id");