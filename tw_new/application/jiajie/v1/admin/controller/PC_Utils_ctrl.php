<?php

class PC_Utils_ctrl extends \utils\ViewController
{
    /**
     * @router http://server.name/utils.get.tree.options
     */
    public function makeTreeOptions()
    {
        $source_data = $this->request->post('source_data', '', 'trim');
        $select_id   = $this->request->post('select_id', 0, 'intval');
        $tree        = new \utils\Tree();

        $str = "<option value='\$id' \$selected>\$spacer\$name</option>";
        $tree->init($source_data);
        $option = $tree->get_tree(0, $str, $select_id);

        return $this->success(compact('option'));
    }
}