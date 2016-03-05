<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

use Zuni\AbstractClass\Controller as ControllerAbstract;
use Zuni\Contracts\Load as ILoad;

class Controller extends ControllerAbstract
{

    public function __construct() {}

        public function load(ILoad $object)
        {
            $this->_instance = $object;
            return $this->_instance->load();
        } 

}


// location: System/Zuni/Controller.php



