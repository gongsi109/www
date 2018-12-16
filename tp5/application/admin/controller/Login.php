<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\validate\Admin as adminvalidate;

class Login extends Controller{

    public function login(){

        if(session('admin_id')){
            $this->success('已经登录','Index/index');
        }
        if(request()->isPost()){
            $admin_name = input('post.admin_name');
            $admin_password = input('post.admin_password');
            $captcha = input('post.captcha');
            $data = array(
              'admin_name' => $admin_name,
              'admin_password' =>$admin_password,
              'captcha'=>$captcha,
            );

            //验证数据
//            $validate = new adminvalidate();
//            if(!$validate->check($data)){
//                $this->error($validate->getError());
//            }

            $condition['admin_name'] = $admin_name;
            $coondition['admin_password'] = md5($admin_password);
            $admin_mod = model('admin');
            $admin_mod->getOneAdmin();

        }else {
            return $this->fetch();
        }


    }








}