<?php

namespace app\common\model;
use think\Loader;
use think\Model;
use think\Validate;
class Admin extends Model
{
     protected $pk ='admin_id'; //声明主键
    //  设置当前模型对应的完整数据表名称
    protected $table ='blog_admin';

    // 登录
    public function login($data){
        // halt($data);
        // 1.执行验证
        // 调用admin验证器
        $validate = Loader::validate('Admin');
        // 如果验证不通过
    if(!$validate->check($data)){
        // 将结果返回给Login控制器 返回一个标识0和提示消息
        return ['valid'=>0,'msg'=>$validate->getError()];
        dump($validate->getError());
    }
        // 2.比对用户名和密码是否正确
        $userInfo=$this->where('admin_username',$data['admin_username'])->where('admin_password',$data['admin_password'])->find();
        // 如果账号密码都正确则会返回数据 否则会返回null
        // halt($userInfo);
        //  可以根据返回的是否为空来判断是否找到数据
        if(!$userInfo){
            // 说明在数据库未匹配到相关数据
            return ['valid'=>0,'msg'=>'用户名或者密码不正确'];
        }
        // 3.将用户的信息存入到session中
        session('admin.admin_id',$userInfo['admin_id']);
        session('admin.admin_username',$userInfo['admin_username']);
        // 将结果返回给Login控制器 返回一个标识1和提示消息
        return ['valid'=>1,'msg'=>'登录成功'];
    }
    // 修改密码
    // $date 为post传过来的数据
    public function pass($data)
    {
        // 1.执行验证
        $validate = new Validate([
            'admin_password'  => 'require',
            'new_password' => 'require',
            // 当确认密码和新密码输入不一致的时候 手册中的 confirm 规则
            'confirm_password'=>'require|confirm:new_password'
        ],[
            'admin_password.require'=>'请输入原始密码',
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
        $userInfo = $this->where('admin_id',session('admin.admin_id'))->where('admin_password',$data['admin_password'])->find();
        // 如果找不到 则密码错误
        if(!$userInfo)
        {
            return ['valid'=>0,'msg'=>'原始密码不正确'];
        }
        // 3.修改密码
        // 手册 模型->更新

        // save方法第二个参数为更新条件
       $res=$this->save([
        'admin_password'=> $data['new_password'],
        ],[$this->pk => session('admin.admin_id')]);
        // halt($res);
        if($res)
        {
            return ['valid'=>1,'msg'=>'密码修改成功'];
        }else{
            return ['valid'=>0,'msg'=>'密码修改失败'];
        }
    }
    }
        
    
    

