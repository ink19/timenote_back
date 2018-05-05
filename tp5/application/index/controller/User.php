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
            session('username', $register_data['username']);
            session('password', md5($register_data['password']));
        }
        return json($return_data);
    }

    public function login() {
        if(NULL == ($login_data['username'] = input('post.username'))) {
            return json([
                'code' => -1,
                'msg' => "用户名不能为空"
            ]);
        } 

        if(NULL == ($login_data['password'] = input('post.password'))) {
            return json([
                'code' => -1,
                'msg' => "密码不能为空"
            ]);
        }
        $login_data['password'] = md5($login_data['password']);
        if(NULL == ($user = UserModel::get($login_data))) {
            return json([
                'code' => -1,
                'msg' => "用户名或密码错误"
            ]);
        } else {
            session('username', $login_data['username']);
            session('password', md5($login_data['password']));
            return json([
                'code' => 0,
                'msg' => $user->hidden(['password'])->toArray()
            ]);
        }
    }

    public function isLogin() {
        $session_data['username'] = session('username');
        $session_data['password'] = session('password');
        if(NULL == ($user = UserModel::get($session_data))) {
            return json([
                'code' => -1,
                'msg' => '未登入'
            ]);
        } else {
            return json([
                'code' => 0,
                'msg' => $user->hidden(['password'])->toArray()
            ]);
        }
    }
}