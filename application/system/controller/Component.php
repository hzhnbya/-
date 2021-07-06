<?php

namespace app\system\controller;

use think\Controller;
use think\Db;
use think\Request;

class Component extends Controller
{
    // 上传文件
    public function uploader()
     {
            // echo HD_ROOT;die;
    //      获取表单上传文件 例如上传了001.jpg
    $file = request()->file('file');
    //  halt($_FILES);
     // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            $data = [
                'name' =>input('post.name'),
                'filename' =>$info->getFilename(),
                'path' =>'uploads/'.$info->getSaveName(),
                'extension' =>$info->getExtension(),
                'createtime' =>time(),
                'size' =>$info->getSize(),
            ];
                
                 Db::name('attachment')->insert($data);
                 echo json_encode(['valid'=>1,'message'=>  HD_ROOT.'uploads/'.$info->getSaveName()]);
                }else{
                     // 上传失败获取错误信息
                     echo json_encode(['valid'=>0,'message'=>$file->getError()]);
                 }
    }
    // 获取文件列表
    public function filesLists() {
        $db = Db::name('attachment')
        ->whereIn('extension',explode(',',strtolower(input("post.extensions"))))
        ->order('id desc');
        // 分页
    $Res = $db->paginate(2);
    $data =[ ];
    if( $Res->toArray())
    {
        foreach ($Res as $k => $v)
        {
            // 打印数据查看一下
            // dump( $Res->toArray());die;
            $data[$k]['createtime'] = date('Y/m/d', $v['createtime']);
            $data[$k]['size']       = $v['size'];
            $data[$k]['url ']       = HD_ROOT.$v['path'];
            $data[$k]['path']       = HD_ROOT.$v['path'];
            $data[$k]['name']       = $v['name'];
        }
    }
    echo json_encode(['data'=>$data,'page'=>$Res->render()?:'']);
    }
}
