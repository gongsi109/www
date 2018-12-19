<?php


namespace app\admin\controller;

use think\Validate;
class Article extends AdminControl {

    public function index(){

        $condition = array();
        $search_ac_id = intval(input('param.search_ac_id'));
        if ($search_ac_id) {
            $condition['ac_id'] = $search_ac_id;
        }
        $search_title = trim(input('param.search_title'));
        if ($search_title) {
            $condition['article_title'] = array('like',"%".$search_title."%");
        }
        $article_model = model('article');
        $article_list = $article_model->getArticleList($condition,10);
        return $this->fetch();
    }
}