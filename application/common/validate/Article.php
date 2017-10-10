<?php
namespace app\common\validate;

use think\Validate;
class Article extends Validate
{
      protected $rule = [
        'cate_id'=>'require',
        'title'=>'require',
        'content'=>'require',
        'id'=>'require',
    ];
    protected $message = [
        'cate_id'=>'类型必须',
        'title'=>'标题必须',
        'content'=>'内容必须',
        'id'=>'主键id必须',
    ];
    protected $scene = [
        'addArticle'=>['cate_id','title','content'],
        'editArticle'=>['id','cate_id','title','content'],
        'delArticle'=>['id'],
    ];
            
}