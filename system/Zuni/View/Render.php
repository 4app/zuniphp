<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015 
 * 
*/


namespace Zuni\View;

use Zuni\Contracts\Load as ILoad;
use Zuni\Vo\FileVo;
use Zuni\App;
use Zuni\Filter\Ds;

class Render implements ILoad
{
    private $_view;
    protected static $_data;

    public function __construct($view, $data = NULL)
    {
        self::_setView($view);
        self::$_data = $data;
    }


private function _setView($view)
{

    $path = App::getPathApp() . 'View' . DIRECTORY_SEPARATOR;
    $file = Ds::getFile($view);

    $this->_view = $path . $file;
    return $this;
} 


private function _getView()
{
  return $this->_view; 
} 




    public function set($key, $value)
    {
        self::$_data[$key] = $value;

        return $this;
    } 


    public function setSafe($key, $value)
    {

        $value = htmlentities($value, ENT_QUOTES);
        self::$_data[$key] = $value;

        return $this;
    } 





    public function load(ILoad $object = NULL)
    {
        if(!$object)
        {
            return self::_load();
        }

        return $object->load();

    } 



    private function _load()
    {
        self::_throwException();

        if(self::_isData())
        {
            extract(self::$_data);
        }

        include self::_getView() ;
    } 


    protected function _throwException()
    {
        if(! file_exists(self::_getView()))
            throw new \Exception(
                sprintf( "Error: %s Not Found.\n", 
                    self::_getView())
            );
    } 

    private function _isData()
    {
        return (is_array(self::$_data) && count(self::$_data));
    } 


}




