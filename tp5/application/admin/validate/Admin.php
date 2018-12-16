<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        ['admin_name','require|min:5','账号为必填|账号长度至少为5位'],
        ['admin_password','require|min:6','密码为必填|密码长度至少为6位'],
        ['captcha','require|min:3|captcha','验证码为必填|验证码长度至少为3位|验证码错误'],
    ];

}