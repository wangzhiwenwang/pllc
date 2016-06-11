<?php
// +----------------------------------------------------------------------
// | TP-Admin [ 多功能后台管理系统 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2016 http://www.hhailuo.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 逍遥·李志亮 <xiaoyao.working@gmail.com>
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Admin\Controller\BaseModelController;

/**
*  系统模型控制
*/
class ModelController extends BaseModelController {
    protected $db, $fieldDb;

    function __construct() {
        parent::__construct();
        $this->db = model("Model");
        $this->fieldDb = model("ModelField");
    }

    public function index() {
//        $models =  $this->db->where("siteid = %d", $this->siteid)->select();
		//查询条件删除：->where("siteid = %d", $this->siteid)
		$_SESSION['admin_model_index']="Model/index";
        $models =  $this->db->order(array("listorder" => "ASC"))->select();
        $this->assign("list", $models);
        $this->display();
    }
	
    /**
     *  添加画面显示
     */
    public function add() {
    	$this->display();
    }
	/**
	 * 添加
	 */
    public function add_post() {
		$this->checkToken();
		$data = $_POST['model'];
		if($this->db->create($data)) {
			$data['siteid'] = (isset($this->siteid) ? $this->siteid : 1);
			if (logic('model')->addModel($data)) {
				$to=empty($_SESSION['admin_model_index'])?"Model/index":$_SESSION['admin_model_index'];
				$this->success('添加成功！', U($to));
			} else {
				$this->error("添加失败! ");
			}
		} else {
			$this->error($this->db->getError());
		}
    }
	
	/**
	 * 编辑画面显示
	 */
    public function edit() {
		//查询条件删除：where(array('siteid' => $this->siteid))->
		$model = $this->db->find($_GET['id']);
		if (empty($model)) {
			$this->error('模型不存在！');
		}
		$this->assign('data',$model);
		$this->display();
    }
	
	/**
	 * 编辑画面保存
	 */
    public function edit_post() {
        if (IS_POST) {
            $this->checkToken();
			//查询条件删除 'siteid' => $this->siteid, 
            if ($this->db->where(array('id' => $_POST['modelid']))->save($_POST['model']) !==false) {
				$to = empty($_SESSION['admin_model_index'])?"Model/index":$_SESSION['admin_model_index'];
//                $this->success("更新成功!", $_POST['forward']);
				$this->success("更新成功!", U($to));
            } else {
                // $this->error("更新失败! 最后执行SQL:".$this->db->getLastSql());
                $this->error("更新失败! ");
            }
        }
    }

	/**
	 * 一览画面删除
	 */
    public function delete() {
        $modelid = intval($_GET['id']);
        $model = $this->db->find($modelid);
        if (empty($model)) {
            $this->error('模型不存在！');
        }
        if (logic('Model')->deleteModel($model)) {
            $this->success('删除成功',U("Model/index"));
        } else {
            $this->error('删除失败');
        }
    }

    /**
     * 模型名称重复异步检测
     */
    public function public_check_name() {
        if (!isset($_GET['field']) || !($_GET[$_GET['clientid']])) exit("0");
        $where = array($_GET['field'] => $_GET[$_GET['clientid']]);
        if (isset($_GET['modelid'])) {
            $where['id'] = array('NEQ',$_GET['modelid']);
        }
        if($this->db->where($where)->find()) {
            exit("0");
        } else {
            exit("1");
        }
    }
	
    //排序
    public function listorders() {
        $status = parent::_listorders($this->db);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
}