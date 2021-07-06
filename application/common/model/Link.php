<?php

namespace app\common\model;

use think\Model;

class Link extends Model
{
    //设置主键
    protected $pk = 'link_id';
    protected $table = 'blog_link';

    // 添加
    public function store($data)
    {
        //  1.验证
       $res =  $this->validate(true)->save($data,$data['link_id']);
        // 2.添加
        if($res)
        {
            // 添加或编辑成功
            return ['valid'=>1,'msg'=>'操作成功'];
        }
        else
        {
            return ['valid'=>0,'msg'=>$this->getError()];
        }
       
    }

    // 获取首页数据
    public function getAll()
    {
        // 按照排序降序排列并且分页
        return $this->order('link_sort desc')->paginate(3);
    }
}
