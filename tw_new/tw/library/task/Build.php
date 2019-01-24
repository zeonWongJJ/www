<?php
/**
 * 命令行脚本实现 - 构建命令 build
 *
 * php run build run --entry=order --cache-key=order --disable-router --table --disable-module
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace task;

class Build extends BaseTask
{
    public $controller_class;

    public $controller_name;

    public $options = [];

    /**
     * 执行文件构建
     * @param array $opts
     */
    public function run(array $opts = [])
    {
        foreach ($opts as $opt) {
            $temp                    = explode('=', $opt);
            $this->options[$temp[0]] = $temp[1];
        }

        $this->controller_class = $this->options['--entry'];
        $this->controller_name  = ucfirst($this->controller_class) . '_ctrl';

        // 生成控制器 begin
        if (!file_exists(__PATH__ . 'controller/' . $this->controller_name . '.php')) {
            $this->buildController();
        } else {
            echo "控制器{$this->controller_class}已存在，跳过生成控制器阶段!", PHP_EOL;
        }
        // 生成控制器 end

        // 生成路由 begin
        if (!isset($this->options['--disable-router'])) {
            if (!isset($this->options['--router'])) {
                echo '定义路由需要同时指定路由前缀选项 --router', PHP_EOL;
            } else {
                $router_path = __PATH__ . 'config/' . $this->controller_class . '.php';
                //todo:: --refresh-router 下强制刷新
                if (file_exists($router_path) && !isset($this->options['--refresh-router'])) {
                    echo "路由文件{$this->controller_class}已存在，跳过生成路由阶段!", PHP_EOL;
                } else {
                    $this->buildRouter(isset($this->options['--refresh-router']));
                }
            }
        }
        // 生成路由 end

        // 生成数据仓库类 begin
        if (!file_exists(__PATH__ . 'repositories/' . ucfirst($this->controller_class) . 'Repository.php')) {
            if (!isset($this->options['--table'])) {
                echo '定义数据仓库需要同时指定数据表选项 --table', PHP_EOL;
            } else {
                $this->buildRepository();
            }
        } else {
            echo "数据仓库类{$this->controller_class}已存在，跳过生成数据仓库类阶段!", PHP_EOL;
        }
        // 生成数据仓库类 end

        // 生成model begin
        if (!isset($this->options['--disable-module'])) {
            if (!file_exists(__PATH__ . 'model/' . ucfirst($this->controller_class) . '_model.php')) {
                if (!isset($this->options['--table'])) {
                    echo '定义model需要同时指定数据表选项 --table', PHP_EOL;
                } else {
                    $this->buildModel();
                }
            } else {
                echo "模型类{$this->controller_class}已存在，跳过生成模型类阶段!", PHP_EOL;
            }
        }
        // 生成model end
    }

    /**
     * 控制器构建
     */
    private function buildController()
    {
        if ($this->controller_class) {
            $replace = [
                '-AUTHOR-'          => AUTHOR_NAME,
                '-EMAIL-'           => AUTHOR_EMAIL,
                '-className-'       => ucfirst($this->controller_class) . '_ctrl',
                '[--cacheKey--]'    => '',
                '-repositoryClass-' => '\repositories\\' . ucfirst($this->controller_class) . 'Repository::class'
            ];

            if (isset($this->options['--cache-key'])) {
                $replace['[--cacheKey--]'] = <<<EOF
/**
  * 缓存key
  * @param string
  */
  protected $cache_key = '"{$this->options['--cache-key']}"';
EOF;

            }

            $template = file_get_contents(__DIR__ . '/template/controller.tpl');
            $content  = str_replace(array_keys($replace), array_values($replace), $template);

            $this->buildFile($content, __PATH__ . 'controller/' . $this->controller_name . '.php');
            echo "生成控制器{$this->controller_class}成功!" . PHP_EOL;
        }
    }

    /**
     * @param string $content 写入字符串
     * @param string $targetDir 目标文件夹
     */
    private function buildFile($content, $targetDir)
    {
        $pathinfo = pathinfo($targetDir);

        if (!@mkdir($pathinfo['dirname'], 0755, true) && !is_dir($pathinfo['dirname'])) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $pathinfo['dirname']));
        }
        file_put_contents($targetDir, $content);
    }

    /**
     * 路由构建
     */
    private function buildRouter($refresh = false)
    {
        if (!$refresh) {
            $replace  = [
                '--className--' => $this->controller_class,
                '--route-key--' => $this->options['--router']
            ];
            $template = file_get_contents(__DIR__ . '/template/router.tpl');
            $content  = str_replace(array_keys($replace), array_values($replace), $template);

            $this->buildFile($content, __PATH__ . 'config/routers/' . $this->controller_class . '.php');
        } else {
            echo '未支持刷新路由', PHP_EOL;
        }
        echo "生成路由{$this->controller_class}成功!", PHP_EOL;
    }

    /**
     * 生成数据仓库类
     */
    private function buildRepository()
    {
        $replace = [
            '--className--'  => ucfirst($this->controller_class) . 'Repository',
            '-AUTHOR-'       => AUTHOR_NAME,
            '-EMAIL-'        => AUTHOR_EMAIL,
            '[--cacheKey--]' => '',
            '--tableName--'  => $this->options['--table']
        ];

        if (isset($this->options['--cacheKey--'])) {
            $replace['[--cacheKey--]'] = <<<EOF
/**
  * 缓存key
  * @param string
  */
  protected $cache_key = '"{$this->options['--cache-key']}"';
EOF;

        }

        $template = file_get_contents(__DIR__ . '/template/repository.tpl');
        $content  = str_replace(array_keys($replace), array_values($replace), $template);

        $this->buildFile($content, __PATH__ . 'repositories/' . ucfirst($this->controller_class) . 'Repository.php');
        echo "生成数据仓库{$this->controller_class}成功!" . PHP_EOL;
    }

    /**
     * 生成model
     */
    private function buildModel()
    {
        $replace = [
            '--className--' => ucfirst($this->controller_class) . 'Model',
            '-AUTHOR-'      => AUTHOR_NAME,
            '-EMAIL-'       => AUTHOR_EMAIL,
        ];

        $template = file_get_contents(__DIR__ . '/template/model.tpl');
        $content  = str_replace(array_keys($replace), array_values($replace), $template);

        $this->buildFile($content, __PATH__ . 'model/' . ucfirst($this->controller_class) . '_model.php');
        echo "生成模型{$this->controller_class}成功!" . PHP_EOL;
    }
}