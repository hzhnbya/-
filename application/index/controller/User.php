<?php

namespace app\Index\controller;


class User extends Common
{
    protected $db;
    //
    public function index()
    {
        $headConf = ['title'=>'个人中心----我的评论'];
        $this->assign('headConf',$headConf);
        $user_name= session('index.index_name');
        // halt($user_name);die;
        $plData=db('pl')
        ->alias('p')
        ->join('__ARTICLE__ a','p.arc_id=a.arc_id')
        ->where('user_name',$user_name)
        ->order('inserttime desc')
        // ->field('pl_id,arc_id,inserttime,arc_title,pl_content')
        // ->select();
        ->paginate(5);
        // $arc_id = db('pl')->where('user_name',$user_name)->find('arc_id');
        // halt($arc_id);
        // halt($plData);die;
        $this->assign('plData',$plData);
        return $this->fetch();
    }
   
    
 // 删除评论
 public function del()
 {
     $pl_id = input('param.pl_id');
    //  halt($pl_id);
     if(\app\common\model\UserPl::destroy($pl_id))
     {
         // 删除成功
         $this->redirect('index');

     }
     else{
         $this->error('删除失败');exit;
     }
 }
    // 我的留言
    public function mymessage(){
        $headConf = ['title'=>'个人中心----我的留言'];
        $this->assign('headConf',$headConf);
        $user_name= session('index.index_name');
        $messageData = db('usercomment')
        ->where('user_name',$user_name)
        ->paginate(5);
        // dump($messageData);
        $this->assign('messageData',$messageData);
        return $this->fetch();

    }

    // 删除我的留言
    public function delly()
    {
        $usercomment_id = input('param.usercomment_id');
        if(\app\common\model\Message::destroy($usercomment_id))
     {
         // 删除成功
         $this->redirect('mymessage');

     }
     else{
         $this->error('删除失败');exit;
     }
    }
}
