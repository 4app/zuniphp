<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;


class Javascript implements Render
{

    private $_js;


    public function __construct($src)
    {
        self::_script($src);
    }



    public function render()
    {
        return $this->_js->render();
    } 


    private function _script($src)
    {
        $js = new Element('script');
        $js->attr('type', 'text/javascript');
        $js->attr('src', $src);
        $js->add('');

        $this->_js = $js;

        return $this;
    } 


}    


