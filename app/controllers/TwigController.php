<?php

namespace controllers;

class TwigController extends BaseController {

    // curl localhost:9090/index
    function index(){

        $this->assign("one","abe");
        $this->assign("two","abc");

        // 加载变量
        dd($this->data);

        // 加载html模板、设置模板变量
//        $this->assign('title',"Java半颗糖"); // 变量
//        $this->assign("list",array("a1"=>"b1","a2"=>"b2")); // 数组
//        $this->display("index");


    }
}