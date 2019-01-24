<?php
/**
 * 文件操作控制器调度
 * @author rusice <liruzihao970302@outlook.com>
 * @version 1.0.0-dev
 */

/**
 * Class File_ctrl
 */
class File_ctrl extends \utils\BaseController
{
    public $_ignore_node = [
        'getThumbImg'
    ];

    /**
     * 移除图片
     * @router http://server.name/file.remove
     * @return mixed
     */
    public function removeFile()
    {
        if ($files = $this->request->post('files/a', [], 'trim')) {
            foreach ($files as $file) {
                $_file = __ROOT__ . $file;
                file_exists($_file) && unlink($_file);
            }
        }
        return $this->success(false);
    }

    /**
     * @remark 根据需要的尺寸来缩放/放大图片
     * @RequestMapping('get.thumb.img')
     */
    public function getThumbImg()
    {
        $data['dst_w']   = $this->request->get('dst_w', 50, 'intval');
        $data['dst_h']   = $this->request->get('dst_h', 50, 'intval');
        $data['src_img'] = $this->request->get('src_img', '', 'trim');
        if (file_exists(__ROOT__ . '/' . trim($data['src_img'], '/'))) {
            list($src_w, $src_h) = getimagesize(__ROOT__ . '/' . trim($data['src_img']));  // 获取原图尺寸
            $dst_scale = $data['dst_h'] / $data['dst_w']; //目标图像长宽比
            $src_scale = $src_h / $src_w; // 原图长宽比
            if ($src_scale >= $dst_scale) { // 过高
                $w = (int)$src_w;
                $h = (int)($dst_scale * $w);

                $x = 0;
                $y = ($src_h - $h) / 3;
            } else { // 过宽
                $h = (int)$src_h;
                $w = (int)($h / $dst_scale);
                $x = ($src_w - $w) / 2;
                $y = 0;
            }
            // 剪裁
            $info   = getimagesize(__ROOT__ . '/' . trim($data['src_img']));
            $imgExt = image_type_to_extension($info[2], false); //获取文件后缀
            $fun    = "imagecreatefrom{$imgExt}";
            $source = $fun(__ROOT__ . '/' . trim($data['src_img']));
            $croped = imagecreatetruecolor($w, $h);
            imagecopy($croped, $source, 0, 0, $x, $y, $src_w, $src_h);
            /* --- 用以处理缩放gif和png图透明背景变黑色问题 开始 --- */
            if (in_array(strtolower($imgExt), ['png', 'gif'])) {
                $color = imagecolorallocate($croped, 255, 255, 255);
                imagecolortransparent($croped, $color);
                imagefill($croped, 0, 0, $color);
            }
            // 缩放
            $scale   = $data['dst_w'] / $w;
            $target  = imagecreatetruecolor($data['dst_w'], $data['dst_h']);
            $final_w = (int)($w * $scale);
            $final_h = (int)($h * $scale);
            imagecopyresampled($target, $croped, 0, 0, 0, 0, $final_w, $final_h, $w, $h);

            header('Content-Type: image/' . $imgExt);
            imagepng($target);
            imagedestroy($target);
            imagejpeg($target);
            imagedestroy($source);
            imagedestroy($target);
            imagedestroy($source);

            // return $this->showImg($thumb_img_path);
        } else {
            return $this->showImg(__ROOT__ . '/default.png');
        }
    }

    /**
     * @remark php 页面直接输出图片
     * @param $img
     */
    private function showImg($img)
    {
        $info    = getimagesize($img);
        $imgExt  = image_type_to_extension($info[2], false); //获取文件后缀
        $fun     = "imagecreatefrom{$imgExt}";
        $imgInfo = $fun($img);         //1.由文件或 URL 创建一个新图象。如:imagecreatefrompng ( string $filename )
        //$mime = $info['mime'];
        $mime = image_type_to_mime_type(\model\ToolModel::exif_imagetype($img)); //获取图片的 MIME 类型
        header('Content-Type:' . $mime);
        $quality = 100;
        if ($imgExt == 'png') $quality = 9;   //输出质量,JPEG格式(0-100),PNG格式(0-9)
        $getImgInfo = "image{$imgExt}";
        $getImgInfo($imgInfo, null, $quality); //2.将图像输出到浏览器或文件。如: imagepng ( resource $image )
        imagedestroy($imgInfo);
    }
}
