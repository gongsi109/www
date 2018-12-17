<?php

namespace app\admin\controller;

use think\Controller;

class AdminControl extends Controller{

    //管理员资料 name id group
    protected $admin_info;
    public function _initialize(){
        $this->admin_info = $this->systemLogin();
    }
    protected final function systemLogin(){
        $admin_info = array(
            'admin_id' =>session('admin_id'),
            'admin_name'=>session('admin_name'),
            'admin_gid'=> session('admin_gid'),
            'admin_is_super'=>session('admin_is_super'),
        );
        if (empty($admin_info['admin_id']) || empty($admin_info['admin_name']) || !isset($admin_info['admin_gid']) || !isset($admin_info['admin_is_super'])){
            session(null);
            $this->redirect('Admin/Login/login');
        }
        return $admin_info;
    }


    //取得当前管理员信息
    protected final function getAdminInfo(){
        return $this->admin_info;
    }


}