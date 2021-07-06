<?php

namespace app\common\model;

use think\Model;

class Webset extends Model
{
    protected $pk = 'webset_id';
    protected $table = 'blog_webset';

      // 添加
      public function store($data)
      {
          //  1.验证
        //   halt($data);
         $res =  $this->validate(true)->save($data,$data['webset_id']);
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
}
