<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015 
 * 
*/


namespace Zuni\Validator;


use Zuni\Contracts\IsValid;
use Zuni\Validator\ValidatorVo;

class Url implements isValid 
{
    private $_val;

    public function __construct()
    {
        $this->_val = new ValidatorVo();
    }


    public function isValid($field)
    {
        $this->_val->setField($field);

       return (filter_var($this->_val->getField(), FILTER_VALIDATE_URL) == TRUE);
    } 



}



