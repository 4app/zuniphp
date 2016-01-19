<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2016
 * 
*/


namespace Zuni\Filter;


class Ds
{

    private static $_name;
    private static $_ext = '.php';

    public static function getFile($name)
    {
        self::_setFileName($name);
        self::_removeExt();
        self::_filterSeparatorFileName();

        return self::_getFileName();
    }



    public function getFilterSeparator($path)
    {
        
        $search = array('/', '\\', '.');

        return str_replace($search, 
            DIRECTORY_SEPARATOR, $path
        );


    } 






    private static function _setFileName($name)
    {
        self::$_name = $name; 
        return;
    } 

    private static function _removeExt()
    {
        self::$_name = rtrim(self::$_name, self::$_ext);

        return;
    } 

    private static function _getFileName()
    {
        return self::$_name; 
    } 


    private static function _filterSeparatorFileName()
    {

        self::$_name = self::getFilterSeparator(self::$_name) . self::$_ext;

        return;

    } 

}    


