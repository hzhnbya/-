<?php
// 验证的类
namespace app\admin\validate;
// 继承
use think\Validate;
class Admin extends Validate
{
    // 验证规则
    protected $rule = [
    'admin_username'=>'require',
    'admin_password'=>'require',
    // 有多个验证规则时，用|隔开
    'code'=>'require|captcha'
    ];
    // 提示消息
    protected $message =[
        'admin_username.require'=>'请输入用户名',
        'admin_password.require'=>'请输入密码',
        'code.require'=>'请输入验证码',
        'code.captcha'=>'验证码不正确'
    ];
}
?>