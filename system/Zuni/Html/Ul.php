<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;

class Ul extends LiAbstract 
{
    public function __construct($value = NULL)
    {
        parent::__construct('ul');

        if(parent::isItemArr($value))
        {
            parent::li($value);
        }
    }



}    


