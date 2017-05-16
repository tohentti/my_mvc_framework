<?php
/**
 * Created by PhpStorm.
 * User: Hendersson
 * Date: 8.5.2017
 * Time: 13:38
 */

namespace libs;


class Bootstrap
{
    /**
     * @var array
     */
    private $urlPath;
    /**
     * @var string
     */
    private $classPath;
    /**
     * @var string
     */
    private $className;
    /**
     * @var string
     */
    private $methodName = 'index';
    /**
     * @var array
     */
    private $methodParams = array();

    public function __construct($url = '')
    {
        //echo '@Bootstrap: ' . $url;
        if($this->parseUrlPath($url)) {
            $this->loadClass();
        }
    }

    public function getUrlPath()
    {
        return $this->urlPath;
    }

    public function getClassPath()
    {
        return $this->classPath;
    }

    public function getClassName()
    {
        return $this->className;
    }

    public function getMethodName()
    {
        return $this->methodName;
    }

    public function getMethodParams()
    {
        return $this->methodParams;
    }

    public function parseUrlPath($url)
    {
        if (isset($url)) {
            $this->urlPath = explode('/', rtrim($url, '/'));
            $this->setPaths();
            return true;
        } else {
            return null;
        }
    }

    private function setPaths()
    {
        $path = $this->urlPath;
        if (isset($path)) {
            $filePath = '';
            for ($i = 0; $i < count($path); $i++) {
                $part = $path[$i];
                $namespace = 'controllers\\' . str_replace('/','\\',strtolower(ltrim($filePath,'/')));
                $filePath = strtolower($filePath) . '/' . ucfirst($part);
                $filePathTest = __DIR__ . '/../controllers' . $filePath . '.php';
                if (file_exists($filePathTest)) {
                    $this->classPath = $filePathTest;
                    $this->className = $namespace . '\\' . ucfirst($part);
                    array_splice($path, 0, $i + 1);
                    if (isset($path[0]) && !empty($path[0])) {
                        $this->methodName = $path[0];
                    }
                    array_splice($path, 0, 1);
                    if (count($path) > 0) {
                        $this->methodParams = $path;
                    }
                    return true;
                }
            }
        }

        $this->setAsError();
        return false;
    }

    private function setAsError()
    {
        $this->classPath = __DIR__ . '/../controllers/common/Error.php';
        $this->className = 'controllers\\common\\Error';
        $this->methodName = 'index';
        $this->methodParams = array();
    }

    private function loadClass()
    {
        if ($this->targetMethodIsValid()) {
            require_once $this->classPath;
            $class = new $this->className();
            $class->{$this->methodName}(...$this->methodParams);
        }
        else {
            $this->setAsError();
            // WARNING: Loop!
            $this->loadClass();
        }
    }

    //private
    public function targetMethodIsValid()
    {
        require_once $this->classPath;
        try {
            $reflection = new \ReflectionMethod($this->className, $this->methodName);
            if ($reflection->getNumberOfRequiredParameters() <= count($this->getMethodParams())) {
                //echo $this->className . ', ' . $this->methodName;
                //echo ' Required:' . $reflection->getNumberOfRequiredParameters() . ', provided params: ' . count($this->getMethodParams());
                return true;
            }
            else {
                return false;
            }
        }
        catch (\ReflectionException $re) {
            return false;
        }

    }
}
