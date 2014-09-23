<?php
    namespace HideSample\MessageBoard;

    // WriteALogDown
    include("LogRecordingClass.php");
?>
<?php
    class DataAccessClass
    {
        private $con;
        private $result;
        private $log;
        
        // コンストラクタ
        function __construct()
        {
            //echo "コンストラクタが実行されました<br /><br />";
            
            //1. MySQLに接続し、データベースを選択する
            $this->con = new \mysqli('127.0.0.1', 'xxxx', 'xxxx','messageboard');
            if (!$this->con) {
               // exit('データベースに接続できませんでした。<br /><br />');
            }
            //echo "DBがオープンされました<br /><br />";
        

            //2. SQLの内部文字エンコーディングををUTF-8に変更する
            mb_internal_encoding("UTF-8");
            
            //3. SQLを実行する
            $result = mysqli_query($this->con, 'SET NAMES utf8');
            if (!$result)
                exit('文字コードを指定できませんでした。');
            
            $this->log = new \HideSample\MessageBoard\LogRecordingClass();
        }
        
        // 取得メソッド
        function getAllData($page)
        {
            $start = ($page - 1) * 5 ; // Data is selected from 1,5,10,15.
            
            $sql_statement = sprintf('SELECT * FROM messages ORDER BY creation_date DESC LIMIT %d ,5',$start);
            
            $this->result = mysqli_query($this->con, $sql_statement);
            if (!$this->result) {
                exit('セレクト失敗');
            }
        }

        // 取得メソッド
        // わすれるとおもうのでコメント
        // データの取り出しは別途result領域よりgetOneDataメソッドより
        // 取り出す方法で統一するので、ここのメソッドや、
        // getAllDataメソッドでは
        // いかに、result領域にデータを入れるまでしか責務をもたない
        function getSelectedData($message_id)
        {
            $sql_statement = sprintf('SELECT * FROM messages WHERE message_id = %d', $message_id);
            
            $this->result = mysqli_query($this->con, $sql_statement);
            if (!$this->result) {
                exit('セレクト失敗');
            }
        }        
        
        // 取得メソッド(yield)
        function getAllDataOnceByUseOfYield($tableName)
        {

            $sql_statement = sprintf('SELECT * FROM %s ORDER BY author ASC', $tableName);

            $result = mysqli_query($this->con, $sql_statement);
            if (!$result) {
                exit('セレクト失敗');
            }
            
            $namelist = array();
            
            while ($data = mysqli_fetch_array($result)) {
                if (in_array($data['author'], $namelist)) {
                    continue;
                }
                $namelist[] = $data['author'];
                yield $data['author'];
            }
        }
        
        function getOneData()
        {
            return ($data = mysqli_fetch_array($this->result));
        }
        
        // 追加メソッド
        function putAData($bodyText, $author, $pictureInfo)
        {
            $creationData = date('Y-m-d H-i-s');
            $sqlSentence = 'INSERT INTO messages (message_id, creation_date, body_text, author, pictureInfo) VALUES ("'. time() . '","' . $creationData . '","'. $bodyText . '","'. $author . '","'. $pictureInfo . '")';

            $this->log->writeALogDown($sqlSentence);
            return (mysqli_query($this->con, $sqlSentence));
        }
        
        // 更新メソッド
        function updateAData($message_id, $body_text, $author, $pictureInfo)
        {
            $creation_data = date('Y-m-d H-i-s');
            
            if(empty($pictureInfo)) {
                $sql_sentence = 'UPDATE messages SET creation_date ="'. $creation_data . 
                    '", body_text ="' . $body_text .
                    '", author ="' . $author .
                    '" WHERE message_id ='. $message_id . ';';
            }
            else {
                $sql_sentence = 'UPDATE messages SET creation_date ="'. $creation_data . 
                    '", body_text ="' . $body_text .
                    '", author ="' . $author .
                    '", pictureInfo ="' . $pictureInfo .
                    '" WHERE message_id ='. $message_id . ';';
            }
            $this->log->writeALogDown($sql_sentence);
            return (mysqli_query($this->con, $sql_sentence));
        }

        // 削除メソッド
        function removeAData($message_id)
        {
            $sql_sentence = 'DELETE FROM messages WHERE message_id='. $message_id . ';' ;
            $this->log->writeALogDown($sql_sentence);
            return (mysqli_query($this->con, $sql_sentence));
        }
        
        // 解放メソッド
        function releaseDB()
        {
            //4. MySQLとの接続を切断する
            $this->con = mysqli_close($this->con);
            if (!$this->con) {
                exit('データベースとの接続を閉じられませんでした。<br /><br />');
            }
            //echo "DBがクローズされました<br /><br />";
            $this->con = null ;
        }

        // デストラクタ
        function __destruct()
        {
            //echo "デストラクタが実行されました<br /><br />";
            if (!$this->con) {
                return;
            }
            else {
                //4. MySQLとの接続を切断する
                $this->con = mysqli_close($this->con);
                if (!$this->con) {
                    exit('データベースとの接続を閉じられませんでした。');
                }
                //echo "DBがクローズされました<br /><br />";
                $this->con = null ;
            }
        }
    }
