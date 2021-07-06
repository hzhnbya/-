<?php

namespace app\common\model;

use think\Model;

class Tag extends Model
{
    //申明主键
    protected $pk ='tag_id';
    protected $table ='blog_tag';//要操作的数据表

    // 添加标签
    public function store($data)
    {
        // 1.验证
        // 2.执行验证 
        // 当为添加时 只传过来一个数据 tag_id 为空  编辑时为两个参数
       $result = $this->validate(true)->save($data,$data['tag_id']);
        if($result)
        {
             // 验证成功
            return ['valid'=>'1','msg'=>'操作成功'];
        }else{
            // 验证失败
            return ['valid'=>'0','msg'=>$this->getError()];
        }
    }
}
