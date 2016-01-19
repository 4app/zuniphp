<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Table;

use Zuni\Element;


class Tr extends Element
{
    public function __construct()
    {
        parent::__construct('tr');
    }


    public function td($value)
    {
        $e = new Td($value);
        parent::add($e);

        return $e;
    } 
    
    public function th($value)
    {
        $e = new Th($value);
        parent::add($e);

        return $e;
    } 
 

}



