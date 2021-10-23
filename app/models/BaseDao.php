<?php

namespace models;

use Medoo\Medoo;

class BaseDao extends Medoo {

    function __construct(){
        $options = [
            'type' => 'mysql',
            'host' => 'localhost',
            'database' => 'wxw_test',
            'username' => 'root',
            'password' => '123456'
        ];
        parent::__construct($options);
    }
}