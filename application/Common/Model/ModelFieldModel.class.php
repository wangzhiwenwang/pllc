<?php
// +----------------------------------------------------------------------
// | TP-Admin [ 多功能后台管理系统 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2016 http://www.hhailuo.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 逍遥·李志亮 <xiaoyao.working@gmail.com>
// +----------------------------------------------------------------------

namespace Common\Model;
use Common\Model\BaseModel;

/**
* 模型字段Model
*/
class ModelFieldModel extends BaseModel {
	//自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('formtype', 'require', '请选择字段类型！', 1, 'regex', BaseModel::MODEL_BOTH),
        array('field', 'require', '请输入字段名！', 1, 'regex', BaseModel::MODEL_BOTH),
        array('name', 'require', '请输入字段别名！', 1, 'regex', BaseModel::MODEL_BOTH),
    );

    /**
    * 删除字段
    */
    public function drop_field($tablename,$field) {
        $fields = $this->get_fields($tablename);
        if(array_key_exists($field, $fields)) {
			$tablename = C('DB_PREFIX').$tablename;
            return $this->db->execute("ALTER TABLE `$tablename` DROP `$field`;");
        } else {
            return false;
        }
    }

}