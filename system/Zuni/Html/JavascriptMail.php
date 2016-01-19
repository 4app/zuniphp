<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;


use Zuni\InterfaceClass\Render;
use Zuni\Element;
use Zuni\Html\Vo\JavascriptMailVo;
use Exception;



class JavascriptMail implements Render
{

    private $_js;
    private $_s;

    public function __construct($email)
    {
        $this->_s = new JavascriptMailVo();
        $this->_s->setEmail($email);
        self::_script() ;

    }


    private function _script()
    {
        if (!$this->_s->isEmail()) 
        {
            throw new Exception('Email invalid.' . "\n");
        }

        $js = new Element('script');
        $js->attr('type', 'text/javascript');

        $script = sprintf(
            $this->_s->getSprintfScript(),
            $this->_s->getUser(),
            $this->_s->getDomain(),
            $this->_s->getUserAtDomain()
        );

        $js->add($script);

        $this->_js = $js;

        return $this;
    } 



    public function render()
    {
        return $this->_js->render();
    } 

}    






