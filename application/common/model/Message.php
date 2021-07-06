<?php

namespace app\common\model;

use think\Model;
use think\Validate;
class Message extends Model
{
    //
    protected $pk = 'usercomment_id';
    protected $table = 'blog_usercomment';
    //  自动完成 手册
    
    protected $insert= ['commenttime'];
    protected function setCommentTimeAttr($value)
    {
        return time();
    }
    public function addMes($data)
    {
        {
            $validate = new Validate([
                'user_comment'=>'require'
            ],[
                'user_comment.require'=>'请输入评论内容'
            ]);
            if (!$validate->check($data)) {
                // 如果验证不通过 返回给控制器一个标识还有提示信息
                return ['valid'=>0,'msg'=>$validate->getError()];
                // dump($validate->getError());
        }
        $info = $this->allowField(true)->save($data);
            if($info)
            {
                return ['valid'=>1,'msg'=>'留言成功'];
            }else{
                return ['valid'=>0,'msg'=>'留言失败'];
            }
    }
    }
}
