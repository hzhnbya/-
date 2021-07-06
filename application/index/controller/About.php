<?php

namespace app\Index\controller;

use think\Controller;

class About extends Common
{
    //
    public function index()
    {
        $headConf = ['title'=>'学码网博客--关于我'];
        $this->assign('headConf',$headConf);
       return $this->fetch();
    }
}
