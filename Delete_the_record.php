<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">

<!-- header part -->
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css">
<meta http-equiv="Content-Script-Type" content="text/javascript">
    
<meta name="keywords" content="キーワード1,キーワード2,キーワード3">
<meta name="description" content="このページに関する簡単な説明。">    
    
<title>message board software</title>

<link href="css/style.css" rel="stylesheet" type="text/css" />

</head>

<!-- body part -->
<body>

<!-- データ取得領域 -->
<?php
    // セッションスタート
    session_start() ;

    // DB読み込みクラス
    include("data_access_class.php");
    
    // 全データ読み込み処理
    $inst2 = new data_access_class();
    
    // データ書き込み
    $message_id = htmlspecialchars($_REQUEST['message_id']);
    $inst2->removeAData($message_id);

?>

<!-- ヘッダ開始 -->
<div id="header">

<div class="top">
<div class="container">

<p class="siteTitle"><strong><a href="index.php"><img src="image/site_title.gif" alt="サイトのタイトル" width="229" height="27"></a></strong></p>

<p class="catch"><strong>PHPやHTMLの学習用に作成しました（第一弾）。</strong></p>

<ul class="guide">
<li class="first"><a href="#">FAQ</a></li>
</ul>

</div>
</div>

<div class="nl">
<div class="container">

<ul class="clearFix">
<li><a href="index.php">ホーム <span class="en">Home</span></a></li>
<li class="active"><a href="index.php">書き込み <span class="en">Write</span></a></li>
<li class="last"><a href="session_check.php">ログ確認 <span class="en">Log</span></a></li>
</ul>

</div>
</div>

<div class="topicPath">
<div class="container">

<ol>
<li><a href="index.php">ホーム</a></li>
<li>書き込み</li>
</ol>

</div>
</div>

<hr class="none">

</div>
<!-- ヘッダ終了 -->


<!-- コンテンツ開始 -->
<div id="content">

<div class="container">


<!-- メインカラム開始 -->
<div id="main">

<?php
    // H.Yamamoto add for message board on July 21, 2014.
    echo '<h1 class="pageTitle">削除を実行しました。</h1>';
    echo '<div class="section emphasis">' ;
    echo '<div class="inner">' ;
   
    echo '<form method="get" action="index.php" >';
    echo '<input type="submit" value="更新" />';
    echo '</form>';
    echo '</div>';
    echo '</div>';
?>

</div>

<div>

</div>

<!-- メインカラム終了 -->

<!-- サイドバー開始 -->
<div id="nav">

<div class="section emphasis">

<?php
    if(!isset($_SESSION['login_id'])) {
        echo '<h2>' . $_SERVER["REMOTE_ADDR"] . '</h2>';
    }
    else {
        echo '<h2>' . $_SESSION['login_id'] . '</h2>';
    }
    echo '<p>ログイン開始：'. date('G\:i\:s \(l\)') .'</p>';
    echo '<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp日：'. date("F j, Y") .'</p>';
?>

</div>


<div class="section normal contact">

<h2>お問い合わせ</h2>

<p>お気軽にお問い合わせください。</p>

<p class="tel"><a href="telto:011-xxx-xxxx">Tel 011-xxx-xxxx<br />(要電話)</a></p>

<p>営業時間 平日 9:00～18:00<br>（定休日 土日祝）</p>

<p class="form"><a href="mailto:xxxxx@xxx.xx-net.ne.jp?subject=問い合わせ&amp;body=ご記入ください">メールはこちらへ</a></p>

</div>

<!-- 後でちゃんとclass作ろうね -->
<div class="section normal contact">

<h2>おもしろニュース</h2>

<a href="http://www.lifehacker.jp/" ><img src="image/media_lifehacker.jpg" width="214" height="133" align="center"></img></a>
   
<?php
    $xmlTree = simplexml_load_file('http://feeds.lifehacker.jp/rss/lifehacker/index.xml');
    
    print('<div >&nbsp</div>');
    
    foreach($xmlTree->channel->item as $item) {
        print('<div><a href="'. $item->link . '">'. $item->title . '</a></div>');
        print('<div >&nbsp</div>');
    }
?>

</div>


</div>
<!-- サイドバー終了 -->

<hr class="clear">

</div>

</div>




<!-- コンテンツ終了 -->


<!-- フッタ開始 -->
<div id="footer">

<div class="container">

<ul class="nl">
<li class="first"><a href="index.php">ホーム</a></li>
<li><a href="#">お問い合わせ</a></li>
</ul>

<ul class="nl guide">
<li class="first"><a href="#">FAQ</a></li>
</ul>

<address>
<strong>Message board</strong>
<br>
札幌市 TEL 011-xxx-xxxx
<br>
Copyright (C) 2014 Hidekatsu Yamamoto. All Rights Reserved.
</address>

</div>

<!-- データベース終了処理 -->
<?php
    // データベース解放
    $inst2->releaseDB();
    
?>

</div>
<!-- フッタ終了 -->

</body>
</html>