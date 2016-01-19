<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni\Html;

use Zuni\Element;

abstract class LiAbstract extends Element 
{

    public function li($value)
    {

        if(self::isItemArr($value)) 
        {
            foreach ($value as $row)
            {
                self::item($row) ;
            }

            return $this;

        }

        self::item($value);

    } 


    private function item($value)
    {
        $e = new Li($value);
        parent::add($e);

        return $e;
    } 



    protected function isItemArr($value)
    {
        return (is_array($value) && count($value));
    } 

}    


