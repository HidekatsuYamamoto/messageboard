<?php
namespace HideSample\MessageBoard;

?>
<?php

// ProvideSessionInformationClass launches session_start on __construct. 
class ProvideSessionInformation
{
        // コンストラクタ
        function __construct()
        {
            // セッションスタート
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
        }

        // getUserName() makes some following message.
        // <h2> Ip address or Session Name </h2>
        // <p>  Login started time </p>
        public function getUserName()
        {
            if(!isset($_SESSION['login_id'])) {
                $returnValue = '<h2>' . $_SERVER["REMOTE_ADDR"] . '</h2>' . "\n";
            }
            else {
                $returnValue = '<h2>' . $_SESSION['login_id'] . '</h2>' . "\n";
            }
            $returnValue .= '<p>ログイン開始：'. date('G\:i\:s \(l\)') .'</p>' . "\n";
            $returnValue .= '<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp日：'. date("F j, Y") .'</p>' . "\n";
            return $returnValue ;
        }
}
