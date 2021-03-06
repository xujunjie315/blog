<?php
namespace app\common\validate;

use think\Validate;
class Category extends Validate
{
      protected $rule = [
        'name'=>'require',
        'id'=>'require',
    ];
    protected $message = [
        'name'=>'名称必须',
        'id'=>'主键id必须',
    ];
    protected $scene = [
        'addCategory'=>['name'],
        'editCategory'=>['id','name'],
        'delCategory'=>['id'],
    ];
            
}
