<?php
namespace app\common\validate;

use think\Validate;
class Rule extends Validate
{
      protected $rule = [
        'name'=>'require',
        'enabled'=>'require',
        'id'=>'require',
    ];
    protected $message = [
        'name'=>'规则名称必须',
        'enabled'=>'是否为公共路由必须',
        'id'=>'主键id必须',
    ];
    protected $scene = [
        'addRule'=>['name','enabled'],
        'editRule'=>['id','name','enabled'],
    ];
            
}