<?php

namespace app\common\model;

use think\Model;

class User extends Model
{
    //
      //申明主键
      protected $pk ='user_id';
      protected $table ='blog_user';//要操作的数据表
}
