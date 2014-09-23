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
    // Class Auto Loader
    include("ClassLoader.php");
    $aaa = new ClassLoader();

    // Cache Clear
    clearstatcache();
?>
<?php
    // 全データ読み込み処理
    $instDac = new \HideSample\MessageBoard\DataAccessClass();
    
    // データ書き込み
    $body_text   = htmlspecialchars($_REQUEST['inputted_message']);
    $name        = htmlspecialchars($_REQUEST['inputted_name']);
    $message_id  = htmlspecialchars($_REQUEST['message_id']);
    $filePath    = null ;
        
    // uploaded file
    $file = $_FILES['favorite_picture'];

    // Do they have uploded file?
    if(!empty($file['name'])){
        
        // check the kind of file
        $fileType = substr($file['name'] , -4);
        $fileType_lower = strtolower($fileType);
        
        if( $fileType_lower == '.gif' || $fileType_lower == '.jpg' ||
            $fileType_lower == '.png'  ) {
            
            // make the file path to keep the picture.
            $filePath = './pictures/'. $file['name'] ;
            
            move_uploaded_file($file['tmp_name'], $filePath);
        }
    }    
    $instDac->updateAData($message_id, $body_text, $name, $filePath);
?>

<!-- ヘッダ開始 -->
<div id="header">

<div class="top">
<div class="container">

<p class="siteTitle"><strong><a href="index.php"><img src="image/logo.png" alt="サイトのタイトル" width="229" height="27"></a></strong></p>

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
    echo '<h1 class="pageTitle">更新を受け付けました。</h1>';
    echo '<div class="section emphasis">' ;
    echo '<div class="inner">' ;
   
    echo '<form method="get" action="index.php" >';
    echo '<input type="submit" value="更新" />';
    echo '</form>';
    echo '</div>';
    echo '</div>';
?>

</div>

<!-- メインカラム終了 -->

<!-- サイドバー開始 -->
<div id="nav">

<div class="section emphasis">

<!-- Session Information(Login User) -->
<?php
    // ProvideSessionInformationClass launches session_start on __construct. 
    // and getUserName() makes some following message.
    // <h2> Ip address or Session Name </h2>
    // <p>  Login started time </p>
    $instPSI = new \HideSample\MessageBoard\ProvideSessionInformation();
    $ValueForDisplay = $instPSI->getUserName() ;
    echo $ValueForDisplay;
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
    $instDac->releaseDB();
    
?>

</div>
<!-- フッタ終了 -->

</body>
</html>