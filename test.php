<?php
/**
 * Desp: 测试方法
 * User: d4smart
 * Date: 2016/11/19
 * Time: 21:07
 * Email:   d4smart@foxmail.com
 * Github:  https://github.com/d4smart
 */

require "image.class.php";

// 给图片添加水印图片和文字
$image = new Image('bg3.jpg');
$image->imageMark('waterImage.jpg', array(0, 0), 60);
$image->fontMark("这是醉吼的", 20, array(360, 450), array(0, 0, 0), 60);
$image->show();
//$image->save('output1');

// 生成图片的缩略图
//$image = new Image('qrcode.jpg');
//$image->thumb();
//$image->show();
//$image->save('output2');
