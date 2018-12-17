<?php


namespace app\admin\controller;


class Articleclass extends AdminControl{

    //文章管理
    public function index(){
        $articleclass_model = model('articleclass');
        dump($articleclass_model);
    }
}