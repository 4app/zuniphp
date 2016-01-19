<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2013
 * 
*/


namespace Zuni\Filter\Word;

abstract class AbstractSeparator{

    protected $separator = null;

    
    //-------------------------------------------------------------
    /**
     * Constructor
     *
     * @param  string $separator Space by default
     */
    public function __construct($separator = ' ') {
        if (is_array($separator)) {
            $temp = ' ';
            if (isset($separator['separator']) && is_string($separator['separator'])) {
                $temp = $separator['separator'];
            }
            $separator = $temp;
        }
        $this->setSeparator($separator);
    }

    
    
    //-------------------------------------------------------------
    /**
     * Sets a new separator
     *
     * @param  string  $separator  Separator
     * @return AbstractSeparator
     * @throws Exception
     */
    public function setSeparator($separator){
        if (!is_string($separator)) {
            throw new \Exception('"' . $separator . '" is not a valid separator.');
        }
        $this->separator = $separator;
        return $this;
    }

    
    //-------------------------------------------------------------
    /**
     * Returns the actual set separator
     *
     * @return  string
     */
    public function getSeparator(){
        return $this->separator;
    }
}
