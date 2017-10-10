<?php
namespace app\common\validate;

use think\Validate;
class Role extends Validate
{
      protected $rule = [
        'name'=>'require',
        'id'=>'require',
    ];
    protected $message = [
        'name'=>'角色名称必须',
        'id'=>'主键id必须',
    ];
    protected $scene = [
        'addRole'=>['name'],
        'editRole'=>['id','name'],
        'delRole'=>['id'],
    ];
            
}

