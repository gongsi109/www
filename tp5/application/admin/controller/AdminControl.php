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
//    记录系统日志
//    $lang 日志语言包
//    $state 1成功0失败 null 不出现成功失败提示
//    $admin_name
//    $admin_id
    protected final function log($lang = '',$state = 1){

        $admin_name = session('admin_name');
        $admin_id = session('admin_id');
        $data = array();
        if(is_null($state)){
            $state = null;
        } else {
            $state = $state ? '': '失败';
        }
        $data['adminlog_content'] = $lang.$state;
        $data['adminlog_time'] = TIMESTAMP;
        $data['admin_name'] = $admin_name;
        $data['admin_id'] = $admin_id;
        $data['adminlog_ip'] = request()->ip();
        $data['adminlog_url'] = request()->controller().'&'.request()->action();

        $adminlog_model = model('adminlog');
        return $adminlog_model->addAdminlog($data);
    }



}