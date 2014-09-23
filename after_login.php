<!-- データ取得領域 -->
<?php
    // Class Auto Loader
    include("ClassLoader.php");
    $aaa = new ClassLoader();

?>
<?php
    // 全データ読み込み処理
    $instDac = new \HideSample\MessageBoard\DataAccessClass();
    
    // データ取得
    $loginId = htmlspecialchars($_REQUEST['inputted_ID']);
    $password= htmlspecialchars($_REQUEST['inputted_password']);
    
    // 本当はここで照合ロジックが動く。
    // DBを見てあっているの？あっていないの？
    
    // セッションスタート
    session_start() ;
    
    // セッション登録
    if(isset($_POST['inputted_ID']) and isset($_POST['inputted_password'])) {
        $_SESSION['login_id'] = htmlspecialchars($_POST['inputted_ID']) ; 
                                // . htmlspecialchars($_POST['inputted_password']);
    }
    else {
        // ログインデータがありませんので、
        // ログイン画面に戻ります。
        session_unset();
        
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'login.php';
        header("Location: http://$host$uri/$extra");
    }
    
    // データが無いのでログイン画面に戻ります。
    if( empty($_POST['inputted_ID']) or empty($_POST['inputted_password'])) {
        session_unset();
        
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'login.php';
        header("Location: http://$host$uri/$extra");
    }
    
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'session_check.php';
    header("Location: http://$host$uri/$extra");