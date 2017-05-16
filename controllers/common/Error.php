<?php
/**
 * Created by PhpStorm.
 * User: Hendersson
 * Date: 10.5.2017
 * Time: 14:11
 */

namespace controllers\common;
use libs\Controller;
require_once __DIR__ . '/../../libs/Controller.php';

class Error extends Controller
{
    public function index()
    {
        echo 'ERROR: page does not exist!';
    }
}