<?php
/**
 * Created by PhpStorm.
 * User: Hendersson
 * Date: 8.5.2017
 * Time: 13:39
 */

namespace controllers\common;
use libs\Controller;
require_once __DIR__ . '/../../libs/Controller.php';

class Home extends Controller
{
    public function index()
    {
        echo "This is the Home page index-method!";
    }

/*    public function getMethod($method, array $params = [])
    {
        // TODO: Implement getMethod() method.
    }*/

    /**
     * @param string $param1
     */
    public function testmethod($param1 = '')
    {
        echo 'Home::testmethod(' . $param1 . ')';
    }
}