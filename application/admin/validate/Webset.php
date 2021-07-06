<?php
namespace app\admin\validate;
use think\Validate;

class Webset extends Validate
{
    protected $rule = [
        'webset_name'=>'require',
        'webset_value'=>'require',
        'webset_des'=>'require'
    ];
    protected $message = [
        'webset_name.require'=>'请输入配置名称',
        'webset_value.require'=>'请输入配置值',
        'webset_des.require'=>'请输入配置描述',
        
    ];
}
?>