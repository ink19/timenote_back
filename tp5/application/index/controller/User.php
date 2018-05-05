<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User as UserModel;

class User extends Controller {
    public function register() {
        $register_data = [];
        if(NULL == ($register_data['username'] = input('post.username'))) {
            return json([
                'code' => -1,
                'msg' => '昵称不能为空'
            ]);
        }
        if(NULL == ($register_data['phone'] = input('post.phone'))) {
            return json([
                'code' => -1,
                'msg' => '手机号不能为空'
            ]);
        }
        if(NULL == ($register_data['email'] = input('post.email'))) {
            return json([
                'code' => -1,
                'msg' => '邮箱不能为空'
            ]);
        }
        if(NULL == ($register_data['password'] = input('post.password'))) {
            return json([
                'code' => -1,
                'msg' => '密码不能为空'
            ]);
        }
        if(($register_data['password'] != input('post.repassword'))) {
            return json([
                'code' => -1,
                'msg' => '重复密码不一致'
            ]);
        }
        $user = new UserModel;
        $return_data = $user->addUser($register_data);
        if($return_data['code'] == 0) {
            session('email', $register_data['email']);
            session('password', md5($register_data['password']));
        }
        return json($return_data);
    }
}