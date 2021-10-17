<?php

namespace controllers;

class BaseController
{

    protected $twig;
    protected $data = array();

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/views');
        $this->twig = new \Twig\Environment($loader, [
            // 'cache' => '/path/to/compilation_cache',
        ]);
    }

    public function assign($var, $value = null)
    {
        if (is_array($var)) {
            $this->data = array_merge($this->data, $var);
        } else {
            $this->data[$var] = $value;
        }
    }

    function display($template)
    {
        echo $this->twig->render($template . '.html', $this->data);
    }

    function success($url, $mess)
    {
        echo "<script>";
        echo "alter('success:{$mess}');";
        echo "location.href={'$url'}";
        echo "</script>";
    }

    function error($url, $mess)
    {
        echo "<script>";
        echo "alter('error:{$mess}');";
        echo "location.href={'$url'}";
        echo "</script>";
    }

}