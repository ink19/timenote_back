<?php
namespace app\index\model;

use think\Model;

/**
 * nid title labels content create_time modify_time uid status
 * status: 0 正常 1 草稿
 * 
 */

class Note extends Model {
    protected $createTime = false;
    protected $resultSetType = 'collection';
    public static function refreshOne($uid, $id, $data) {
        $noteM = self::get($id);
        if(NULL == $noteM) {
            return [
                'code' => -1,
                'msg' => '此文章不存在'
            ];
        }
        if($noteM->uid != $uid) {
            return [
                'code' => -1,
                'msg' => '您没有权限更改这篇文章'
            ];
        }
        $data['modify_time'] = time();
        $noteM->save($data);
        return [
            'code' => 0,
            'msg' => '更新成功'
        ];
    }

    public static function addOne($uid) {
        $noteM = self::create([
            'title' => '未命名',
            'uid' => $uid,
            'modify_time' => time(),
            'create_time' => time(),
            'status' => 1
        ]);
        if($noteM == NULL) {
            return [
                'code' => -1,
                'msg' => '添加失败'
            ];
        } else {
            return [
                'code' => 0,
                'msg' => $noteM->hidden(['uid', 'status'])->toArray()
            ];
        }
    }

    public static function publicOne($uid, $id) {
        $noteM = self::get($id);
        if(NULL == $noteM) {
            return [
                'code' => -1,
                'msg' => '此文章不存在'
            ];
        }
        if($noteM->uid != $uid) {
            return [
                'code' => -1,
                'msg' => '您没有权限更改这篇文章'
            ];
        }

        $noteM->save([
            'status' => 0
        ]);
        return [
            'code' => 0,
            'msg' => '关系成功'
        ];
    }

    public static function deleteOne($uid, $id) {
        $noteM = self::get($id);
        if(NULL == $noteM) {
            return [
                'code' => -1,
                'msg' => '此文章不存在'
            ];
        }
        if($noteM->uid != $uid) {
            return [
                'code' => -1,
                'msg' => '您没有权限更改这篇文章'
            ];
        }

        $noteM->delete();
        return [
            'code' => 0,
            'msg' => '删除成功'
        ];
    }

    public function getSummaryAttr($value,$data) {
        return mb_strcut($data['content'], 0, 100);
    }
}