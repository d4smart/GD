<?php
/**
 * Desp: 图片处理类
 * User: d4smart
 * Date: 2016/11/19
 * Time: 20:41
 * Email:   d4smart@foxmail.com
 * Github:  https://github.com/d4smart
 */

class Image
{
    /**
     * @var array 要处理的图片的信息
     */
    private $info;

    /**
     * @var resource 最后要输出的图片资源符
     */
    private $image;

    /**
     * Image constructor.
     * 根据传入的图片资源符，在内存中创建图像（画布）
     * @param string $src 图片的路径
     */
    public function __construct($src) {
        // 获取图像信息并保存
        $info = getimagesize($src);
        $this->info = array(
            'width' => $info[0],
            'height' => $info[1],
            'type' => image_type_to_extension($info[2], false),
            'mime' => $info['mime'],
        );

        // 根据图像信息创建图像
        $fun = "imagecreatefrom{$this->info['type']}"; // imagecreatefromjpeg，imagecreatefrompng...
        $this->image = $fun($src); // 调用函数创建图像
    }

    /**
     * 生成图像的缩略图
     * @param int $width 缩略图宽度
     * @param int $height 缩略图高度
     */
    public function thumb($width = 120, $height = 120) {
        $thumb = imagecreatetruecolor($width, $height);
        imagecopyresampled($thumb, $this->image, 0, 0, 0, 0, $width, $height, $this->info['width'], $this->info['height']);
        imagedestroy($this->image);
        $this->image = $thumb;
    }

    /**
     * 在图像中添加文字
     * @param string $content 文字内容
     * @param int $size 文字大小
     * @param array $position 文字位置（x，y），如array(20, 20)，左上角坐标系，以文字的左下角为基准
     * @param array $color 文字颜色（R，G，B），如array(255, 255, 255)
     * @param int $alpha 文字透明度，0-127，0为完全不透明
     * @param int $angle 文字旋转角度，默认为0
     * @param string $font 字体路径，默认为系统字体
     */
    public function fontMark($content, $size, $position, $color, $alpha, $angle = 0, $font = "msyh.ttc") {
        $col = imagecolorallocatealpha($this->image, $color[0], $color[1], $color[2], $alpha);
        imagettftext($this->image, $size, $angle, $position[0], $position[1], $col, $font, $content);
    }

    /**
     * 在图像中添加图像水印
     * @param string $source 水印图象路径
     * @param array $position 水印位置，如array(30, 20)，默认为右下角坐标系，以水印图片右下角为基准
     * @param int $alpha 水印透明度，0-100，0为完全透明
     */
    public function imageMark($source, $position, $alpha) {
        // 创建水印图象
        $info = getimagesize($source);
        $type = image_type_to_extension($info[2], false);
        $func = "imagecreatefrom{$type}";
        $waterImage = $func($source);

        // 添加水印
        imagecopymerge($this->image, $waterImage, $this->info['width'] - $position[0] - $info[0], $this->info['height'] - $position[1] - $info[1], 0, 0, $info[0], $info[1], $alpha);
        imagedestroy($waterImage);
    }

    /**
     * 在浏览器中显示最终的图片
     */
    public function show() {
        header('Content-type:'.$this->info['mime']);
        $funs = "image{$this->info['type']}"; // imagejpeg，imagepng...
        $funs($this->image);
    }

    /**
     * 存储最终的图片
     * @param string $name 存储的图片名
     */
    public function save($name) {
        $funs = "image{$this->info['type']}";
        $funs($this->image, $name.'.'.$this->info['type']);
    }

    /**
     * 析构函数，释放图片资源
     */
    public function __destruct() {
        imagedestroy($this->image);
    }
}
