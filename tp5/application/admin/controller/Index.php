<?php

namespace app\admin\controller;

use app\admin\validate\Admin as adminvalidate;
class Index extends AdminControl{

    public function Index(){

        return $this->fetch();
    }

    //修改密码
    public function modifypw(){
         if(request()->isPost()){
            $new_pw = trim(input('post.new_pw'));
            $new_pw2 = trim(input('post.new_pw2'));
            $old_pw = trim(input('post.old_pw'));
             $data = array(
                 'old_pw'=>$old_pw,
                 'new_pw'=> $new_pw,
                 'new_pw2'=> $new_pw2,
             );
//             验证数据
             $validate = new adminvalidate();
             if(!$validate->scene('editpw')->check($data)){
                 $this->error($validate->getError());
             }

             $admininfo = $this->getAdminInfo();

             //查询管理员信息
             $admin_model = model('admin');
             $admininfo = $admin_model->getOneAdmin(array('admin_id'=>$admininfo['admin_id']));
             if(!is_array($admininfo) || count($admininfo)<= 0){
                 $this->error('有错误楼候');
             }
             //旧密码是否正确
             if ($admininfo['admin_password'] != md5($old_pw)){
                 $this->error('你输入的旧密码不正确');
             }
             $new_pw = md5($new_pw);
             $result = $admin_model->editAdmin(array('admin_password'=>$new_pw),$admininfo['admin_id']);
             if($result){
                 session(null);
                 $this->redirect('Login/login');
//                 echo "<script>parent.location.href='".url('Login/login')."'</script>";
             } else {
                 $this->error('密码修改错误');
             }

         }else {
            return $this->fetch();
         }

    }




}