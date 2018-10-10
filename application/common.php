<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
// 应用公共文件
use think\Request;
use think\Session;
use think\Db;
use think\Controller;

function getResidueNum($id) {
    $importNum = Db::table("product")->where("sn", $id)->find();
    $exportNum = Db::table("order_info")->where("product_no", $id)->sum("goods_number");
    $num = $importNum["importnum"] - $exportNum;
    if ($num <= 100) {
        return "<font color='red'>" . $num . "</font>";
    } else {
        return $num;
    }
}
