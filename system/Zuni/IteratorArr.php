<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015
 * 
// --------------------------------------------------

$values = array(1,2,3);

$it = new \Zuni\IteratorArr($values);

foreach ($it as $a => $b) {
  print "$a: $b\n";
}


$a = array('lorem', 'ipsum', 'dolor');
$x = new \Zuni\IteratorArr($a);
print_r($x);
echo "\n----------------------------------\n";


for ($x->rewind(); $x->valid(); $x->next())
{
    echo $x->current() . "\n";
}    
echo "\n----------------------------------\n";

 */



namespace Zuni;


use Iterator;


class IteratorArr implements Iterator
{
    private $_data = array();

    public function __construct($array)
    {
        if (is_array($array) ) 
        {
            $this->_data = $array;
        }
    }

    public function rewind() 
    {
        reset($this->_data);
    }

    public function current() 
    {
        return current($this->_data);
    }

    public function key() 
    {
        return key($this->_data);
    }

    public function next() 
    {
        return next($this->_data);
    }

    public function valid() 
    {
        return ($this->current() !== false);
    }
}





