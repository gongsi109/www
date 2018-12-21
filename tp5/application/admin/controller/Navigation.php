<?php


namespace app\admin\controller;

use app\admin\validate\Navigation as NavigationValidate;
class Navigation extends AdminControl {

    public function index(){
        $navigation_model = model('navigation');
        if(!(request()->isPost())){
            $condition=array();
            $nav_list = $navigation_model->getNavigationList($condition,10);
        } else {
            $search_nav = input('post.search_nav');
            $condition['nav_title|nav_url']=['like',"%$search_nav%"];
            $nav_list = $navigation_model->getNavigationList($condition,10);
        }
        $this->assign('nav_list',$nav_list);
        $this->assign('show_page',$navigation_model->page_info->render());
        return $this->fetch();
    }

    public function add(){
        if(!(request()->isPost())){
            $nav = [
                'nav_location'=>'header',
                'nav_new_open'=>0,
            ];
            $this->assign('nav',$nav);
            return $this->fetch('add');
        } else {
            $data['nav_title'] = input('post.nav_title');
            $data['nav_location']=input('post.nav_location');
            $data['nav_url'] = input('post.nav_url');
            $data['nav_new_open'] = intval(input('post.nav_new_open'));
            $data['nav_sort'] = intval(input('post.nav_sort'));

            $validate = new NavigationValidate();
            if (!$validate->check($data)){
                $this->error($validate->getError());
            }
            $navigation_model= model('navigation');
            $result=$navigation_model->addNavigation($data);
            if ($result) {
                $this->success('添加成功','Navigation/index');
            }else {
                $this->error('tianjianshibai');
            }
        }
    }


    public function edit(){
        $navigation_model= model('navigation');
        $nav_id = input('param.nav_id');
        if(empty($nav_id)){
            $this->error('xxxx');
        }
        if(!request()->isPost()){
            $condition = array();
            $condition['nav_id'] = $nav_id;
            $nav=$navigation_model->getOneNavigation($condition);
            $this->assign('nav', $nav);
            return $this->fetch('edit');
        } else {
            $data['nav_title'] = input('post.nav_title');
            $data['nav_location'] = input('post.nav_location');
            $data['nav_url'] = input('post.nav_url');
            $data['nav_new_open'] = intval(input('post.nav_new_open'));
            $data['nav_sort'] = intval(input('post.nav_sort'));
            $validate = new NavigationValidate();
            if (!$validate->check($data)){
                $this->error($validate->getError());
            }
            $condition = array();
            $condition['nav_id'] = $nav_id;
            $result = $navigation_model->eidtNavigation($data,$condition);
            if ($result>=0) {

                $this->success('vvvv', 'Navigation/index');
            } else {
                $this->error(lang('error'));
            }
        }

    }

    public function drop(){
        $navigation_model= model('navigation');
        $nav_id = input('param.nav_id');

        $result =$navigation_model->delNavigation($nav_id);
        if ($result) {
            $this->success('vvv');
        } else {
            $this->error('xxx');
        }
    }

}