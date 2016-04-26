<?php

/* * 
 * 公共模型
 */

namespace Common\Model;
use Common\Model\CommonModel;

class PllcCommonModel extends CommonModel {
    protected $tablePrefix = 'pllc_';
    
    /**
     * 删除表
     */
    public function drop_table_withPrefix($tablename,$prefix) {
        if(isset($prefix)){
            return $this->query("DROP TABLE ".$prefix.$tablename);
        } else {
            return $this->query("DROP TABLE $tablename");
        }
    }
    
    /**
     * 修改表名
     */
    public function alter_tablename_withPrefix($oldtablename,$newtablename,$prefix) {
        return $this->query("RENAME TABLE $oldtablename TO $newtablename");
    }
    
    /**
     * 检查表是否存在 
     * $tablename 不带表前缀
     * $prefix 表前缀
     */
    public function table_exist_withPrefix($tablename,$prefix) {
        $tables = $this->list_tables();
        if(isset($prefix)){
            return in_array($prefix . $table, $tables) ? true : false;
        } else {
            return in_array($table, $tables) ? true : false;
        }
        
    }
    
}

