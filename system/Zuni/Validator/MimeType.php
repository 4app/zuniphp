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

class MimeType implements IsValid 
{

    private $_val;

    public function __construct($mimeTypeArr)
    {
        $this->_val = new ValidatorVo();
        $this->_val->setRule($mimeTypeArr);
    }


    public function isValid($fileType)
    {
        $this->_val->setField($fileType);

        return (
            in_array($this->_val->getField(), $this->_val->getRule())
        );

    } 



}



