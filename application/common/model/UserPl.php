<?php

namespace app\common\model;
use traits\model\SoftDelete;

use think\Model;
use think\Validate;

class UserPl extends Model
{
 
   protected $pk = 'pl_id';
    protected $table = 'blog_pl';
    //  自动完成 手册
    
    protected $insert= ['inserttime'];
    protected function setInsertTimeAttr($value)
    {
        // 获取时间戳
        return time();
    }

    public function addPl($data)
    {
        $validate = new Validate([
            'pl_content'=>'require'
        ],[
            'pl_content.require'=>'请输入评论内容'
        ]);
        if (!$validate->check($data)) {
            // 如果验证不通过 返回给控制器一个标识还有提示信息
            return ['valid'=>0,'msg'=>$validate->getError()];
            // dump($validate->getError());
    }
    $info = $this->allowField(true)->save($data);
        if($info)
        {
            return ['valid'=>1,'msg'=>'评论成功'];
        }else{
            return ['valid'=>0,'msg'=>'评论失败'];
        }
}
    
}
