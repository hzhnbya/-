<?php

namespace app\admin\controller;

use think\Controller;

class Webset extends Controller
{
    protected $db;
    public function _initialize()
    {
        parent::_initialize();
        $this->db = new \app\common\model\Webset;
    }
    // 显示首页
    public function index()
    {
        // 获取首页数据
        $field = db('webset')->select();
        // halt($field);
        $this->assign('field',$field);
        return $this->fetch();
    }
    // 添加与编辑
    public function store()
    {
        $webset_id = input('param.webset_id');
        if(request()->isPost())
        {
            // halt($_POST);
            $res = $this->db->store(input('post.'));
            if($res['valid'])
            {
                // 添加成功
                $this->success($res['msg'],'index');exit;
            }
            else{
                // 添加失败
                $this->error($res['msg']);exit;
            }
        }
        // 判断是否有webset_id 有则是编辑 无则是添加
        if($webset_id)
        {
            // 编辑
            // 1.获取旧数据
            $oldData = $this->db->find($webset_id);
        }
        else{
            // 添加
            $oldData=['webset_name'=>'','webset_value'=>'','webset_des'=>''];
        }
        // halt($oldData);
        $this->assign('oldData',$oldData);
        // halt($oldData);
        return $this->fetch();
    }
       // 删除
    public function del()
    {
        $webset_id = input('param.webset_id');
        // halt($webset_id);
        if(\app\common\model\Webset::destroy($webset_id))
        {
            $this->success('删除成功','index');exit;
        }else{
            $this->error('删除失败');
        }
        
    }
    
}
