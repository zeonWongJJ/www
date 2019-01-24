<?php
/**
 * 模板
 */

namespace utils\traits;

trait RenderTrait
{
    /**
     * @param $name
     * @param $arguments
     */
    public function __call($name, $arguments)
    {
        if (\in_array($name, ['getList', 'getOne', 'insert', 'update', 'delete'])) {

            if (\in_array($name, ['insert', 'update'])) {
                $template_name = 'info';
            } else {
                $template_name = $this->method_name;
            }

            $this->view->display(strtolower($this->controller_name . '/' . $template_name), $this->assets);
        }
    }
}