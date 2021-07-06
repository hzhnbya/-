<?php

namespace app\common\model;

use think\Loader;
use think\Model;
use think\Validate;

class Index extends Model
{
    //申明主键
    protected $pk = 'user_id';
    protected $table = 'blog_user';

    // 登录
    public function login($data)
    {
        // halt($data);
        // 1.执行验证
        $validate = Loader::validate('Index');
        // 如果验证不通过
        if(!$validate->check($data))
        {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        // 2.比较验证
       $info =  $this->where('user_name',$data['user_name'])->where('user_password',$data['user_password'])->find();
    //    halt($info); 
    // 根据$info返回的是否为空 来确定用户名和密码是否正确
        if(!$info)
        {
            // 说明为空 
            return ['valid'=>0,'msg'=>'用户名或密码不正确'];
        }
       // 3.将用户信息存入session
       session('index.index_id',$info['user_id']);
       session('index.index_name',$info['user_name']);
       return ['valid'=>1,'msg'=>'登录成功'];
    }
     // 修改密码
    // $date 为post传过来的数据
    public function pass($data)
    {
        // 1.执行验证
        $validate = new Validate([
            'user_name'=>'require',
            'user_password'  => 'require',
            'new_password' => 'require',
            // 当确认密码和新密码输入不一致的时候 手册中的 confirm 规则
            'confirm_password'=>'require|confirm:new_password'
        ],[
            'user_name.require'=>'请输入用户名',
            'user_password.require'=>'请输入原始密码',
            'new_password.require'=>'请输入新密码',
            'confirm_password.require'=>'请输入确认密码',
            'confirm_password.confirm'=>'确认密码和新密码不一致',

            ]);
        if (!$validate->check($data)) {
            // 如果验证不通过 返回给控制器一个标识还有提示信息
            return ['valid'=>0,'msg'=>$validate->getError()];
            // dump($validate->getError());
        }
    
        // 2.原始密码是否正确
        //  查找密码
        $userInfo = $this->where('user_id',session('index.index_id'))
        ->where('user_password',$data['user_password'])
        ->find();
        // 如果找不到 则密码错误
        if(!$userInfo)
        {
            return ['valid'=>0,'msg'=>'原始密码不正确'];
        }
        // 3.修改密码
        // 手册 模型->更新

        // save方法第二个参数为更新条件
       $res=$this->save([
        'user_name'=>$data['user_name'],
        'user_password'=> $data['new_password'],
        ],[$this->pk => session('index.index_id')]);
        // halt($res);
        
        if($res)
        {
            session('index.index_name',$data['user_name']);
            return ['valid'=>1,'msg'=>'信息修改成功'];
        }else{
            return ['valid'=>0,'msg'=>'信息修改失败'];
        }
    }
    // 注册
    public function addUser($data)
    {
        // halt($data);
        $validate = new Validate ([
            // 'user_name'=>'unique',
            'user_name'=>'require|unique:user',
            'user_password'=>'require',
            // 有多个验证规则时，用|隔开
            'user_email'=>'require|email'
        ],
            // 提示消息
        [
                'user_name.unique'=>'该用户名已存在，请重新输入',
                'user_name.require'=>'请输入用户名',
                'user_password.require'=>'请输入密码',
                'user_email.require'=>'请输入邮箱',
                'user_email.email'=>'邮箱格式不正确'
            ]);
            if (!$validate->check($data)) {
                // 如果验证不通过 返回给控制器一个标识还有提示信息
                return ['valid'=>0,'msg'=>$validate->getError()];
                // dump($validate->getError());
    }
        $info = $this->db('user')->insert($data);
        if($info)
        {
            return ['valid'=>1,'msg'=>'用户注册成功'];
        }else{
            return ['valid'=>0,'msg'=>'用户注册失败'];
        }
}
}
