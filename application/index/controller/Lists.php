<?php

namespace app\index\controller;

use app\common\model\Category;

class Lists extends Common
{
    //加载首页
    public function index()
    {
        $headConf = ['title'=>'学码网博客--列表页'];
        $this->assign('headConf',$headConf);
        // 获取左侧第一部分的数据
        $cate_id = input('param.cate_id');
        // 
        $tag_id = input('param.tag_id');
        if($cate_id)
        {
            // 1.获取当前分类所有子集分类id
            $cids =(new Category())->getSon(db('cate')->select(),$cate_id);
            $cids[] = $cate_id; //将自己追加进去
            $headData =  [
                'title'=>'分类',
                'name'=>db('cate')->where('cate_id',$cate_id)->value('cate_name'),
                'total'=>db('article')->where('is_recycle',2)->whereIn('cate_id',$cids)->count(),
            ];
            // halt($headData);
            // 2.获取包含该分类的文章数据
            $articleData = db('article')->alias('a')
            ->join('__CATE__ c','a.cate_id=c.cate_id')
            ->where('a.is_recycle',2)
            ->whereIn('a.cate_id',$cids)
            ->paginate(2);
              // 2.关联标签表
              $items = $articleData->items();
            // dump($articleData);
      
        }
        if($tag_id)
        {
            $headData =  [
                'title'=>'标签',
                'name'=>db('tag')->where('tag_id',$tag_id)->value('tag_name'),
                'total'=>db('arc_tag')->where('tag_id',$tag_id)->count(),
            ];
            // halt($headData);
            // 获取包含该标签的文章数据
            $articleData = db('article')->alias('a')
            ->join('__ARC_TAG__ at','a.arc_id=at.arc_id')
            ->join('__CATE__ c','a.cate_id=c.cate_id')
            ->where('a.is_recycle',2)
            ->where('at.tag_id',$tag_id)
            ->paginate(2);
            // dump($articleData);
        }
        $items = $articleData->items();
        foreach($articleData as $k=>$v)
        {
            $items[$k]['tags']=db('arc_tag')
            ->alias('at')
            ->join('__TAG__ t','at.tag_id=t.tag_id')
            ->where('at.arc_id',$v['arc_id'])
            ->field('t.tag_id,t.tag_name')->select();
        }
        $this->assign('items',$items);
        $this->assign('headData',$headData);
        $this->assign('articleData',$articleData);
        return $this->fetch();
    }
}
