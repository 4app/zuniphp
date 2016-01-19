<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015 
 * 
*/


namespace Zuni\View;


class RenderIf extends Render
{
    private $_if;

    public function __construct($if, $viewFile, $data = NULL)
    {
        parent::__construct($viewFile, $data);
        $this->_if = $if;
    }

    public function load()
    {
        if($this->_if)
        {
            parent::load();
            return TRUE;
        }

        return NULL;



    } 
}



