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

    // Cache Clear
    clearstatcache();

    // DB読み込みクラス
    include("data_access_class.php");
    
    // 全データ読み込み処理
    $message_id = $_REQUEST['message_id'];
    $inst2 = new data_access_class();
    $inst2->getSelectedData($message_id);
    
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

<?php
    // H.Yamamoto add for message board on July 21, 2014.
    $data = $inst2->getOneData();
?>

<div id="main">

<h1 class="pageTitle">Put your message.</h1>
<form method="post" action="Update_the_record.php" enctype="multipart/form-data" >
    <div class="section emphasis">
        <div class="inner">
            <dl>
                <dt>■名前</dt>
                <dd><input type="hidden" name="message_id" value="<?php echo $data['message_id']; ?>" /></dd>
                <dd><input type="text" name="inputted_name" size="30" autocomplete="on" list="keywords" value="<?php echo $data['author']; ?>"/>
                    <datalist id="keywords">
                    <?php
                        foreach ($inst2->getAllDataOnceByUseOfYield("messages") as $name) {
                            echo '<option value="' . $name . '">' . $name . '</option>';
                        }
                    ?>
                    </datalist>
                </dd>
            </dl>
            <dl>
                <dt>■メッセージ</dt>
                <dd><input type="text" name="inputted_message" size="60" value="<?php echo $data['body_text']; ?>"/></dd>
            </dl>
            
            <dl>
                <dt>■ピクチャ</dt>
                <dd><input type="file" name="favorite_picture" id="favorite_picture" size="50" /></dd>
            </dl>  
            
        </div>
        <input type="submit" value="送信" />
    </div>
</form>

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

</div>
<!-- フッタ終了 -->

<!-- データベース終了処理 -->
<?php
    // データベース解放
    $inst2->releaseDB();
    
?>
</body>
</html>