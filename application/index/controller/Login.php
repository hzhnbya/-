<?php

namespace app\index\controller;
use app\common\model\Index;
use think\Controller;

class Login extends Controller
{
    //首页
    public function index()
    {
        if(request()->isPost())
        {
            // halt($_POST);
            // 接收post数据 并传给模型处理
            $res = (new Index())->login(input('post.'));
            if($res['valid'])
            {
                // 登录成功
                $this->success($res['msg'],'index/home/index');exit;
            }
            else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch('home');
    }
    // 注册
    public function zhuce()
    {
        if(request()->isPost())
        {
            // halt($_POST);
            // 接收post数据 并传给模型处理
            $res = (new Index())->addUser(input('post.'));
            if($res['valid'])
            {
                // 登录成功
                $this->success($res['msg'],'index/login/index');exit;
            }
            else{
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }

    // 退出
    public function exit()
    {
        session(null);
        $this->redirect('index/home/index');
    }
        
    }

