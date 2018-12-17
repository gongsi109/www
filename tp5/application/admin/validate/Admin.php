<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        ['admin_name','require|min:5','账号为必填|账号长度至少为5位'],
        ['admin_password','require|min:6','密码为必填|密码长度至少为6位'],
        ['captcha','require|min:3|captcha','验证码为必填|验证码长度至少为3位|验证码错误'],
        ['old_pw','require','原密码不能为空'],
        ['new_pw','require|min:6','新密码必填|密码长度至少味为6位'],
        ['new_pw2','require|confirm:new_pw','确认密码必填|两次密码输入不一致'],

    ];

    protected $scene = [
        'login' => ['admin_name','admin_password','captcha'],
        'editpw'=>['old_pw','new_pw','new_pw2'],
    ];


}