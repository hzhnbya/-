<?php

namespace app\admin\controller;
use app\common\model\Admin;
class Entry extends Common
{
    // 加载后台首页
    public function index(){
    
        return $this->fetch();
    }
    // 修改密码
    public function pass(){
        // 检测是否是post提交
        if(request()->isPost())
        // 是post提交的话 ，将请求转入到模型当中进行处理 ，
        // 调用里面的pass方法 并且同时把post的数据接收过来当做参数传递过去
        {
            $res =(new Admin())->pass(input('post.'));
            if($res['valid'])
            {
                // 清除session 中的登录信息
                session(null);
                // 执行成功
                $this->success($res['msg'],'admin/entry/index');exit;
            }else{
                // 执行失败
                $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }
}
