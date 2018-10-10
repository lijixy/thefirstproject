<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Db;

class Product extends Controller {

    public function index() {
        $getAdminName = session("adminName");
        if (!$getAdminName) {
            return redirect("login/index");
        }
        $data = Request::instance()->get();
        $where = [];

        //封装where查询条件
        (empty($data['status']) || $data['status'] == '') || $where['status'] = $data['status'];
        empty($data['name']) || $where['name'] = ['like', '%' . $data['name']];
        empty($data['sn']) || $where['sn'] = $data['sn'];


        $result = Db::table("product")->where($where)->paginate(5);
        $this->assign(['list' => $result]);
        return view();
    }

    public function lists() {
        $this->index();
        return view();
    }

    public function create() {
        //$this->assign($this->service->_init());
        return view();
    }

    public function save() {
        Request::instance()->isPost() || die('request not  post!');

        $param = Request::instance()->param(); //获取参数



        if ($param) {

            if (Db::table("product")->where("nbsn", $param["nbsn"])->find()) {
                return ['error' => 100, 'msg' => '内部编码已存在'];
                exit();
            }

            $product['sn'] = $param['sn'];
            $product['nbsn'] = $param['nbsn'];
            $product['cjsn'] = $param['cjsn'];
            $product['name'] = $param['name'];
            $product['price'] = $param['price'];
            $product['desc'] = $param['desc'];
            $product['importtime'] = $param['importtime'];
            $product['importnum'] = $param['importnum'];
            $product['add_time'] = time();
            $product['spec'] = $param['spec'];
            $product['category'] = $param['category'];
            $product['status'] = $param['status'];

            if (Db::table("product")->insert($product)) {

                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => '参数不能为空'];
        }
    }

    public function edit() {
        $getParam = Request::instance()->get("id");
        $result = Db::table("product")->where("id", $getParam)->find();
        $this->assign(['info' => $result]);
        return view();
    }

    public function update() {

        Request::instance()->isPost() || die('request not  post!');

        $param = Request::instance()->param(); //获取参数
        if ($param) {
            if (Db::table("product")->where("id", $param["id"])->update([
                        'nbsn' => $param['nbsn'],
                        'cjsn' => $param['cjsn'],
                        'name' => $param['name'],
                        'price' => $param['price'],
                        'desc' => $param['desc'],
                        'importtime' => $param['importtime'],
                        'importnum' => $param['importnum'],
                        'spec' => $param['spec'],
                        'category' => $param['category'],
                        'status' => $param['status'],
                    ])) {
                return ['error' => 0, 'msg' => '保存成功'];
            } else {
                return ['error' => 100, 'msg' => '保存失败'];
            }
        } else {
            return ['error' => 100, 'msg' => '参数传输错误'];
        }
        /*
          if ($param) {

          $product['sn'] = $param['sn'];
          $product['nbsn'] = $param['nbsn'];
          $product['cjsn'] = $param['cjsn'];
          $product['name'] = $param['name'];
          $product['price'] = $param['price'];
          $product['desc'] = $param['desc'];
          $product['importtime'] = $param['importtime'];
          $product['importnum'] = $param['importnum'];
          $product['add_time'] = time();
          $product['spec'] = $param['spec'];
          $product['category'] = $param['category'];
          $product['status'] = $param['status'];
          return ['error' => 0, 'msg' => '数据修改成功'];
          if (Db::table("product")->where("id", $param["id"])->find()) {

          return ['error' => 0, 'msg' => '数据修改成功'];
          } else {
          return ['error' => 100, 'msg' => '数据修改失败'];
          }
          } else {
          return ['error' => 100, 'msg' => '参数传输失败'];
          }
         */
    }

    public function delete($id) {
        $getParam = Request::instance()->post("id");
        if (Db::table("product")->where("id", $getParam)->delete()) {

            return ['error' => 0, 'msg' => '删除成功'];
        } else {
            return ['error' => 100, 'msg' => '删除失败'];
        }
    }

    public function upload() {
        return $this->service->upload();
    }

}
