<?php

namespace controllers;

class BaseController
{
    function success($url,$mess){
        echo "<script>";
        echo "alter('success:{$mess}');";
        echo "location.href={'$url'}";
        echo "</script>";
    }

    function error($url,$mess){
        echo "<script>";
        echo "alter('error:{$mess}');";
        echo "location.href={'$url'}";
        echo "</script>";
    }

}