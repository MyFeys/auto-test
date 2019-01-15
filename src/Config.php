<?php
namespace AutoTest;

use AutoTest\Exception\InvalidException;
use AutoTest\Exception\NotFoundException;

/**
 * @author arrayhua<2498168786@qq.com>
 * @date: 2018-08-05
 * @copyright arrayhua.github.io
 */
class Config implements \ArrayAccess
{
    private $configs = [];

    public function offsetExists($key)
    {
        return isset($this->configs[$key]);
    }

    public function offsetGet($key)
    {
        if (empty($this->configs[$key])) {
            $this->offsetSet($key);
        }
        return $this->configs[$key];
    }

    public function offsetSet($key, $value = null)
    {
        $path = ROOT_PATH. DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR . $key. '.php';
        $this->load($path);
        
        if (isset($this->configs[$key])) {
            throw new NotFoundException;
        }
        
        return $this->configs[$key]; 
       
    }

    public function offsetUnset($key)
    {
        unset($this->configs[$key]);
    }

    public function load($path)
    {
        $paths = is_array($path) ? $path : [$path];
        foreach ($paths as $path) {
            $data = $this->parseConfiguration($path);
        }
        return $this->configs[$path] = $data;
    }

    private function parseConfiguration($path)
    {
        $files = $this->findConfigurationFiles($path);
        $data = [];
        foreach ($files as $file) {
            $file = require $file;
            $data = array_merge($data, $file);
        }
        return $data;
    }

    private function findConfigurationFiles($path)
    {
        if (is_dir($path)) {
            $files = glob($path . '/*.*');
            if (empty($files)) {
                throw new InvalidException(sprintf('There is no configuration file in the directory "%s"', $path));
            }
        } else {
            if (!file_exists($path)) {
                throw new InvalidException(sprintf('File "%s" does not exists', $path));
            }
            $files = [$path];
        }
        return $files;
    }
}