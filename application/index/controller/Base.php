<?php

namespace app\index\controller;

use think\Controller;

class Base extends Controller {

    function __construct() {
        if (!session("adminID")) {
            parent::__construct();
            return view("login/index");
        }
    }

}
