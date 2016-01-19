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

class Hour implements IsValid 
{

    private $_val;

    public function __construct()
    {
        $this->_val = new ValidatorVo();
    }


    public function isValid($field)
    {

        $this->_val->setField($field);
 
       return (preg_match(''
            . '/^(2[0-3]|[01][0-9]):'
            . '[0-5][0-9]:'
            . '[0-5][0-9]'
            . '$/'
            . '', $this->_val->getField()
        ) == 1);

    } 



}



