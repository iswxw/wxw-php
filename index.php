<?php

require('vendor/autoload.php');
require "app/helpers.php";  // 单文件自动加载

// 控制器组件
use NoahBuscher\Macaw\Macaw;

// 主页
Macaw::get('/index', 'controllers\TestController@index'); // curl localhost:9090/index
Macaw::get('/', function () { echo "Hello World!";});// curl localhost:9090


// 转发器
Macaw::dispatch();

