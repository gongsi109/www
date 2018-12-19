<?php


namespace app\admin\controller;

use app\admin\validate\Articleclass as ArticleclassValidate;


class Articleclass extends AdminControl{

    //文章管理
    public function index(){
        $articleclass_model = model('articleclass');
        //列表
        $class_list = $articleclass_model->getTreeClassList();
        $this->assign('class_list',$class_list);
        return $this->fetch('article_class_index');
    }

    //文章分类编辑
    public function article_class_edit($id){
        $articleclass_model = model('articleclass');
        if(request()->isPost()){
            $data = [
                'ac_name'=>trim(input('param.ac_name')),
                'ac_sort'=>trim(input('param.ac_sort')),
            ];
            $validate = new ArticleclassValidate();
            if(!$validate->scene('edit')->check($data)){
                $this->error($validate->getError());
            }
            $result = $articleclass_model->editArticleclass($data,$id);
            if($result>=0){
                $log_id = $this->log('修改文章分类'.$data['ac_name'],1);
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }
            dump($data);
        }else{
            $class_array = $articleclass_model->getOneArticleclass($id);
            if(empty($class_array)){
                $this->error('有错误');
            }
            $this->assign('class_array',$class_array);

            return $this->fetch('article_class_edit');
        }
    }

    //文章分类添加
    public function article_class_add(){
        $articleclass_model = model('articleclass');
        if(request()->isPost()){
            $data = [
              'ac_name'=>trim(input('param.ac_name')),
              'ac_sort'=>trim(input('param.ac_sort')),
              'ac_parent_id'=>trim(input('param.ac_parent_id')),
            ];
            $validate = new ArticleclassValidate();
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());
            }
            $result =  $articleclass_model->addArticleclass($data);
            if($result>0){
                $log_id = $this->log('添加文章分类'.$data['ac_name'],1);
                $this->success('新增成功');
            }
        } else {
            $class_list = $articleclass_model->getTreeClassList();
            $this->assign('class_list',$class_list);
            return $this->fetch('article_class_add');
        }
    }

//    删除分类
    public function article_class_del($id){
        $articleclass_model = model('articleclass');
        $del_array = $articleclass_model->getChildClass($id);
        $articleclass_model->delArticleclass($id);
        if(is_array($del_array)){
            foreach($del_array as $k => $v) {
                $articleclass_model->delArticleclass($v);
            }
        }
        $this->log('删除分类id:'.$id,1);

        return ['msg'=>'删除成功'];


    }





}