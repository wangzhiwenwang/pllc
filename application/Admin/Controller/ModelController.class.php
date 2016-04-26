<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;
use Common\Controller\AdminbaseController;

/**
 * Description of ModelController
 *
 * @author 志文
 */
class ModelController extends AdminbaseController {

    protected $model_model;
    protected $auth_rule_model;

    function _initialize() {
        parent::_initialize();
        $this->model_model = D("Common/Model");
        $this->auth_rule_model = D("Common/AuthRule");
    }

    /**
     *  显示模型
     */
    public function index() {
    	$_SESSION['admin_model_index']="Model/index";
        $result = $this->model_model->order(array("listorder" => "ASC"))->select();
        $this->assign("list", $result);
        $this->display();
    }
    
    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    protected function _get_level($id, $array = array(), $i = 0) {
    
    	if ($array[$id]['parentid']==0 || empty($array[$array[$id]['parentid']]) || $array[$id]['parentid']==$id){
    		return  $i;
    	}else{
    		$i++;
    		return $this->_get_level($array[$id]['parentid'],$array,$i);
    	}
    
    }
    
//    public function lists(){
//    	$_SESSION['admin_menu_index']="Menu/lists";
//    	$result = $this->model_model->order(array("listorder" => "ASC","model" => "ASC","action" => "ASC"))->select();
//    	$this->assign("menus",$result);
//    	$this->display();
//    }

    /**
     *  添加
     */
    public function add() {

    	$this->display();
    }
    
    /**
     *  添加
     */
    public function add_post() {
    	if (IS_POST) {
    		if ($this->model_model->create()) {
    			if ($this->model_model->add()!==false) {
    				$to=empty($_SESSION['admin_model_index'])?"Model/index":$_SESSION['admin_model_index'];
    				$this->success("添加成功！", U($to));
    			} else {
    				$this->error("添加失败！");
    			}
    		} else {
    			$this->error($this->model_model->getError());
    		}
    	}
    }

    /**
     *  删除
     */
    public function delete() {
        $id = intval(I("get.modelid"));
        if ($this->model_model->delete($id)!==false) {
            $this->success("删除模型成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    /**
     *  编辑
     */
    public function edit() {
        $id = intval(I("get.modelid"));
        $rs = $this->model_model->where(array("id" => $id))->find();

        $this->assign("data", $rs);
        $this->display();
    }
    
    /**
     *  编辑
     */
    public function edit_post() {
    	if (IS_POST) {
    		if ($this->model_model->create()) {
                $oldTblName = I("post.oldtablename");
                $newTbleName = I("post.tablename");
                if( $oldTblName !== $newTbleName) {
                    if($this->model_model->table_exist_withPrefix($newTbleName)) {
                        $this->error("数据表【".I("post.oldtablename")."】已存在，请更换成其他表名！");
                    } else {
                        //修改表名
                        if ($this->model_model->table_exist_withPrefix($oldTblName)) {
                            $this->model_model->alter_tablename_withPrefix($oldTblName,$newTbleName);
                        }
                    }
                }
    			if ($this->model_model->save() !== false) {
    				$this->success("更新成功！");
    			} else {
    				$this->error("更新失败！");
    			}
    		} else {
    			$this->error($this->model_model->getError());
    		}
    	}
    }

    //排序
    public function listorders() {
        $status = parent::_listorders($this->model_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

}
