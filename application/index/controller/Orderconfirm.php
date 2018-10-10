<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;

class Orderconfirm extends Controller {

    public function index() {
        $getAdminName = session("adminName");
        if (!$getAdminName) {
            return redirect("login/index");
        }
        $data = Request::instance()->get();
        $where = [];

        //封装where查询条件
        (empty($data['status']) || $data['status'] == '') || $where['status'] = $data['status'];
        empty($data['product_no']) || $where['product_no'] = ['like', '%' . $data['product_no']];
        empty($data['sn']) || $where['order_sn'] = $data['sn'];


        $result = Db::table("order_info")->where($where)->paginate(5);
        $this->assign(['list' => $result]);
        return view();
    }

    public function import() {
        $this->assign(['list' => $this->service->getNew()]);
        return view();
    }

    public function create() {
        $productSnList = Db::table("product")->select();
        $this->assign(['productList' => $productSnList]);
        return view();
    }

    public function save() {
        Request::instance()->isPost() || die('request not  post!');

        $param = Request::instance()->param(); //获取参数
        if ($param) {
            if (Db::table("order_info")->where("order_sn", $param["order_sn"])->find()) {
                return ['error' => 100, 'msg' => '订单编码已经存在，请重新输入订单编码！'];
                exit();
            }

            $product['order_sn'] = $param['order_sn'];
            $product['product_no'] = $param['product_no'];
            $product['goods_number'] = $param['goods_number'];
            $product['referer'] = $param['referer'];
            $product['order_editer'] = $param['order_editer'];
            $product['status'] = $param['status'];
            $product['remark'] = $param['remark'];
            $product['add_time'] = time();
            if (Db::table("order_info")->insert($product)) {
                return ['error' => 0, 'msg' => '添加订单成功'];
            } else {
                return ['error' => 100, 'msg' => '添加订单失败'];
            }
        } else {
            return ['error' => 100, 'msg' => '参数传输有误'];
        }
    }

    public function edit() {
        $productSnList = Db::table("product")->select();
        $id = Request::instance()->get("id");
        $result = Db::table("order_info")->where("id", $id)->find();
        $this->assign(['info' => $result, 'productList' => $productSnList]);
        return view();
    }

    public function update() {
        Request::instance()->isPost() || die('request not  post!');

        $param = Request::instance()->param(); //获取参数
        if ($param) {

            if (Db::table("order_info")->where("id", $param["id"])->update([
                        'product_no' => $param['product_no'],
                        'goods_number' => $param['goods_number'],
                        'referer' => $param['referer'],
                        'order_editer' => $param['order_editer'],
                        'status' => $param['status'],
                        'remark' => $param['remark'],
                    ])) {
                return ['error' => 0, 'msg' => '修改成功'];
            } else {
                return ['error' => 100, 'msg' => '修改失败'];
            }
        } else {
            return ['error' => 100, 'msg' => '参数传输错误'];
        }
    }

    public function upload() {
        if ($this->service->upload(request()->file('excel'))) {
            $this->success('导入成功', 'Order/import');
        } else {
            $this->error('导入失败');
        }
    }

    public function doconfirm($id) {
        $getParam = Request::instance()->post("id");

        if (Db::table("order_info")->where("id", $getParam)->update(['tally_status' => 5])) {

            return ['error' => 0, 'msg' => '订单确认成功！'];
        } else {
            return ['error' => 100, 'msg' => '订单确认失败！'];
        }
    }

    //下载
    public function down() {
        $filename = ROOT_PATH . '/public/static/demo.xls';
        header("content-disposition:attachment;filename=" . basename($filename));
        header("content-length:24");
        return readfile($filename);
    }

    // public function delete($id){
    //     return $this->service->delete($id);
    // }

    public function pack() {
        $this->assign(['list' => $this->service->page()]);
        return view();
    }

    public function arrange() {
        $this->assign(['list' => $this->service->page()]);
        return view();
    }

    public function confirm() {
        $getParam = Request::instance()->post("id");
        if (Db::table("order_info")->where("id", $getParam)->update(['tally_status' => 3])) {

            return ['error' => 0, 'msg' => '提交成功'];
        } else {
            return ['error' => 100, 'msg' => '提交失败'];
        }
    }

    public function logistics() {
        $getParam = Request::instance()->get("id");
        //$getParam=4;
        $result = Db::table("order_info")->where("id", $getParam)->find();
        $this->assign(['info' => $result]);
        return view();
    }

    public function editlogistics() {

        Request::instance()->isPost() || die('request not  post!');

        $param = Request::instance()->param(); //获取参数
        if ($param) {

            if (Db::table("order_info")->where("id", $param["id"])->update([
                        'waybillno' => $param['waybillno'],
                        'receiver_name' => $param['receiver_name'],
                        'receiver_sn' => $param['receiver_sn'],
                        'receiver_address' => $param['receiver_address'],
                        'remark' => $param['remark'],
                        'tally_status' => 4,
                    ])) {
                return ['error' => 0, 'msg' => '物流信息编辑成功'];
            } else {
                return ['error' => 100, 'msg' => '物流信息编辑失败'];
            }
        } else {
            return ['error' => 100, 'msg' => '参数传输错误'];
        }
    }

}
