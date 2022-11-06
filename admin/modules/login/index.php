<?php defined('DOMAIN') or exit(header('Location: /'));

$xc['complex_del'] = 0;

// выход из админки
if (!empty($_POST['exit']) or !empty($xc['url']['exit'])) {
    $a = db_query("UPDATE nov_users  
    SET hash='' 
    WHERE id='" . intval($_SESSION['user_id']) ."' 
    LIMIT 1", "u");
    
    setcookie("hash", "", time() - 9999999, "/");
    session_destroy();
    
    exit(header('Location: '.DOMAIN.'/admin/login'));
}
// ---------------------------------------------------------------------------------------------------------------
    
// автоматическая авторизация
if (!empty($_COOKIE["hash"])) {

    $hash = clearData($_COOKIE['hash'], 'guid');
    $loginMess = 'Вам нужно авторизоваться';

    $login = db_query("SELECT id,
    group_id,
    first_name,
    last_name,
    avatar_preview,
    office_id,
    telegram_id,
    complex_del 
    FROM nov_users  
    WHERE hash='".$hash."' 
    AND `del`=0  
    LIMIT 1");

    if ($login != false) {
        
        $xc['complex_del'] = $login[0]['complex_del'];
        
        $_SESSION['user_id'] = $login[0]['id'];
        $_SESSION['telegram_id'] = $login[0]['telegram_id'];
        $_SESSION['office_id'] = $login[0]['office_id'];
        $_SESSION['group_id'] = $login[0]['group_id'];
        
        // имя пользователя
        $_SESSION['name'] = null;
        
        if (!empty($login[0]['first_name'])) {
           $_SESSION['name'] = $login[0]['first_name'].' ';
        }
        
        if (!empty($login[0]['last_name'])) {
            $_SESSION['name'] .= $login[0]['last_name'];
        }
        // --------------------------------------------------------------
        
        // аватар
        $_SESSION['avatar'] = DOMAIN.'/admin/img/users/no_avatar.png';
        
        if (!empty($login[0]['avatar_preview']) && file_exists($_SERVER['DOCUMENT_ROOT'].$login[0]['avatar_preview'])) {
            $_SESSION['avatar'] = DOMAIN.$login[0]['avatar_preview'];
        }
        // --------------------------------------------------------------
    } 
        
    else {
        
       if (isset($_POST['action']) && $_POST['action'] == 'ajax') {
           $html = popup_window($loginMess); 
           exit($html);
       } 
        
        else {
          $xc['module'] = 'login';
          $xc['component'] = null;
        }
    }
} 

else {
    
    if (isset($_POST['action']) && $_POST['action'] == 'ajax') {
        $html = popup_window($loginMess); 
        exit($html);
    } 
    
    else {
        $xc['module'] = 'login';
        $xc['component'] = null;
    }
}
// ---------------------------------------------------------------------------------------------------------------

?>