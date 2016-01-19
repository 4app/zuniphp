<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015 
 * 
*/


namespace Zuni\Vo;

class ControllerVo
{

    private $_viewFile;
    private $_modelFile;
    private $_pluginFile;
    private $_viewDir = 'View';
    private $_modelDir = 'Model';
    private $_pluginDir = 'Plugin';


    public function pathFile($dir, $file)
    {

        $dir = rtrim($dir);
        $file = rtrim($file, '.php');
        $file = str_replace(array('\\', '/'), DS, $file);
        $file = $file . '.php';
        $file = $dir . DS . $file;

        return $file;
    } 



    public function setViewFile($file)
    {
        $file = $this->_viewDir . DS . $file;
        $file = self::pathFile(APPLICATION_DIR, $file);

        $this->_viewFile = $file;

        return $this;
    } 


    public function getViewFile()
    {
        return $this->_viewFile;
    } 


    public function isViewFile()
    {
        return (file_exists(self::getViewFile()));
    } 



    public function setModelFile($file)
    {
        $file = $this->_modelDir . DS . $file;
        $file = self::pathFile(APPLICATION_DIR, $file);

        $this->_modelFile = $file;

        return $this;
    } 


    public function getModelFile()
    {
        return $this->_modelFile;
    } 


    public function isModelFile()
    {
        return (file_exists(self::getModelFile()));
    } 



    public function setPluginFile($file)
    {
        $file = $this->_pluginDir . DS . $file;
        $file = self::pathFile(APPLICATION_DIR, $file);

        $this->_pluginFile = $file;

        return $this;
    } 


    public function getPluginFile()
    {
        return $this->_pluginFile;
    } 


    public function isPluginFile()
    {
        return (file_exists(self::getPluginFile()));
    } 




}    



