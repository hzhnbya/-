<?php

namespace app\index\controller;
use think\Request;
use app\common\model\UserPl;
class Content extends Common
{

    //首页
    public function index()
    {     
        // 获取文章具体数据
        $arc_id = input('param.arc_id');
        // 文章点击次数+1
        db('article')->where('arc_id',$arc_id)->setInc('arc_click');
        // dump($arc_id);
        $articleData = db('article')
        ->field('arc_id,arc_title,arc_author,sendtime,arc_content,arc_click')
        ->find($arc_id);
        // $articleData = model('Article')->find($arc_id);
        $headConf = ['title'=>"学码网博客--{$articleData['arc_title']}"];
        $this->assign('headConf',$headConf);
        // dump($articleData);
        // 获取文章的标签
        $articleData['tags']= db('arc_tag')->alias('at')
        ->join('__TAG__ t','at.tag_id=t.tag_id')
        ->where('at.arc_id',$articleData['arc_id'])
        ->field('t.tag_id,t.tag_name')
        ->select();
        // dump($articleData);
        $this->assign('articleData',$articleData);
        $plData = db('pl')->where('arc_id',$arc_id)->order('inserttime desc')->paginate(5);
        // halt($plData);
        $this->assign('plData',$plData);
        return $this->fetch();
    }
    } 
   

