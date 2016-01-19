<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015 
 * 
*/


namespace Zuni\Vo;

class FileVo
{
    private $_name;
    private $_path;

    public function getName()
    {
        return $this->_name;
    }

    public function setName($name)
    {
        $name = rtrim($name, '.php') . '.php';
        $name = ltrim($name, '/');
        $this->_name = $name;

        return $this;
    }

    public function getPath()
    {
        return $this->_path;
    }

    public function setPath($path)
    {
        $this->_path = rtrim($path, '/') . '/';
        return $this;
    }

    public function getPathAndName()
    {
        return self::getPath() . self::getName();
    } 
    


    public function isPathAndName()
    {
        return (file_exists(self::getPath() . self::getName()));
    } 



    public function isName()
    {
        return (file_exists(self::getName()));
    } 

}    




