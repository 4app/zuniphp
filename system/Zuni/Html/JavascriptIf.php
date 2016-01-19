<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni\Html;


class JavascriptIf extends Javascript
{

    private $_if;

    public function __construct($if, $src)
    {
        parent::__construct($src);
        $this->_if = $if;
    }

    public function render()
    {
        if(!$this->_if){
            return;
        }

        return parent::render();
    } 

}    


