<?php
namespace app\index\model;

use think\Model;
/**
 * field: uid nickname phone email password 
 */
class User extends Model {
    public function addUser($data) {
        if($data['password'] != $data['password2']) {
            return [
                'code' => -1,
                'msg' => '密码不一致'
            ];
        }

        if(self::get(['phone' => $data['phone']]) != NULL) {
            return [
                'code' => -1,
                'msg' => '手机号已注册'
            ];
        }

        if(self::get(['email' => $data['email']]) != NULL) {
            return [
                'code' => -1,
                'msg' => '邮箱已注册'
            ];
        }

        $user = self::create($data);
        return [
            'code' => 0,
            'msg' => $user->id
        ];
    }
}