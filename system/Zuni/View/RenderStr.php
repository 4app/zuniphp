<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015 
 * 
*/


namespace Zuni\View;

class RenderStr extends Render
{
    public function __construct($fileView, $dataArrAssoc = NULL)
    {
        parent::__construct($fileView, $dataArrAssoc);
    }

    public function load()
    {
        ob_start();
        parent::load();
        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    } 


}



