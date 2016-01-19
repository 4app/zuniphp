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

class Config extends ConfigAbstract 
    implements Load
{

    public function __construct($file)
    {
        parent::__construct($file);
    }

    public function load()
    {
        parent::_throwException();

        include parent::$_file->getPathAndName();

    } 


}




