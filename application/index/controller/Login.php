<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;

class Login extends Controller {

    public function index() {
        return view();
    }

    public function logindo() {
        $getInputInfo = input();
        $result = Db::table("user")->where("password", $getInputInfo["passwd"])->where("username", $getInputInfo["username"])->find();
        if (!$result) {
            $this->error("您输入的账号或密码有误，请重新输入！");
        }
        session('adminID', $result["id"]);
        session("adminName", $result["username"]);
        session("adminRole", $result["role"]);
        return redirect("index/index");
    }

    public function quit() {
        Session::delete('adminID');
        Session::delete('adminName');
        return $this->redirect("Login/index");
    }

}
