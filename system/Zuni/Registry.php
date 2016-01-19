<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2012 - 2015 
 * 
*/


namespace Zuni;

class Registry {

    private $_registry = array();
    private static $_instance = NULL;

    public static function getInstance() 
    {
        if(self::$_instance === null) 
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    public function set($key, $value) {
        if(array_key_exists($key, $this->_registry))
        {
            throw new Exception("There is already an entry for key " . $key);
        }

        $this->registry[$key] = $value;
    }

    public function get($key) {
            if(!array_key_exists($key, $this->_registry))
        {
            throw new Exception("There is no entry for key " . $key);
        }

        return $this->_registry[$key];
    }


 public function is( $key ) {
      return (array_key_exists($key, $this->_registry));
   }


}


// Zuni\Registry.php
