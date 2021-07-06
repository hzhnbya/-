<?php

namespace app\admin\controller;

use think\Controller;

class Link extends Controller
{
    protected $db;
    public function _initialize()
    {
        parent::_initialize();
        $this->db = new \app\common\model\Link;
    }
    //友链首页
    public function index()
    {
        // 获取首页数据
        $field = $this->db->getAll();
        $this->assign('field',$field);
        // halt($field);
        return $this->fetch();
    }
    // 添加与编辑友链
    public function store()
    {
        $link_id = input('param.link_id');
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
        // 判断是否有link_id 有则是编辑 无则是添加
        if($link_id)
        {
            // 编辑
            // 1.获取旧数据
            $oldData = $this->db->find($link_id);
        }
        else{
            // 添加
            $oldData=['link_name'=>'','link_url'=>'','link_sort'=>''];
        }
        $this->assign('oldData',$oldData);
        // halt($oldData);
        return $this->fetch();
    }
    // 删除
    public function del()
    {
        $link_id = input('param.link_id');
        // halt($link_id);
        if(\app\common\model\Link::destroy($link_id))
        {
            $this->success('删除成功','index');exit;
        }else{
            $this->error('删除失败');
        }
        
    }
 
}
