<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015 
 * 
*/


namespace Zuni\Validator;


use Zuni\InterfaceClass\IsValid;
use Zuni\Validator\ValidatorVo;

class Ip implements IsValid 
{

    private $_val;

    public function __construct()
    {
        $this->_val = new ValidatorVo();
    }


    public function isValid($field)
    {
        $this->_val->setField($field);
        return (filter_var($this->_val->getField(), FILTER_VALIDATE_IP) == TRUE);

    } 



}



