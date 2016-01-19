<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2013
 * 
*/


namespace Zuni\Filter\Word;

class SeparatorToSeparator extends AbstractSeparator {

    protected $_replaceSeparator = NULL;

    public function __construct($searchSeparator = ' ', $replacementSeparator = '-') {
        parent::__construct($searchSeparator);
        $this->_replaceSeparator = $replacementSeparator;
    }

    public function filter($value) {

        if (!is_string($this->_replaceSeparator))
            throw new \Exception('"' . $this->_replaceSeparator . '" is not a valid replaceSeparator.');

        $result = str_replace(parent::getSeparator(), $this->_replaceSeparator, $value);

        return $result;
    }

}
