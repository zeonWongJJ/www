<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 0.1-dev
 * @author rusice <liruizhao970302@outlook.com>
 */

use utils\BaseController;
use model\ueditor\Uploader;

class UEditor_ctrl extends BaseController
{
    public $_ignore_node = [
        'index',
    ];

    /**
     * @var array
     */
    public $config;

    public function __construct()
    {
        header('Access-Control-Allow-Origin: *'); //设置http://www.baidu.com允许跨域访问
        header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); //设置允许的跨域header

        parent::__construct();
        $config       = file_get_contents(ROOT_PATH . 'config/ueditor.json');
        $this->config = json_decode($config, true);
    }

    public function index()
    {
        header('Content-Type: text/html; charset=utf-8');
        $action = $this->request->get('action', 'config', 'trim');

        switch ($action) {
            case 'config':
                $result = json_encode($this->config);
                break;
            /* 上传图片 */
            case 'uploadimage':
                /* 上传涂鸦 */
            case 'uploadscrawl':
                /* 上传视频 */
            case 'uploadvideo':
                /* 上传文件 */
            case 'uploadfile':
                $result = $this->_uploader();
                break;
        }

        return $this->_output($result);
    }

    /**
     * 上传
     * @return false|string
     */
    private function _uploader()
    {
        /* 上传配置 */
        $base64 = 'upload';
        switch (htmlspecialchars($_GET['action'])) {
            case 'uploadimage':
                $config    = [
                    'pathFormat' => $this->config['imagePathFormat'],
                    'maxSize' => $this->config['imageMaxSize'],
                    'allowFiles' => $this->config['imageAllowFiles'],
                ];
                $fieldName = $this->config['imageFieldName'];
                break;
            case 'uploadscrawl':
                $config    = [
                    'pathFormat' => $this->config['scrawlPathFormat'],
                    'maxSize' => $this->config['scrawlMaxSize'],
                    'allowFiles' => $this->config['scrawlAllowFiles'],
                    'oriName' => 'scrawl.png',
                ];
                $fieldName = $this->config['scrawlFieldName'];
                $base64    = 'base64';
                break;
            case 'uploadvideo':
                $config    = [
                    'pathFormat' => $this->config['videoPathFormat'],
                    'maxSize' => $this->config['videoMaxSize'],
                    'allowFiles' => $this->config['videoAllowFiles'],
                ];
                $fieldName = $this->config['videoFieldName'];
                break;
            case 'uploadfile':
            default:
                $config    = [
                    'pathFormat' => $this->config['filePathFormat'],
                    'maxSize' => $this->config['fileMaxSize'],
                    'allowFiles' => $this->config['fileAllowFiles'],
                ];
                $fieldName = $this->config['fileFieldName'];
                break;
        }

        /* 生成上传实例对象并完成上传 */
        $up = new Uploader($fieldName, $config, $base64);

        /**
         * 得到上传文件所对应的各个参数,数组结构
         * array(
         *     'state' => '',          //上传状态，上传成功时必须返回'SUCCESS'
         *     'url' => '',            //返回的地址
         *     'title' => '',          //新文件名
         *     'original' => '',       //原始文件名
         *     'type' => ''            //文件类型
         *     'size' => '',           //文件大小
         * )
         */

        /* 返回数据 */
        return json_encode($up->getFileInfo());
    }

    /**
     * @param $result
     */
    private function _output($result)
    {
        /* 输出结果 */
        if (isset($_GET['callback'])) {
            if (preg_match('/^[\w_]+$/', $_GET['callback'])) {
                echo htmlspecialchars($_GET['callback']) . '(' . $result . ')';
            } else {
                echo json_encode([
                    'state' => 'callback参数不合法',
                ]);
            }
        } else {
            echo $result;
        }
    }
}
