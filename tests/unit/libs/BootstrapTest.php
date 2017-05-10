<?php
/**
 * Created by PhpStorm.
 * User: Hendersson
 * Date: 8.5.2017
 * Time: 14:03
 */

namespace unit\libs;

use controllers\common\Home;
use libs\Bootstrap;
require_once __dir__ . '/../../../libs/Bootstrap.php';

class BootstrapTest extends \PHPUnit_Framework_TestCase
{
    protected $bootstrapObj;

    public function setup()
    {
        $this->bootstrapObj = new Bootstrap();
    }

    public function testParseUrlPath()
    {
        $expected = array('controller','method','param1','param2');
        $urlPath = "controller/method/param1/param2///";
        $this->assertTrue($this->bootstrapObj->parseUrlPath($urlPath));
        $actual = $this->bootstrapObj->getUrlPath();
        $this->assertEquals($actual, $expected);
    }

    public function testClassFileIsFound()
    {
        $this->bootstrapObj->parseUrlPath('common/home/method/param1');
        $this->assertTrue($this->bootstrapObj->setPaths());
        return $this->bootstrapObj->getClassPath();
    }

    public function testClassPathPropIsPopulated()
    {
        $this->bootstrapObj->parseUrlPath('common/home/method/param1');
        $this->bootstrapObj->setPaths();
        $actual = $this->bootstrapObj->getClassPath();
        $expected = 'C:\Users\Hendersson\PHPStorm\workspace\my_mvc_framework\libs/../controllers/common/Home.php';
        $this->assertEquals($expected, $actual);
    }

    public function testMethodDataPropIsPopulated()
    {
        $tests = array('common/home', 'common/home/method', 'common/home/method/param1');
        $expected_results = array('index', 'method', 'method');
        for ($i=0; $i<count($tests); $i++) {
            $this->bootstrapObj->parseUrlPath($tests[$i]);
            $this->bootstrapObj->setPaths();
            $actual = $this->bootstrapObj->getMethodName();
            $expected = $expected_results[$i];
            $this->assertEquals($expected, $actual);
        }
    }

    public function testTargetClassHasTargetMethod()
    {
        $urlPath = 'common/home/testmethod/param1';
        $this->bootstrapObj->setPaths($this->bootstrapObj->parseUrlPath($urlPath));
        require_once $this->bootstrapObj->getClassPath();
        $target = new Home();
        $method = $this->bootstrapObj->getMethodName();
        $this->assertTrue(method_exists($target, $method));
        $methodParams = $this->bootstrapObj->getMethodParams();
        echo $target->{$method}($methodParams[0]);
    }

}
