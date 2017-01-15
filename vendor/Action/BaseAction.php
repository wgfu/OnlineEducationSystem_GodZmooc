<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/14
 * Time: 11:45
 */
namespace vendor\Action;

class BaseAction
{
    public $view;
    public function _construct()
    {
        $this->view = new \stdClass();
    }

    public function output($template)
    {
        global $container;
        $view = (array)$this->view;
        foreach ($view as $key => $value) {
            $smarty = $container['samarty'];
            $smarty->caching = false;
            $smarty->assign($key, $value, true);
            $smarty->display(dirname(dirname(__DIR__)) . "/webapp/src/html/" . $template);
        }
    }

    public function doAction($filename = "", $classname = "", $actionname = "")
    {
        $webroot = dirname(dirname(__DIR__));
        $filename = $webroot . "/webapp/src/php/controller/" . $filename . ".php";
        if (file_exists($filename)) {
            include_once $filename;
            if (class_exists($classname)) {
                $instance = new $classname;
                if (in_array($actionname, get_class_methods($classname))) {
                    $instance->$actionname();
                } else {
                    die("no such action");
                }
            } else {
                die("no such class");
            }
        } else {
            die("no such file");
        }
    }
}
