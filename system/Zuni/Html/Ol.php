<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;

class Ol extends LiAbstract 
{
    public function __construct($value = NULL)
    {
        parent::__construct('ol');

        if(parent::isItemArr($value))
        {
            parent::li($value);
        }
    }



}    


