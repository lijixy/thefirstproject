<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Customer extends Controller {

    public function index() {
        $getAdminName = session("adminName");
        if (!$getAdminName) {
            return redirect("login/index");
        }
        $data = Request::instance()->get();
        $where = [];

        //封装where查询条件
        (empty($data['status']) || $data['status'] == '') || $where['status'] = $data['status'];
        empty($data['contact']) || $where['contact'] = ['like', '%' . $data['contact']];
        empty($data['name']) || $where['name'] = ['like', '%' . $data['name']];
        empty($data['phone']) || $where['phone'] = $data['phone'];
        empty($data['eamil']) || $where['eamil'] = $data['eamil'];
        empty($data['sn']) || $where['sn'] = $data['sn'];

        $result = Db::table("customer")->where($where)->paginate(10);
        $this->assign(['list' => $result]);
        return view();
    }

    public function create() {
        return view();
    }

    public function save() {
        Request::instance()->isPost() || die('request not  post!');

        $param = Request::instance()->param(); //获取参数



        if ($param) {

            if (Db::table("product")->where("sn", $param["sn"])->find()) {
                return ['error' => 100, 'msg' => '内部编码已存在'];
                exit();
            }

            $product['sn'] = $param['sn'];
            $product['name'] = $param['name'];
            $product['address'] = $param['address'];
            $product['contact'] = $param['contact'];
            $product['phone'] = $param['phone'];
            $product['email'] = $param['email'];
            $product['fax'] = $param['fax'];
            $product['desc'] = $param['desc'];
            $product['add_time'] = time();

            if (Db::table("customer")->insert($product)) {

                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => '参数不能为空'];
        }
    }

    public function edit($id) {
        $getParam = Request::instance()->get("id");
        $result = Db::table("customer")->where("id", $getParam)->find();
        $this->assign(['info' => $result]);
        return view();
    }

    public function update() {
        Request::instance()->isPost() || die('request not  post!');

        $param = Request::instance()->param(); //获取参数
        if ($param) {
            if (Db::table("customer")->where("id", $param["id"])->update([
                        'name' => $param['name'],
                        'address' => $param['address'],
                        'contact' => $param['contact'],
                        'phone' => $param['phone'],
                        'email' => $param['email'],
                        'fax' => $param['fax'],
                        'desc' => $param['desc'],
                        'status' => $param['status'],
                    ])) {
                return ['error' => 0, 'msg' => '修改成功'];
            } else {
                return ['error' => 100, 'msg' => '修改失败'];
            }
        } else {
            return ['error' => 100, 'msg' => '参数不能为空'];
        }
    }

    public function delete($id) {
        $getParam = Request::instance()->post("id");
        if (Db::table("customer")->where("id", $getParam)->delete()) {

            return ['error' => 0, 'msg' => '删除成功'];
        } else {
            return ['error' => 100, 'msg' => '删除失败'];
        }
    }

}
