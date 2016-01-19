<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2013
 * 
*/


namespace Zuni\Filter\Word;

class CamelCaseToSeparator extends AbstractSeparator {

    public function filter($value) {

        $word = array();
        $word = preg_split('/(?<=[a-z])(?=[A-Z])/x', $value);
        $count = count($word);
        for ($i = 0; $i < $count; ++$i) {
            $word[$i];
        }

        $result = implode(parent::getSeparator(), $word);

        return $result;
    }

}
