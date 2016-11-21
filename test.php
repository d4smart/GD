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

$src = 'bg3.jpg';
$source = 'thumb1.jpeg';
$location = array(20, 30);
$alpha = 60;

$image = new Image($src);
$image->imageMark($source, $location, $alpha);
$image->show();
