<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;


class Image extends Element
{

    public function __construct($src)
    {
        parent::__construct('img');
        parent::attr('src', $src);
    }
    
}    






