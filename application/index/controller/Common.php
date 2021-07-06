<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
class Common extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        // 执行登录验证
        // 检测是否登录
        // if(!session('index.index_id'))
        // {
        //     // 未登录 跳转到登录页面
        //     $this->redirect('index/login/index');
        // }
        // 1.读取配置项
        $webset = $this->loadWebSet();
            // halt($webset);
            $this->assign('_webset',$webset);
        // 2.获取顶级栏目数据
        $cateData = $this->loadCateData();
        // halt($cateData);
            $this->assign('_cateData',$cateData);
        // 3.获取全部栏目数据
        $allCateData = $this->loadAllCataData();
        // halt($allCateData);
            $this->assign('_allCateData',$allCateData);
        // 4.获取标签数据
        $tagData = $this->loadTagData();
        // halt($tagData);
            $this->assign('_tagData',$tagData);
        // 5.获取最新文章
        $artData = $this->loadArcData();
        // halt($artData);
        $this->assign('_artData',$artData);
        // 6.获取最热文章
        $artHotData = $this->loadArtHotData();
        $this->assign('_artHotData',$artHotData);
        // 7.获取友情链接
        $linkData = $this->loadLinkData();
        // halt($linkData);
        $this->assign('_linkData',$linkData);
        // 7.获取评论列表
        // $plData = $this->loadAllPlData();
        // $this->assign('_plData',$plData);
    }




    // 读取配置项
    private function loadWebSet()
    {
        //  获取指定字段
        return db('webset')->column('webset_value','webset_name');
    }
    // 读取顶级栏目数据
    private function loadCateData()
    {
        return db('cate')->where('cate_pid',0)->order('cate_sort desc')->select();
    }
    // 获取全部栏目
    private function loadAllCataData()
    {
        return db('cate')->order('cate_sort desc')->select();
    }
    // 获取标签
    private function loadTagData()
    {
        return db('tag')->select();
    }
    // 获取最新文章
    private function loadArcData()
    {
        //  最新文章需要 标题 时间 id 需要是最新文章
        return db('article')->order('sendtime desc')->limit(3)->field('arc_id,arc_title,sendtime')->select();
    }

    private function loadArtHotData()
    {
        return db('article')->where('is_recycle',2)->order('arc_click desc')->limit(10)->field('arc_id,arc_title')->select();
    }
    // 获取友情链接
    private function loadLinkData()
    {
        return db('link')->order('link_sort desc')->select();
    }
    // 获取评论数据
    // private function loadAllPlData()
    // {
    //     return db('pl')->select();
    // }
}
