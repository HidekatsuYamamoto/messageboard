<?php

/**
 * Classが定義されていない場合に、ファイルを探すクラス
 */
class ClassLoader
{
    // class ファイルがあるディレクトリのリスト
    private static $dirs;

    public function __construct() {
        spl_autoload_register(array($this, 'loadClass'));
    }    
    
    /**
     * クラスが見つからなかった場合呼び出されるメソッド
     * spl_autoload_register でこのメソッドを登録してください
     * @param  string $class 名前空間など含んだクラス名
     * @return bool 成功すればtrue
     */
    public static function loadClass($class)
    {
        foreach (self::directories() as $directory) {
            // 名前空間や疑似名前空間をここでパースして
            // 適切なファイルパスにしてください
            $className = substr( $class, (strrpos($class, "\\")+1) );
            
            $file_name = "{$directory}/{$className}.php";

            if (is_file($file_name)) {
                require $file_name;

                return true;
            }
        }
    }

    /**
     * ディレクトリリスト
     * @return array フルパスのリスト
     */
    private static function directories()
    {
        if (empty(self::$dirs)) {
            $base = dirname(__FILE__);
            self::$dirs = array(
                // ここに読み込んでほしいディレクトリを足していきます
                $base ,
                $base . '/controllers',
                $base . '/models'
            );
        }

        return self::$dirs;
    }
}
