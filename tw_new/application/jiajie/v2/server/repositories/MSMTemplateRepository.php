<?php
/**
 * @copyright 广州柒度信息科技有限公司
 * @version 2.0-release
 * @author rusice <liruizhao970302@outlook.com>
 */

namespace repositories;


use utils\BaseRepository;

class MSMTemplateRepository extends BaseRepository
{
    public function getDbTable()
    {
        return get_table('msm_template');
    }

    /**
     * @remark 插入前调用
     * @param array $insert
     * @return array
     */
    public function beforeInsertHook($insert): array
    {
        $insert['template_add_at'] = $_SERVER['REQUEST_TIME'];
        return $insert;
    }
}
