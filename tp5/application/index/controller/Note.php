<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\User as UserModel;
use app\index\model\Note as NoteModel;

class Note extends Controller {
    protected function verify() {
        $username = session('username');
        $password = session('password');
        $userdata = UserModel::verifyIdentity($username, $password);
        if($userdata['code'] == -1) {
            return null;
        } else {
            return $userdata['data'];
        }
    }
    public function add() {
        if(($user_info = $this->verify()) == null) {
            return json([
                'code' => -1,
                'msg' => '未登入'
            ]);
        } else {
            return json(NoteModel::addOne($user_info['uid']));
        }
    }

    public function refresh() {
        if(($user_info = $this->verify()) == null) {
            return json([
                'code' => -1,
                'msg' => '未登入'
            ]);
        } else {
            $nid = input('post.nid');
            $data['title'] = input('post.title');
            $data['content'] = input('post.content');
            $data['labels'] = input('post.labels');

            return json(NoteModel::refreshOne($user_info['uid'], $nid,$data));
        }
    }
    public function publish() {
        if(($user_info = $this->verify()) == null) {
            return json([
                'code' => -1,
                'msg' => '未登入'
            ]);
        } else {
            return json(NoteModel::publicOne($user_info['uid'], input('post.nid')));
        }
    }

    public function myList() {
        if(($user_info = $this->verify()) == null) {
            return json([
                'code' => -1,
                'msg' => '未登入'
            ]);
        } else {
            $data_list = NoteModel::all(['uid' => $user_info['uid']]);
            return json([
                'code' => 0,
                'msg' => $data_list->hidden(['content'])->toArray()
            ]);
        }
    }

    public function getOneNote() {
        $data = NoteModel::get(input('post.nid'));
        if($data != NULL) {
            return json([
                'code' => 0,
                'msg' => $data->toArray()
            ]);
        } else {
            return json([
                'code' => -1,
                'msg' => '无此文章'
            ]);
        }
    }
}