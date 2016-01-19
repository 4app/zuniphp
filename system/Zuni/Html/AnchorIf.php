<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;


class AnchorIf  extends Anchor
{

    private $_if;
    
    public function __construct($if, $href, $name)
    {
        parent::__construct($href, $name);
        $this->_if = $if;
    }


    public function render()
    {
        if($this->_if)
        {
            return parent::render();
        }
    } 
    
    
}    








