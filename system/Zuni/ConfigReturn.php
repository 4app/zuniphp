<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

use Zuni\InterfaceClass\Load;
use Zuni\AbstractClass\ConfigAbstract;

class ConfigReturn extends ConfigAbstract 
    implements Load
{

    public function __construct($file, $dirApp = NULL)
    {
        parent::__construct($file, $dirApp);
    }

    public function load()
    {
        parent::_throwException();

        return include parent::$_file->getPathAndName();

    } 

}




