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

class Anchor extends Element
{

    public function __construct($href, $name)
    {
        parent::__construct('a');
        parent::attr('href', $href);
        parent::add($name);
    }


}    







