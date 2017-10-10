<?php
namespace app\common\validate;

use think\Validate;
class User extends Validate
{
      protected $rule = [
        'name'=>'require',
        'uname'=>'require',
        'password'=>'require',
        'password_confirm'=>'require|confirm:password',
       'role_id'=>'require',
       'id'=>'require',
    ];
    protected $message = [
        'name'=>'角色名称必须',
        'uname'=>'账号必须',
        'password.require'=>'密码必须',
        'password_confirm'=>'两次密码不一样',
        'role_id'=>'角色id必须',
        'id'=>'主键id必须',
    ];
    protected $scene = [
        'addUser'=>['name','uname','password','password_confirm','role_id'],
        'login'=>['uname','password'],
        'editUser'=>['id','name','uname','password','password_confirm','role_id'],
        'delUser'=>['id'],
    ];
            
}