<?php
/**
 * Created by PhpStorm.
 * User: Hendersson
 * Date: 8.5.2017
 * Time: 13:39
 */

namespace libs;


class View
{
    protected $data;

    public function __construct()
    {
        $this->data = array();
    }

    public function addData($key, $val)
    {
        $this->data[$key] = $val;
    }

    public function getData($key)
    {
        return $this->data[$key];
    }

    public function render($viewName)
    {
        require_once '/../views/common/Header.php';
        require_once '/../views/' . $viewName . '.php';
        require_once '/../views/common/Footer.php';
    }
}