<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni\AbstractClass;

use Zuni\Contracts\Load as ILoad;

abstract class Controller
{
    protected $_instance;
    protected abstract function load(ILoad $instance);


}




