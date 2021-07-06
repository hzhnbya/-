<?php

namespace app\Index\controller;

use think\Controller;

class UserPl extends Common
{
    // 实例化
    protected $db;
    public function _initialize()
    {
        parent::_initialize();
        $this->db= new \app\common\model\UserPl();
    }
    
    public function addPl()
    {
        if(!session('index.index_id'))
        {
            // 未登录 跳转到登录页面
            $this->redirect('index/login/index');
        }
        if(request()->isPost())
        {
            // halt($_POST);
            $res = $this->db->addPl(input('post.'));
            if($res['valid'])
            {
                // 评论成功
                $this->success($res['msg']);
            }else{
                $this->error($res['msg']);exit;
            }
           
        }

    }

}
