<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // '__pattern__' => [
    //     'name' => '\w+',
    // ],
    // '[hello]'     => [
    //     ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
    //     ':name' => ['index/hello', ['method' => 'post']],
    // ],
    '[admin]'=>[
        'query/userlist'=>['admin/Query/userList'],
        'query/rulelist'=>['admin/Query/ruleList'],
        'query/rolelist'=>['admin/Query/roleList'],
        'query/categorylist'=>['admin/Query/categoryList'],
        'query/articlelist'=>['admin/Query/articleList'],
        'query/j_deluser'=>['admin/Query/j_delUser'],
        'query/j_delrole'=>['admin/Query/j_delRole'],
        'query/j_delcategory'=>['admin/Query/j_delCategory'],
        'query/j_delarticle'=>['admin/Query/j_delArticle'],
        'query/detail'=>['admin/Query/detail'],
        'execute/adduser'=>['admin/Execute/addUser'],
        'execute/j_adduser'=>['admin/Execute/j_addUser'],
        'execute/addrole'=>['admin/Execute/addRole'],
        'execute/j_addrole'=>['admin/Execute/j_addRole'],
        'execute/addrule'=>['admin/Execute/addRule'],
        'execute/j_addrule'=>['admin/Execute/j_addRule'],
        'execute/addcategory'=>['admin/Execute/addCategory'],
        'execute/j_addcategory'=>['admin/Execute/j_addCategory'],
        'execute/addarticle'=>['admin/Execute/addArticle'],
        'execute/j_addarticle'=>['admin/Execute/j_addArticle'],
        'execute/edituser'=>['admin/Execute/editUser'],
        'execute/j_edituser'=>['admin/Execute/j_editUser'],
        'execute/editrole'=>['admin/Execute/editRole'],
        'execute/j_editrole'=>['admin/Execute/j_editRole'],
        'execute/editrule'=>['admin/Execute/editRule'],
        'execute/j_editrule'=>['admin/Execute/j_editRule'],
        'execute/editcategory'=>['admin/Execute/editCategory'],
        'execute/j_editcategory'=>['admin/Execute/j_editCategory'],
        'execute/editarticle'=>['admin/Execute/editArticle'],
        'execute/j_editarticle'=>['admin/Execute/j_editArticle'],
    ],
    '[index]'=>[
        'index/index'=>['index/Index/index'],
        'index/login'=>['index/Index/login'],
        'index/j_login'=>['index/Index/j_login'],
        'index/j_logout'=>['index/Index/j_logout'],
        
        'index/test'=>['index/Index/test'],
        'index/upload'=>['index/Index/upload'],
        'index/phpword'=>['index/Index/phpword'],
        'index/j_phpword'=>['index/Index/j_phpword'],
    ],
    '/' => 'index/Index/index',
    //其他路由匹配
    '__miss__' => 'index/index/missurl',

];
