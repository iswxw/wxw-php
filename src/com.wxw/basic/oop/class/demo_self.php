<?php

class Sale{
    // 属性 
    private static $count = 0; // 私有不允许外部直接访问
    private function __construct(){}  // 私有不允许外部实例化（因为对象不能外部调用）

    // 内部实例化方法
    public static function getInstance(){
        return new Sale(); // 使用类名实例化
        return new self(); // 使用 self 关键字实例化
    }

    // 方法
    public static function showClass(){
        echo Sale::$count;
        echo self::$count;  // 代替类名
    }

}

Sale::showClass();

// 获取对象的方式
$sale = Sale::getInstance();
var_dump($sale);