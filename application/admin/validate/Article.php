<?php
namespace app\admin\validate;
use think\Validate;
class Article extends Validate
{
    // 定义规则
    protected $rule = [
        'arc_title' => 'require',
        'arc_author' => 'require',
        'arc_sort' =>'require|between:1,9999',
        // 分类规则：不能为请选择的时候
        'cate_id'=>'notIn:0',
        'arc_thumb' =>'require',
        'arc_digest' => 'require',
        'arc_content'=>'require',
    ];
    // 提示消息
    protected $message = [
        'arc_title.require'=>'请输入文章标题',
        'arc_author.require'=>'请输入文章的作者',
        'arc_sort.require'=>'请输入文章的排序',
        'arc_sort.between'=>'只能输入1-9999',
        'cate_id.notIn'=>'请选择文章的分类',
        'arc_thumb.require'=>'请上传文章的图片',
        'arc_digest.require'=>'请输入文章的摘要',
        'arc_content.require'=>'请输入文章的内容'
    ];
}
?>