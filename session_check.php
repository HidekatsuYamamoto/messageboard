<?php
    // セッションチェック用スクリプト
    // セッションスタート
    session_start() ;
    
    // セッション確認
    if(isset($_SESSION['login_id'])) {
        // セッションが既に存在する。
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'log_check.php';

        header("Location: http://$host$uri/$extra");
    }
    else {
        // セッションがありませんので、
        // ログイン画面に遷移します。
        session_unset();
        
        /* カレントディレクトリの別のページにリダイレクトします */
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'login.php';

        header("Location: http://$host$uri/$extra");
        //exit;
    }