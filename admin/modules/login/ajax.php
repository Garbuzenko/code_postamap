<?php defined('DOMAIN') or exit(header('Location: /'));

// авторизация
if (isset($_POST['form_id']) && $_POST['form_id'] == 'form_signIn') {
   
    $remember = 0;
    $email = clearData($_POST['login']);
    $pass = encrypt_pass(trim($_POST['pass']));
    $url = $_POST['url'];
    
    if (isset($_POST['remember']))
      $remember = intval($_POST['remember']);
    
    $a = db_query("SELECT id 
    FROM nov_users 
    WHERE `login`='".$email."' 
    AND `pass`='".$pass."' 
    AND `group_id`=1 
    AND `del`=0 
    LIMIT 1");
    
    if ( $a == false ) {
        $html = popup_window('Неправильный логин или пароль'); 
        exit($html);
    }
    
    $hash = get_hash($email);
   
    $b = db_query("UPDATE nov_users    
    SET hash='" . $hash . "' 
    WHERE id=" . $a[0]['id'], "u");
    
    if (empty($remember))
       setcookie('hash', $hash, time() + 3600 * 12, '/');
       
    else
      setcookie('hash', $hash, time() + 3600 * 24 * 30, '/');
    
    if (preg_match('/login/',$url))
      $url = '/admin/';
    
    $r = json_encode( array( 0 => 'redirect', 1 => DOMAIN.$url ) );
    exit($r);
    
}