<?php
class Goods_model extends TW_Model
{
    public function __construct()
    {
        $this->tw=$this->db->get_prefix();

    }
	    /**
	 * 获得指定分类同级的所有分类以及该分类下的子分类
	 *
	 * @access  public
	 * @param   integer     $gc_id     分类编号
	 * @return  array
	 */
	function get_categories_tree($gc_id = 1210)
	{
		if ($gc_id > 1210)
		{
			$sql = "SELECT `gc_parent_id` FROM  `shopnc_goods_class` WHERE gc_id = $gc_id";
			$parent_id = getOne($sql);
		}
		else
		{
			$parent_id = 1210;
		}

		/*
		 判断当前分类中全是是否是底级分类，
		 如果是取出底级分类上级分类，
		 如果不是取当前分类及其下的子分类
		 */
		$sql = "SELECT count(*) FROM shopnc_goods_class WHERE gc_parent_id = $parent_id";
		if (getOne($sql) || $parent_id == 1210)
		{
			/* 获取当前分类及其子分类 */
			$sql = 'SELECT * FROM shopnc_goods_class ' .
					"WHERE gc_parent_id = '$parent_id' ORDER BY gc_id ASC";

			$res = getAll($sql);

			foreach ($res AS $row)
			{
				$cat_arr[$row['gc_id']]['id']   = $row['gc_id'];
				$cat_arr[$row['gc_id']]['name'] = $row['gc_name'];
				//$cat_arr[$row['gc_id']]['url']  = build_uri('category', array('cid' => $row['gc_id']), $row['cat_name']);

				if (isset($row['gc_id']) != NULL)
				{
					$cat_arr[$row['gc_id']]['gc_id'] = get_child_tree($row['gc_id']);
				}
			}
		}
		if(isset($cat_arr))
		{
			return $cat_arr;
		}
	}
}
?>