<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;

use Zuni\Element;


class Li extends Element
{
    public function __construct($value)
    {
        parent::__construct('li');
        parent::add($value);
    }

}



