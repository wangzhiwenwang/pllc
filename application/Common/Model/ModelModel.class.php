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

class ModelModel extends BaseModel {
	
	//自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '模型名称不能为空！', 1, 'regex', BaseModel:: MODEL_BOTH ),
        array('tablename', 'require', '表名不能为空！', 1, 'regex', BaseModel:: MODEL_BOTH ),
        array('description', 'require', '描述不能为空！', 1, 'regex', BaseModel:: MODEL_BOTH ),
        array('name', 'checkNameAction', '同样的模型名称已经存在！', 2, 'callback', BaseModel:: MODEL_INSERT ),
    	array('tablename', 'checkTableNameAction', '同样的表名已经存在！', 2, 'callback', BaseModel:: MODEL_INSERT ),
    );
    //自动完成
    protected $_auto = array(
//        array(填充字段,填充内容,填充条件,附加规则)
        //补空格字段
        array("siteid","1"),
//        array("setting", " "),
//        array("addtime", " "),
//        array("items", " "),
//        array("enablesearch", " "),
//        array("disabled", " "),
//        array("default_style", " "),
//        array("category_template", " "),
//        array("list_template", " "),
//        array("show_template", " "),
//        array("js_template", " "),
//        array("listorder", "0"),
//        array("type", "0"),
        
    );
	
    public function execModelCreateSql($sql) {
        $sqls = $this->sql_split($sql);
        if(is_array($sqls)) {
            foreach($sqls as $sql) {
                if(trim($sql) != '') {
                    if ($this->execute($sql) === false) {
                        \Common\Lib\Log::error('sql 执行失败: ' . $sql);
                        return false;
                    };
                }
            }
        } else {
            if ($this->execute($sqls) === false) {
                \Common\Lib\Log::error('sqls 执行失败: ' . $sqls);
                return false;
            };
        }
        return true;
    }

    public function sql_split($sql) {
        $db_charset = C('DB_CHARSET') ? C('DB_CHARSET') : 'utf8';
        $sql = preg_replace("/TYPE=(InnoDB|MyISAM|MEMORY)( DEFAULT CHARSET=[^; ]+)?/", "ENGINE=\\1 DEFAULT CHARSET=".$db_charset,$sql);
        if(C('DB_PREFIX') != "tb_") $sql = str_replace("tb_", C('DB_PREFIX'), $sql);
        $sql = str_replace("\r", "\n", $sql);
        $ret = array();
        $num = 0;
        $queriesarray = explode(";\n", trim($sql));
        unset($sql);
        foreach($queriesarray as $query) {
            $ret[$num] = '';
            $queries = explode("\n", trim($query));
            $queries = array_filter($queries);
            foreach($queries as $query) {
                $str1 = substr($query, 0, 1);
                if($str1 != '#' && $str1 != '-') $ret[$num] .= $query;
            }
            $num++;
        }
        return($ret);
    }
	
    public function fillSpace($data) {
        return " ";
    }

    //验证action是否重复添加
    public function checkNameAction($data) {
        //检查是否重复添加
        $find = $this->where(array("name"=>$data))->find();
        if ($find) {
            return false;
        }
        return true;
    }
    public function checkTableNameAction($data) {
        //检查是否重复添加
        $find = $this->where(array("tablename"=>$data))->find();
        if ($find) {
            return false;
        }
        return true;
    }

}