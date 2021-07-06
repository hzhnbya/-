<?php

namespace app\admin\controller;

use think\Controller;

class User extends Controller

{
    // 实例化
    protected $db;
    public function _initialize()
    {
        parent::_initialize();
        $this->db= new \app\common\model\User();
    }
    // 首页
    public function index()
    {
        $field= db('user')->paginate(10);
        $this->assign('field',$field);
        return $this->fetch();

    }
       //   删除
       public function del()
       {
           // 接收post数据
           $user_id = input('param.user_id');
           // halt($user_id);
           if(\app\common\model\User::destroy($user_id))
           {
              
            // 删除成功 并将该用户的留言和评论全部删除
               
                db('pl')->where('user_id',$user_id)->delete();
                db('usercomment')->where('user_id',$user_id)->delete();
                 
                 $this->success('删除成功','index');exit;
           }
           else{
               $this->error('删除失败');exit;
           }
       }

    //    评论管理
    public function pl()
    {
        $field= db('pl')->paginate(10);
        $this->assign('field',$field);
        return $this->fetch();
    }

    // 删除评论
   public function delPl()
   {
        // 接收post数据
        
        $pl_id = input('param.pl_id');
        // halt($pl_id);
        if(\app\common\model\UserPl::destroy($pl_id))
        {
            // 删除成功
            $this->success('删除成功','pl');exit;

        }
        else{
            $this->error('删除失败');exit;
        }
   }

//    留言管理
public function usercomment(){
    $field = db('usercomment')->paginate(10);
    $this->assign('field',$field);
    return $this->fetch();

}
// 删除留言
public function delComment(){
      
    $usercomment_id = input('param.usercomment_id');
    // halt($pl_id);
    if(\app\common\model\Message::destroy($usercomment_id))
    {
        // 删除成功
        $this->success('删除成功','usercomment');exit;

    }
    else{
        $this->error('删除失败');exit;
    }
}
    
}
