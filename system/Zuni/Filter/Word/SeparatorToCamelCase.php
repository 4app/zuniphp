<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2013
 * 
*/


namespace Zuni\Filter\Word;

class SeparatorToCamelCase extends AbstractSeparator 
{

    public function filter($value) 
    {

        $word = array();
        $word = explode(parent::getSeparator(), $value);
        $count = count($word);
        for ($i = 0; $i < $count; ++$i) 
        {
            $word[$i] = ucfirst($word[$i]);
        }
        $result = implode('', $word);

        return $result;
    }

}
