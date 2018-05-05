<?php
namespace app\index\model;

use think\Model;
/**
 * field: uid nickname phone email password 
 */
class User extends Model {
    public function addUser($data) {
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
        $data['password'] = md5($data['password']);
        $data['img'] = "http://cdn.timenote.ink19.cn/head/default.png";
        $user = self::create($data);
        return [
            'code' => 0,
            'msg' => $user->hidden(['password'])->toArray()
        ];
    }
}