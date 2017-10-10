<?php
namespace app\index\controller;

use think\Controller;
use PhpWord;
//use PhpOffice\PhpWord;

class Index extends Controller
{
    protected $user;
    protected $category;
    protected $article;
    
    protected function _initialize()
    {
        $this->user = model('user');
        $this->category = model('category');
        $this->article = model('article');
        $cateListP = $this->category->getCateList();
        $cateList = $this->category->getCate();
        $this->assign('cateListP',$cateListP);
        $this->assign('cateList',$cateList);
    }
    public function test(){
        return $this->fetch();
    }
    public function upload(){
         $file = request()->file('image');
        $info = $file->move(ROOT_PATH . 'public/static/upload');
        print_r($info);die;
    }
    public function missurl()
    {
        return '<style type="text/css">*{ padding: 0; margin: 0; } .think_default_text{ padding: 4px 48px;} a{color:#2E5CD5;cursor: pointer;text-decoration: none} a:hover{text-decoration:underline; } body{ background: #fff; font-family: "Century Gothic","Microsoft yahei"; color: #333;font-size:18px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.6em; font-size: 42px }</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>您访问的地址不存在！<br/><span style="font-size:30px">十年磨一剑 - 为API开发设计的高性能框架</span></p><span style="font-size:22px;">[ V5.0 版本由 <a href="http://www.qiniu.com" target="qiniu">七牛云</a> 独家赞助发布 ]</span></div><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_bd568ce7058a1091"></thinkad>';
    }
    public function index()
    {
        $id = input('param.id');
        $cateId = input('param.cate_id');
        if(isset($cateId)){
            $catecur = $this->category->where('id',$cateId)->find();
            $articleList = collection($this->article->where('cate_id',$cateId)->field('id,title')->select())->toArray();
            $this->assign('catecur',$catecur);
            $this->assign('articleList',$articleList);
        }
        $article = $this->article->where('id',$id)->field('id,views,title,content,cate_id,create_time')->find();
        $views = $article['views']+1;
        $this->article->where('id',$id)->update(['views'=>$views]);
        $hotArticle = $this->article->order('views desc')->limit(10)->field('id,views,title,content,cate_id,create_time')->select();
        $this->assign('hotArticle',$hotArticle);
        $this->assign('article',$article);
        return $this->fetch();
    }
    public function login()
    {
        return $this->fetch();
    }
    public function j_login(){
        $input = input('param.');
        $validate = Validate('User');
        if(!$validate->scene('login')->check($input)){
            $code = 422;
            $msg = $validate->getError();
            return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
        }
        $userInfo = $this->user->where('uname',$input['uname'])->find();
        if(pass_verify($input['password'],$userInfo['password'])){
            session('user',$userInfo);
            $code = 200;
            $msg = '登录成功';
        }else{
            $code = 401;
            $msg = '登录失败';
        }
        return json(['data'=>'','code'=>$code,'msg'=>$msg],$code);
    }
    public function j_logout(){
        session('user',null);
        $this->redirect('index/index/login');
    }
    public function phpword(){
        return $this->fetch();
    }
    public function j_phpword(){
//        Vendor("PHPWord-develop.src.PhpWord.PhpWord");
//        require_once '../vendor/PHPWord-develop/src/PhpWord/PhpWord.php';
        $PHPWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $PHPWord->createSection();
        $section->addText('Hello world!');
        $section->addText('Hello world! I am formatted.', array('name'=>'Tahoma', 'size'=>16, 'bold'=>true));
        $PHPWord->addFontStyle('myOwnStyle', array('name'=>'Verdana', 'size'=>14, 'color'=>'1B2232'));
        $section->addText('Hello world! I am formatted by a user defined style', 'myOwnStyle');
        $myTextElement = $section->addText('Hello World!');
        $myTextElement->setBold();
        $myTextElement->setName('Verdana');
        $myTextElement->setSize(22);
        $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        $objWriter->save('helloWorld.docx');
    }
}
