<?php
/**
 * Created by PhpStorm.
 * User: Hendersson
 * Date: 8.5.2017
 * Time: 13:37
 */

namespace libs;


abstract class Controller
{
    abstract public function index();
    /**
     * Validates and runs given method
     * @return mixed $result
     * @param object $obj
     * @param string $method
     * @param array $params //optional
     */
    //abstract public function getMethod($method, array $params);
/*    public function getMethod($method, array $params)
    {
        $paramStr = isset($params)&&!empty($params) ? implode(',', $params) : '';
        echo 'You are @ ' . $method . '('. $paramStr .')';
    }*/

    /**
     * Validates and runs the method declared in the Bootstrap::methodName(Bootstrap::methodParams)
     * @return mixed $result --returns the target method return value
     * @param Bootstrap $bootObj
     */
    public function getMethod(Bootstrap $bootObj)
    {
        $paramStr = '';
        if (null !== $bootObj->getMethodParams() && !empty($bootObj->getMethodParams())) {
            $paramStr = implode(',', $bootObj->getMethodParams());
        }
        //echo 'You are @ ' . $bootObj->getMethodName() . '('. $paramStr .')';

        $method = new \ReflectionMethod($bootObj->getClassName(), $bootObj->getMethodName());
        //echo ' required params: ' . $method->getNumberOfRequiredParameters();
        //echo ' all params: ' . $method->getNumberOfParameters();
    }

}