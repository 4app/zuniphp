<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html\Vo;



class JavascriptMailVo
{


    public function setEmail($email)
    {
        $this->_email = $email;

        return $this;
    } 



    public function isEmail()
    {
        return (filter_var($this->_email, FILTER_VALIDATE_EMAIL)) ;
    } 





    public function getUser()
    {
        $email = explode('@', $this->_email);
        return $email[0];
    } 







    public function getDomain()
    {
        $email = explode('@', $this->_email);
        return $email[1];
    } 





    public function getUserAtDomain()
    {
        return 'user + at + domain';
    } 





    public function getSprintfScript()
    {
        $result = '' 
            . 'var user = "%s";'
            . 'var at = "@";'
            . 'var domain = "%s";'
            . 'document.write(%s);'
            . '';


        return $result;
    } 



}    


