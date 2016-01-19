<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni\AbstractClass;

use Zuni\Vo\FileVo;
use Zuni\Filter\Ds;
use Zuni\App;

abstract class ConfigAbstract
{
    protected static $_file;

    public function __construct($file, $dirApp = NULL)
    {

        $path = App::getPathApp();
        if($dirApp)
        {
            $path = ''
                . App::getPathRoot() 
                . Ds::getFilterSeparator($dirApp) 
                . DIRECTORY_SEPARATOR
                . '';
                
        }

        self::$_file = new FileVo();
        self::$_file->setPath($path . 'Config');
        self::$_file->setName($file);

    }
   
    protected function _throwException()
    {

        if(! self::$_file->isPathAndName())
            throw new \Exception(
                sprintf( ''
                . 'File Config "%s" Not Found.' 
                . "\n" , 
                    self::$_file->getName()
                ));
    } 
}




