<?php

namespace app\admin\controller;

use think\Controller;
use app\common\model\Admin;
class Login extends Controller
{
    //
    public function login(){
        // 测试数据库
        // $data = db('admin')->find();
        // dump($data);
            if(request()->isPost()){
                // halt($_POST);
                $res =(new Admin()) ->login(input('post.'));
                if($res['valid'])
                {
                    // 说明登录成功
                    $this->success($res['msg'],'admin/entry/index');
                }else{
                    // 说明登录失败
                    $this->error($res['msg']);
                }

            }
        //  加载登录页面
        return $this->fetch('index');
    }
}
