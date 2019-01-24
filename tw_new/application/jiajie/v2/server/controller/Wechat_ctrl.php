<?php
/**
 * 微信相关逻辑
 * Class Wechat_ctrl
 */

class Wechat_ctrl extends \utils\BaseController
{
    /**
     * @var \Model\WechatModel
     */
    private $wechat_model;

    public $_ignore_node = [
        'getUserInfo',
        'wechatValid'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->wechat_model = \utils\Factory::getFactory('wechat');
    }

    /**
     * 微信验证URL合法接口
     * @RequestMapping('/wechat.valid')
     */
    public function wechatValid()
    {
        $lock_file = __ROOT__ . '/uploadfile/wechat.lock';
//        if (!file_exists($lock_file)) {
            $this->wechat_model->valid($lock_file);
//        }
//        return $this->error('已经验证过了');

    }

    /**
     * 授权用户并获取用户信息
     * @router http://server.name/wechat.get.userinfo
     */
    public function getUserInfo()
    {
        $code      = $this->request->get('code', '', 'trim');
        $refer     = $this->request->get('refer', 'http://jiajie-touch.7dugo.com/*?*/home', 'trim');
        $route     = $this->request->get('route', 'home', 'trim');
        $config_wx = include __DIR__ . '/../config/config_wxpay.php';
        if (!$code) {
            // 如果没有url中不带有code，则请求
            // 若提示“该链接无法访问”，请检查参数是否填写错误，是否拥有scope参数对应的授权作用域权限。
            $url = urlencode(getenv('SERVER_DOMAIN') . '/wechat.get.userinfo?refer=' . $refer . '&route=' . $route);
            header("location:https://open.weixin.qq.com/connect/oauth2/authorize?appid={$config_wx['app_id']}&redirect_uri={$url}&response_type=code&scope=snsapi_userinfo&state=wechat_redirect");
        }
        // 有code的情况下，调用api获取
        $result = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$config_wx['app_id']}&secret={$config_wx['app_secret']}&code={$code}&grant_type=authorization_code");
        if (isset($result['errcode'])) {

        } else {
            $result    = json_decode($result);
            $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token=' . $result->access_token . '&openid=' . $result->openid . '&lang=zh_CN');
            $user_info = json_decode($user_info);
            if (isset($user_info->errcode)) {

            } else {
                $refer = $refer . '/#/' . $route;
                $split = strpos($refer, '?') > -1 ? '&' : '?';
                $refer = $refer . $split . 'open_id=' . $user_info->openid . '&user_name=' . $user_info->nickname . '&is_completed=true';
                echo <<<EOF
<script>
window.location.href = "{$refer}";
</script>
EOF;
            }
        }
    }
}
