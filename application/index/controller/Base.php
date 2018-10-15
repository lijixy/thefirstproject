<?php

namespace app\index\controller;

use think\Controller;

class Base extends Controller {

    function __construct() {
    	//备用
        if (!session("adminID")) {
            parent::__construct();
            return view("login/index");
        }
    }

}
