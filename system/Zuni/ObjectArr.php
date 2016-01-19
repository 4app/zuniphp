<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015
 * 

// ----------------------------------

$coll = new \Zuni\ObjectArr();
$coll->add('value 1');
$coll->add('value 2');
$coll->add('value 3');
print_r($coll);

 */


namespace Zuni;

use IteratorAggregate;
use ArrayAccess;

class ObjectArr implements 
    IteratorAggregate, 
    ArrayAccess
{
    private $_data = array();


    public function __set($name, $val) {
        $this[$name] = $val;
    }

    public function __get($name) {
        return $this[$name];
    }



    /** 
     * @see IteratorAggregate::getIterator(); 
     */
    public function getIterator() 
    {
        return new IteratorArr($this->_data);
    }



    public function add($value) 
    {
        $this->_data[] = $value;
        return $this;
    }


    public function set($key, $value)
    {
        $this->_data[$key] = $value;
        return $this;
    } 


    public function get($key)
    {
        if(!array_key_exists($key, $this->_data))
        {
            throw new \Exception(
                sprintf("key '%s' not found.\n", $key)
            );
        }
        return $this->_data[$key];
    } 



    public function getCount()
    {
        return count($this->_data);
    } 



    /**
     * @see ArrayAccess::offsetSet($offset, $value);
     */
    public function offsetSet($offset, $value) 
    {
        if (is_null($offset)) 
        {
            $this->_data[] = $value;
        } 
        else
        {
            $this->_data[$offset] = $value;
        }
    }



    /**
     * @see ArrayAccess::offsetExists($offset);
     */
    public function offsetExists($offset) 
    {
        return (array_key_exists($offset, $this->_data));
    }



    /**
     * @see ArrayAccess::offsetUnset($offset);
     */
    public function offsetUnset($offset) 
    {
        unset($this->_data[$offset]);
    }




    /**
     * @see ArrayAccess::offsetGet($offset);
     */
    public function offsetGet($offset) 
    {
        return (!self::offsetExists($offset)) ? NULL : $this->_data[$offset];
    }


}


