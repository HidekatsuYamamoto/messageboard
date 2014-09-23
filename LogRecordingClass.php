<?php
    namespace HideSample\MessageBoard;

    class LogRecordingClass
    {
        const LOG_FILE = 'access_log.txt';
        
        // コンストラクタ
        function __construct()
        {
        }
        
        // 追加メソッド
        function writeALogDown($textForWriteDown)
        {
            $creationData = date('Y-m-d H-i-s');

            // IPアドレスを取得して変数にセットする
            $ipAddress = $_SERVER["REMOTE_ADDR"];

            $GeneratedText = $creationData . '<divide>-' . $ipAddress . '-<divide>[' . $textForWriteDown . ']' ."\n";
            return (file_put_contents(Self::LOG_FILE, $GeneratedText, FILE_APPEND | LOCK_EX));
        }
        
        // method for reading
        function readAllRecord()
        {
            $data_array = file(Self::LOG_FILE);
            if( $data_array === false ) {
                writeALogDown("readAllRecord() is wrong.");
                return $data_array = array();
            }
            return $data_array;
        }
        
        // デストラクタ
        function __destruct()
        {
        }
    }