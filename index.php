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

<script type="text/javascript" src="resource/lightbox_plus.js"></script>

</head>

<!-- body part -->
<body>

<!-- データ取得領域 -->
<?php
    // Cache Clear
    clearstatcache();
    
    // セッションスタート
    session_start() ;

    // check cookie data
    // Page Counter from Cookie is only set when the user pushed specific button.
    // The button is that go to next page.
    if(!empty($_REQUEST['pageToForward'])) {
        $viewingPage = $_REQUEST['pageToForward'] + 1;
    }
    else if(!empty($_REQUEST['pageToBackward'])) {
        $viewingPage = $_REQUEST['pageToBackward'] - 1;
        if($viewingPage < 1)
            $viewingPage = 1;
    }
    else {
        $viewingPage = 1 ;
    }
    
    // DB読み込みクラス
    include("data_access_class.php");
    
    // 全データ読み込み処理
    $inst2 = new data_access_class();
    $inst2->getAllData($viewingPage);
    
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
   
<!-- Input Field -->    
<h1 class="pageTitle">Put your message.</h1>
<form method="post" action="after_index.php" enctype="multipart/form-data" >
    <div class="section emphasis">
        <div class="inner">
            <dl>
                <dt>■名前</dt>
                <dd><input type="text" name="inputted_name" size="30" autocomplete="on" list="keywords"/>
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
                <dd><input type="text" name="inputted_message" size="60" value="Please enter your message."/></dd>
            </dl>
            
            <dl>
                <dt>■ピクチャ</dt>
                <dd><input name="favorite_picture" type="file" id="favorite_picture" size="50"/></dd>
            </dl>  
            
        </div>
        <input type="submit" value="送信" />
    </div>
</form>

<!-- Message Display -->    
<?php
    include("ForThumbnailingPictureClass.php");

    // Done or Nothing
    $sign = false ;
    
    // H.Yamamoto add for message board on July 21, 2014.
    while($data = $inst2->getOneData()) {
        // change the sign
        $sign = true ;
    
        // Should I put a New icon on title?
        $creationTimeStamp = strtotime($data['creation_date']);
        $creationDate      = date("Y-m-d", $creationTimeStamp);
        $todayDate         = date("Y-m-d");
        
        if($creationDate == $todayDate) {
            echo '<h1 class="pageTitle">'. $data['author'] .'さんの書き込みです。<img src="image/newicon.png" style="vertical-align: middle;" /></h1>';
        }
        else {
            echo '<h1 class="pageTitle">'. $data['author'] .'さんの書き込みです。</h1>';
        }
       
        echo '<div class="section emphasis">' ;
        echo '<div class="inner">' ;
        echo '<h2>'. $data['body_text'] . '</h2>' ;
        
        if(!empty($data['pictureInfo'])) {
            list($width,$height) = getimagesize($data['pictureInfo']);

            $inst = new for_thumbnailing_picture_class();

            $conv_width  = $inst->figure_HorizontalSize($width,$height) ;
            $conv_height = $inst->figure_VerticalSize($width,$height) ;

            print('<div align="center">');
            print('<a href="'. $data['pictureInfo'] . '" rel="lightbox">
            <img src="'. $data['pictureInfo'] .'" width="'.$conv_width .'" height="'.$conv_height.'"/>
            </a>');
            print('</div>');            
        }
        
        echo '<p><form method="post" action="Edit_the_record.php" name="etr" align="right">';
        echo '<input type="hidden" name="message_id" value="'. $data['message_id'] . '">';
        echo '<input id="in_you_hands" type="image" src="image/pen_paper_2-512.png" width="12" height="12" alt="Submit" />';
        echo '<label class="text_center" for="in_you_hands">&nbsp更新</label>';
        echo '</form></p>';
        
        echo '<form method="post" action="Delete_the_record.php" name="dtr"  align="right">';
        echo '<input type="hidden" name="message_id" value="'. $data['message_id'] . '">';
        echo '<input id="in_you_eyes" type="image" src="image/cross_icon.jpg" width="12" height="12" alt="Submit" />';
        echo '<label class="text_center" for="in_you_eyes">&nbsp削除</label>';
        echo '</form>';
        
        echo '<p style="text-align: right; background-color:#ffcc99;">'. $data['creation_date'] . '</p>';
        echo '</div>';
        echo '</div>';       
    }
    
    // Page Control and Page Number displays
    if($sign == true) {
        echo '<form method="post" action="index.php" name="lesson" style="float:right;" >';
        echo '<input type="hidden" name="pageToForward" value="' . $viewingPage .'">';
        echo '<input type="image" src="image/1178.png" width="20" height="20" alt="Submit" />';
        echo '</form>';
    }
    
    if($viewingPage > 1 ) {
        echo '<form method="post" action="index.php" name="lesson" style="float:left;" >';
        echo '<input type="hidden" name="pageToBackward" value="' . $viewingPage .'">';
        echo '<input type="image" src="image/1179.png" width="20" height="20" alt="Submit" />';
        echo '</form>';
    }

    echo '<div style="text-align: center; ">Page.' . $viewingPage . '</div>';
    
?>

</div>
<!-- div "main" is end --> 

<!-- Google translate -->
<div id="google_translate_element"></div>
<script>
function googleTranslateElementInit(){
    new google.translate.TranslateElement({pageLanguage: 'ja'}, 'google_translate_element');
}
</script>
<script src="http://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<!-- Google translate is end -->

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