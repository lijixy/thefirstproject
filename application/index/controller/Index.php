<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        $getAdminName= session("adminName");
        if(!$getAdminName){
            return redirect("login/index");
        }
        $this->assign("adminmame",$getAdminName);
        return view("index/index");
    }
}
