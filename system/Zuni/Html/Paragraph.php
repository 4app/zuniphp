<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;


use Zuni\Elememt;

class Paragraph extends Element
{
    public function __construct($content)
    {
        parent::__construct('p');
        parent::add($content);
    }
}

