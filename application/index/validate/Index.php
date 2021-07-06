<?php

namespace app\index\validate;

use think\Validate;

class Index extends Validate
{
     // 验证规则
     protected $rule = [
        'user_name'=>'require',
        'user_password'=>'require',
        // 有多个验证规则时，用|隔开
        'code'=>'require|captcha'
        ];
        // 提示消息
        protected $message =[
            'user_name.require'=>'请输入用户名',
            'user_password.require'=>'请输入密码',
            'code.require'=>'请输入验证码',
            'code.captcha'=>'验证码不正确'
        ];
}


?>