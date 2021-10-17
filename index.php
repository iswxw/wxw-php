<?php

require('vendor/autoload.php');

// 控制器组件
use NoahBuscher\Macaw\Macaw;

// 主页
Macaw::get('/twig_index', 'controllers\TwigController@index'); // curl localhost:9090/twig_index

Macaw::get('/test_index', 'controllers\TestController@index'); // curl localhost:9090/test_index
Macaw::get('/', function () { echo "Hello World!";});// curl localhost:9090


// 转发器
Macaw::dispatch();

