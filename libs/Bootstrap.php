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
    private $methodName;
    /**
     * @var array
     */
    private $methodParams;

    public function __construct()
    {
        //echo "bootstrap loaded.";
    }

    public function getUrlPath()
    {
        return $this->urlPath;
    }

    public function getClassPath()
    {
        return $this->classPath;
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
            return true;
        } else {
            return null;
        }
    }

    public function setPaths()
    {
        $path = $this->urlPath;
        if (isset($path)) {
            $filePath = '';
            for ($i = 0; $i < count($path); $i++) {
                $part = $path[$i];
                $filePath = strtolower($filePath) . '/' . ucfirst($part);
                $filePathTest = __DIR__ . '/../controllers' . $filePath . '.php';
                if (file_exists($filePathTest)) {
                    $this->classPath = $filePathTest;
                    array_splice($path, 0, $i + 1);
                    if (isset($path[0]) && !empty($path[0])) {
                        $this->methodName = $path[0];
                    } else {
                        $this->methodName = 'index';
                    }
                    array_splice($path, 0, 1);
                    if (count($path) > 0) {
                        $this->methodParams = $path;
                    }
                    return true;
                }
            }
        }
        return false;
    }
}
