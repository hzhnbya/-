<?php

namespace app\Index\controller;

class Message extends Common
{
    //
    protected $db;
    public function _initialize()
    {
        parent::_initialize();
        $this->db= new \app\common\model\Message();
    }
    public function index()
    {
        $headConf = ['title'=>'学码网博客--留言板'];
        $this->assign('headConf',$headConf);
        $mesData = db('usercomment')->order('commenttime desc')->paginate(5);
        $this->assign('mesData',$mesData);
        return $this->fetch();
       

    }
    // 添加留言
    public function addMes()
    {
        if(!session('index.index_id'))
        {
            // 未登录 跳转到登录页面
            $this->redirect('index/login/index');
        }
        if(request()->isPost())
        {
            // halt($_POST);
            $res = $this->db->addMes(input('post.'));
            if($res['valid'])
            {
                // 留言成功
                $this->redirect('index');
            }else{
                $this->error($res['msg']);exit;
            }
        }
    }
}
