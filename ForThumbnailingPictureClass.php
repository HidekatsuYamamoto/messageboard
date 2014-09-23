<?php

namespace HideSample\MessageBoard;

define('SCREEN_SIZE', '300');
?>
<?php

class ForThumbnailingPictureClass
{

    // コンストラクタ
    function __construct()
    {
        
    }

    /**
     * @assert (0, 0) == 0
     * @assert (300, 300) == 300
     * @assert (600, 600) == 300
     * @assert (300, 600) == 150
     * @assert (600, 300) == 300
     * @assert (900, 900) == 300
     * @assert (600, 300) == 300
     * @assert (300, 600) == 150
     */
    // 最適な幅、高さを求める。
    function figureHorizontalSize($width, $height) 
    {
        if ($width > $height) {
            if ($width > SCREEN_SIZE) {
                $scale = $width / SCREEN_SIZE;
                $conv_width = $width / $scale;
            } else {
                $conv_width = $width;
            }
        } else {
            if ($height > SCREEN_SIZE) {
                $scale = $height / SCREEN_SIZE;
                $conv_width = $width / $scale;
            } else {
                $conv_width = $width;
            }
        }
        return $conv_width;
    }

    /**
     * @assert (0, 0) == 0
     * @assert (300, 300) == 300
     * @assert (600, 600) == 300
     * @assert (300, 600) == 300
     * @assert (600, 300) == 150
     * @assert (900, 900) == 300
     * @assert (600, 300) == 150
     * @assert (300, 600) == 300
     */
    function figureVerticalSize($width, $height)
    {
        if ($width > $height) {
            if ($width > SCREEN_SIZE) {
                $scale = $width / SCREEN_SIZE;
                $conv_height = $height / $scale;
            } else {
                $conv_height = $height;
            }
        } else {
            if ($height > SCREEN_SIZE) {
                $scale = $height / SCREEN_SIZE;
                $conv_height = $height / $scale;
            } else {
                $conv_height = $height;
            }
        }
        return $conv_height;
    }

    // デストラクタ
    function __destruct() 
    {
        
    }

}