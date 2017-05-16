<?php
/**
 * Created by PhpStorm.
 * User: Hendersson
 * Date: 8.5.2017
 * Time: 14:03
 */

namespace unit\libs;

//use controllers\common\Home;
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
        $this->assertTrue($this->bootstrapObj->parseUrlPath('common/home/method/param1'));
        return $this->bootstrapObj->getClassPath();
    }

    public function testClassPathPropIsPopulated()
    {
        $this->bootstrapObj->parseUrlPath('common/home/method/param1');
        $actual = $this->bootstrapObj->getClassPath();
        $expected = 'C:\Users\Hendersson\PHPStorm\workspace\my_mvc_framework\libs/../controllers/common/Home.php';
        $this->assertEquals($expected, $actual);
    }

    public function testMethodDataPropIsPopulated()
    {
        $tests = array(''=>'index', 'controller/method'=>'index', 'common/home'=>'index',
            'common/home/method'=>'method', 'common/home/method/param1'=>'method');

        foreach ($tests as $test => $expected) {
            $this->bootstrapObj->parseUrlPath($test);
            $actual = $this->bootstrapObj->getMethodName();
            $this->assertEquals($expected, $actual);
        }
    }

    public function testTargetClassTargetMethodIsValid()
    {
        $urlPath = array ('common/home/testmethod/param1'=>false,
            'common/home/testmethod/param1/param2'=>true,
            'common/home/testmethod/param1/param2/param3'=>true,
            'common/home/testmethod/param1/param2/param3/param4'=>true);

        foreach ($urlPath as $test => $expected) {
            $this->bootstrapObj->parseUrlPath($test);
            $this->assertEquals($this->bootstrapObj->targetMethodIsValid(), $expected);
        }
    }

}
