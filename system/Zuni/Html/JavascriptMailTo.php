<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;


class JavascriptMailTo implements Render
{

    private $_email;
    private $_name;
    private $_js;
    private $_a;
    private $_userAtDomain;


    public function __construct($email)
    {
        $this->_js = new Element('script');
        $this->_js->attr('type', 'text/javascript');
        $this->_email = $email;
        $this->_userAtDomain = '+ user + at + domain +';
        $this->_a = new Anchor(''
            . "'+ 'mail' + 'to:'"
            . $this->_userAtDomain 
            . "'");
    }


    private function _script()
    {

        if (!$this->_isEmail($this->_email)) 
        {
            throw new Exception('Email invalid.' . "\n");
        }

        if(!$this->_name)
        {
            $this->_a->in("' " . $this->_userAtDomain . " '");
        }

        $email = explode('@', $this->_email);
        $anchor = $this->_a->render();

        $script  = '';
        $script .= 'var user = "' . $email[0] . '";';
        $script .= 'var at = "@";';
        $script .= 'var domain = "' . $email[1] . '";';
        $script .= "document.write('{$anchor}');";

        $this->_js->in($script);

    } 


    public function in($content)
    {
        $is = (($content) && (!$this->_isEmail($content)));
        $text = ($is) ? $content : "'{$this->_userAtDomain}'";
        $this->_name = $text;
        $this->_a->in($text);

        return $this;

    } 



    public function render()
    {
        self::_script() ;
        return $this->_js->render();
    } 


    private function _isEmail($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL)) ;
    } 



}    






