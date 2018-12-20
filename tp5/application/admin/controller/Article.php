<?php


namespace app\admin\controller;

use app\admin\validate\Article as ArticleValidate;
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



        $articleclass_model = model('articleclass');
        $parent_list = $articleclass_model->getTreeClassList();

        if(is_array($article_list)){
            $class_list = $articleclass_model->getArticleclassList();
            $tmp_class_name = array();
            if(is_array($class_list)){
                foreach($class_list as $k => $v){
                    $tmp_class_name[$v['ac_id']] = $v['ac_name'];
                }
            }
            foreach ($article_list as $k => $v) {
                $article_list[$k]['article_time'] = date('Y-m-d H:i:s',$v['article_time']);
                if(@array_key_exists($v['ac_id'],$tmp_class_name)){
                    $article_list[$k]['ac_name'] = $tmp_class_name[$v['ac_id']];
                }
            }
        }

        foreach ($parent_list as $k => $v){
            $parent_list[$k]['ac_name'] = str_repeat("--l",$v['deep']*2).$v['ac_name'];
        }
        $this->assign('parent_list',$parent_list);
        $this->assign('article_list',$article_list);
        $this->assign('show_page',$article_model->page_info->render());
        $this->assign('filtered',$condition ? 1:0);
        return $this->fetch();
    }

    public function add(){
        if (request()->isPost()){
            $data = array(
                'article_title' => input('post.article_title'),
                'ac_id' => input('post.ac_id'),
                'article_sort'=>input('post.article_sort'),
                'article_url'=>input('post.article_url'),
                'article_content'=>input('post.article_content'),
                'article_time'=>TIMESTAMP,
                'article_show'=>intval(input('post.article_show')),
            );
            $validate = new ArticleValidate($data);
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            $result = model('article')->addArticle($data);
            if ($result) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }

        } else {

            $articleclass_model = model('articleclass');
            $cate_list = $articleclass_model->getTreeClassList();
            $this->assign('ac_list',$cate_list);
            return $this->fetch('form');
        }
    }

    public function edit(){
        $art_id = intval(input('param.article_id'));
        if($art_id<=0){
            $this->error('错误');
        }
        if(!request()->isPost()){
            $condition = array();
            $condition['article_id'] = $art_id;
            $article = model('article')->getOneArticle($condition);
            $this->assign('article',$article);
            $articleclass_model = model('articleclass');
            $cate_list = $articleclass_model->getTreeClassList();
            $this->assign('ac_list',$cate_list);
            return $this->fetch('edit');
        } else {
            $data = array(
                'article_title' => input('post.article_title'),
                'ac_id' => input('post.ac_id'),
                'article_sort'=>input('post.article_sort'),
                'article_content'=>input('post.article_content'),
                'article_url'=>input('post.article_url'),
                'article_time'=>TIMESTAMP,
                'article_show'=>intval(input('post.article_show')),
            );
            $validate = new ArticleValidate($data);
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }

            $result= model('article')->editArticle($data,$art_id);
            if ($result) {
                $this->success('xiugai成功');
            } else {
                $this->error('xiugai失败');
            }
        }
    }

    public function drop(){
        $article_id = input('param.article_id');
        if(empty($article_id)){
            $this->error('没有这个产品');
        }
        $result = model('article')->delArticle($article_id);
        if($result){
            $this->success('删除成功','Article/index');
        } else {
            $this->error('删除失败');
        }
    }


}