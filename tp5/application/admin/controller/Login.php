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
            $validate = new adminvalidate();
            if(!$validate->scene('login')->check($data)){
                $this->error($validate->getError());
            }

            $condition['admin_name'] = $admin_name;
            $coondition['admin_password'] = md5($admin_password);

            $admin_mod = model('admin');
            $admin_info = $admin_mod->getOneAdmin($condition);
            if(is_array($admin_info) and !empty($admin_info)){
              //更新admin最新信息
                $update_info = array(
                    'admin_login_num' => ($admin_info['admin_login_num'] + 1),
                    'admin_login_time' => TIMESTAMP
                );
                $admin_mod->editAdmin($update_info,$admin_info['admin_id']);

                //设置session
                session('admin_id',$admin_info['admin_id']);
                session('admin_name',$admin_info['admin_name']);
                session('admin_gid',$admin_info['admin_gid']);
                session('admin_is_super',$admin_info['admin_is_super']);

                $this->success('登录成功','Index/index');
            } else {
                $this->error('账号密码错误');
            }

        }else {
            return $this->fetch();
        }


    }

    public function logout(){
        //设置 session
        session(null);
        $this->success('退出成功','Login/login');
    }








}