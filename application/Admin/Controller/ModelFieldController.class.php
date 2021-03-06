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
 *  模型字段管理类
 */
class ModelFieldController extends BaseModelController {
    protected $db, $model_db;
    function __construct() {
        parent::__construct();
        $this->db = model('ModelField');
        $this->model_db = model('Model');
    }

    public function index() {
        $modelid = I('modelid');
        if (empty($modelid)) {
            $this->error('参数异常');
        }
		//'siteid' => $this->siteid,
        $fields = $this->db->where(array('modelid' => $modelid))->order("listorder asc , fieldid asc")->select();
        $model = $this->model_db->find($modelid);
        $this->assign('model', $model);
        $this->assign('fields', $fields);

        require MODEL_PATH.'fields.inc.php';

        $this->assign('forbid_fields',$forbid_fields);
        $this->assign('forbid_delete',$forbid_delete);
        $this->display();
    }
	
	/**
	 * 字段添加画面（Load）
	 */
    public function add() {
		require MODEL_PATH.'fields.inc.php';
		$modelid = I('modelid');

		$f_datas = $this->db->where(array('modelid'=>$modelid))
			->order('listorder ASC')
			->field('field, name')
			->select();

		$model = $this->model_db->find($modelid);
		foreach($f_datas as $_k=>$_v) {
			$exists_field[] = $_v['field'];
		}

		$all_field = array();
		foreach($fields as $_k=>$_v) {
			if(in_array($_k, $not_allow_fields) || (in_array($_k, $exists_field) && in_array($_k, $unique_fields))) continue;
			$all_field[$_k] = $_v;
		}

		$this->assign('modelid', $modelid);
		$this->assign('model', $model);
		$this->assign('all_field', $all_field);
		$this->assign('att_css_js', $att_css_js);
		$this->display();
        
    }
	
	/**
	 * 字段添加画面（保存）
	 */
    public function add_post() {
		
		$modelid = I("modelid");
		$this->assign('modelid', $modelid);
		
		if($this->db->create(I('info'))) {
			if ($this->isNameExist()) {
				$this->error('同样的字段名已经存在！');
			}
			$this->checkToken();
//			$modelid = $_POST['info']['modelid'] = intval($_POST['info']['modelid']);
			$model = $this->model_db->find($modelid);
			$tablename = C('DB_PREFIX') . $model['tablename'];

			$field = $_POST['info']['field'];
			$minlength = $_POST['info']['minlength'] ? $_POST['info']['minlength'] : 0;
			$maxlength = $_POST['info']['maxlength'] ? $_POST['info']['maxlength'] : 0;
			$field_type = $_POST['info']['formtype'];

			require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';
			if(isset($_POST['setting']['fieldtype'])) {
				$field_type = $_POST['setting']['fieldtype'];
			}
			require MODEL_PATH.'add.sql.php';

			//附加属性值
			$_POST['info']['setting'] = array2string($_POST['setting'], 0);
			$_POST['info']['siteid'] = $this->siteid;

			if ($this->db->add($_POST['info'])) {
				$this->success('添加成功!', U('ModelField/add', array('modelid' => $modelid)));
			} else {
				$this->error('添加失败!', U('ModelField/add', array('modelid' => $modelid)));
			}
		} else {
			$this->error($this->db->getError());
		}
    }
	public function isNameExist() {
		//检查是否重复添加
        $find = $this->db->where(array("modelid"=>I("info")["modelid"], "field"=>I("info")["field"]))->find();
        if ($find) {
            return true;
        }
        return false;
	}
	/**
	 * 字段编辑画面Load
	 */
    public function edit() {
		require MODEL_PATH.'fields.inc.php';
		$modelid = intval($_GET['modelid']);
		$fieldid = intval($_GET['fieldid']);
		$model = $this->model_db->find($modelid);
		$model_field = $this->db->where(array('fieldid' => $fieldid))->find();
		extract($model_field);
		require MODEL_PATH.$formtype.DIRECTORY_SEPARATOR.'config.inc.php';
		$setting = string2array($setting);
		ob_start();
		include MODEL_PATH.$formtype.DIRECTORY_SEPARATOR.'field_edit_form.inc.php';
		$form_data = ob_get_contents();
		ob_end_clean();
		$this->assign('modelid',$modelid);
		$this->assign('fieldid',$fieldid);
		$this->assign('model',$model);
		$this->assign('model_field',$model_field);
		$this->assign('form_data',$form_data);

		// field.inc
		$this->assign('fields', $fields);
		$this->assign('not_allow_fields', $not_allow_fields);
		$this->assign('unique_fields', $unique_fields);
		$this->assign('forbid_fields', $forbid_fields);
		$this->assign('forbid_delete', $forbid_delete);
		$this->assign('att_css_js', $att_css_js);

		// config.inc
		$this->assign('field_type',$field_type);
		$this->assign('field_basic_table',$field_basic_table);
		$this->assign('field_allow_index',$field_allow_index);
		$this->assign('field_minlength',$field_minlength);
		$this->assign('field_maxlength',$field_maxlength);
		$this->assign('field_allow_search',$field_allow_search);
		$this->assign('field_allow_fulltext',$field_allow_fulltext);
		$this->assign('field_allow_isunique',$field_allow_isunique);
		$this->display();

    }
	
	/**
	 * 字段编辑画面保存
	 */
    public function edit_post() {
		if($this->db->create(I('info'))) {
			$this->checkToken();
			$modelid = $_POST['info']['modelid'] = intval($_POST['info']['modelid']);
			$model = $this->model_db->find($modelid);
			$tablename = C('DB_PREFIX') . $model['tablename'];
			$field = $_POST['info']['field'];
			$minlength = $_POST['info']['minlength'] ? $_POST['info']['minlength'] : 0;
			$maxlength = $_POST['info']['maxlength'] ? $_POST['info']['maxlength'] : 0;
			$field_type = $_POST['info']['formtype'];
			require MODEL_PATH.$field_type.DIRECTORY_SEPARATOR.'config.inc.php';
			if(isset($_POST['setting']['fieldtype'])) {
				$field_type = $_POST['setting']['fieldtype'];
			}
			$oldfield = $_POST['oldfield'];
			require MODEL_PATH.'edit.sql.php';
			//附加属性值
			$_POST['info']['setting'] = array2string($_POST['setting'], 0);
			$fieldid = intval($_POST['fieldid']);

			/*$_POST['info']['unsetgroupids'] = isset($_POST['unsetgroupids']) ? implode(',',$_POST['unsetgroupids']) : '';
			$_POST['info']['unsetroleids'] = isset($_POST['unsetroleids']) ? implode(',',$_POST['unsetroleids']) : '';*/

			if ($this->db->where(array('fieldid'=>$fieldid,'siteid'=>$this->siteid))->save($_POST['info']) !== false) {
				$this->success('更新成功!',U('ModelField/index',array('modelid'=>$modelid)));
			} else {
				$this->error('更新失败!',U('ModelField/edit',array('modelid'=>$modelid,'fieldid'=>$field)));
			}
		} else {
			$this->error($this->db->getError());
		}
    }

    public function delete() {
        $fieldid = intval($_GET['fieldid']);
		//,'siteid'=>$this->siteid
        $r = $this->db->where(array('fieldid'=>$_GET['fieldid']))->find();
		//,'siteid'=>$this->siteid
        $this->db->where(array('fieldid'=>$_GET['fieldid']))->delete();
        $modelid = intval($_GET['modelid']);
        $model = $this->model_db->find($modelid);
        $tablename = $model['tablename'];
        $tablename = $r['issystem'] ? $tablename : $tablename.'_data';
        $this->db->drop_field($tablename,$r['field']);
        $this->success("删除成功！");
		$this->assign('model', $model);
		$this->display();
    }

    /**
     * 禁用字段
     */
    public function disabled() {
        $fieldid = I('get.fieldid');
        $disabled = $_GET['disabled'] ? 0 : 1;
		//,'siteid'=>$this->siteid
        if ($this->db->where(array('fieldid'=>$fieldid))->save(array('disabled'=>$disabled)) !== false) {
            $this->success('操作成功！');
        } else {
            $this->error('操作失败！');
        }
    }

    /**
     * 排序
     */
    public function listorder() {
        if(isset($_POST['dosubmit'])) {
            foreach($_POST['listorders'] as $id => $listorder) {
                $this->db->where(array('fieldid'=>$id))->save(array('listorder'=>$listorder));
            }
            $this->success(L('operation_success'));
        } else {
            $this->error(L('operation_failure'));
        }
    }

    /**
     * 检查字段是否存在
     */
    public function public_checkfield() {
        $field = strtolower($_GET['field']);
        $oldfield = strtolower($_GET['oldfield']);
        if($field==$oldfield) exit('1');
        $modelid = intval($_GET['modelid']);
        $model = $this->model_db->find($modelid);
        $issystem = intval($_GET['issystem']);
        $tablename = strtolower( $model['tablename'] );
        $tablename = $issystem ? $tablename : $tablename.'_data';
        $fields = $this->db->get_fields($tablename);
        if(array_key_exists($field,$fields)) {
            exit('0');
        } else {
            exit('1');
        }
    }

    /**
     * 字段属性设置
     */
    public function public_field_setting() {
        $fieldtype = $_GET['fieldtype'];
        require MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'config.inc.php';
        ob_start();
        include MODEL_PATH.$fieldtype.DIRECTORY_SEPARATOR.'field_add_form.inc.php';
        $data_setting = ob_get_contents();
        ob_end_clean();

        $settings = array(
            'field_basic_table'=>$field_basic_table,
            'field_minlength'=>$field_minlength,
            'field_maxlength'=>$field_maxlength,
            'field_allow_search'=>$field_allow_search,
            'field_allow_fulltext'=>$field_allow_fulltext,
            'field_allow_isunique'=>$field_allow_isunique,
            'setting'=>$data_setting);

        $this->ajaxReturn($settings);
    }

}