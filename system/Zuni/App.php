<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2016 
 * 
*/


namespace Zuni;


use Zuni\Uri;


class App {

    private $_uri;
    private $_explode = array();
    private $_controller;
    private $_action;
    private $_pageNotFound = "Error404 - Page Not Found.\n";
    private $_prefixController = '\Controller\\%s';
    private $_pathController;
    private static $_pathRoot = '../';
    private static $_startController = 'Index';
    private static $_errorController = 'Error404';
    private static $_dirSystem = 'system';
    private static $_dirApp = 'app';


    public function __construct() 
    {
        self::_startConfig();
        self::_prepareAttributes();

        $this->_pathController = 'Controller' . DIRECTORY_SEPARATOR . '%s.php';
    }




    public function setPathRoot($pathRoot)
    {
        $pathRoot = rtrim($pathRoot, '/') . DIRECTORY_SEPARATOR;
        self::$_pathRoot = $pathRoot;
        return $this;
    } 


    public static function getPathRoot()
    {
        return self::$_pathRoot;
    } 




    public function setStartController($controller)
    {
        self::$_startController = $controller;
        return $this;
    }



    public static function getStartController()
    {
        return self::$_startController;
    } 



    public function setErrorController($errorController)
    {

        self::$_errorController = $errorController;
        return $this;
    } 


    public static function getErrorController()
    {
        return self::$_errorController;
    } 





    public function setDirSystem($system)
    {
        self::$_dirSystem = $system;
        return $this;
    } 


    public static function getDirSystem()
    {
        return self::$_dirSystem;
    } 





    public function setDirApp($dirApp)
    {
        self::$_dirApp = $dirApp;
        return $this;
    } 


    public static function getDirApp()
    {
        return self::$_dirApp;
    } 



    public static function getPathApp()
    {
        return '' 
            . self::getPathRoot() 
            . self::getDirApp()
            . DIRECTORY_SEPARATOR;
    } 

    public static function getPathSystem()
    {
        return ''
            . self::getPathRoot() 
            . self::getDirSystem()
            . DIRECTORY_SEPARATOR;
    } 


    public static function getPathVendor()
    {
        return '' 
            . self::getPathRoot() 
            . self::getDirVendor()
            . DIRECTORY_SEPARATOR;
    } 





    /**
     * --------------------------------------
     * strip characters other than "az, AZ and -_"
     * @param $param string
     */
    public function prepareParam($param)
    {
        return preg_replace('/[^a-zA-Z\]0-9\]_-]/', '', $param);
    }





    private function _prepareAttributes() 
    {

        $_uri = Uri::getFull();
        $_uri = (!$_uri) ? self::getStartController() . '/index' : $_uri;
        $this->_uri = $_uri;

        $this->_explode = explode('/', $this->_uri);

        $controller = $this->prepareParam($this->_explode[0]);
        $controller = str_replace(array('-'), '_', $controller);
        $explodeFile = explode('_', $controller);

        foreach ($explodeFile as $f)
        {
            $prepareFile[] = ucfirst($f);
        }

        $this->_controller = implode('\\', $prepareFile);

        $action = (
            !isset($this->_explode[1]) ||
            $this->_explode[1] == null ||
            $this->_explode[1] == 'index'
        ) ?
        'index' : $this->prepareParam($this->_explode[1]);

        $action = str_replace('-', '_', $action);
        $this->_action = $action;
    }

    public function run() 
    {


        $this->_pathController = self::getPathApp() 
            . $this->_pathController;

        $file = str_replace('\\', DIRECTORY_SEPARATOR, $this->_controller);
        $fileExists = file_exists(sprintf($this->_pathController, $file));
        $this->_controller = sprintf($this->_prefixController, $this->_controller);

        if(! $fileExists)
        {
            $this->_controllerError404();
        }

        require sprintf($this->_pathController, $file);


        $this->_controller = new $this->_controller();

        if (!method_exists($this->_controller, $this->_action))
        {
            $this->_controllerError404();
        }


        if (method_exists($this->_controller, $this->_action)) 
        {
            unset($this->_explode[0]);
            unset($this->_explode[1]);

            $params = ($this->_explode) ? array_values($this->_explode) : array();

            call_user_func_array(array($this->_controller, $this->_action), $params);
        }

    }

    private function _controllerError404() 
    {
        $explodeFile = explode('_', self::getErrorController());

        foreach ($explodeFile as $f)
        {
            $prepareFile[] = ucfirst($f);
        }

        $file = implode('_', $prepareFile);
        $file = str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $file);


        if (!file_exists(sprintf($this->_pathController, $file))) 
            exit($this->_pageNotFound);

        require sprintf($this->_pathController, $file);


        $this->_controller = sprintf($this->_prefixController, self::getErrorController());
        $this->_controller = new $this->_controller();
        $this->_controller->index();
        exit();
    }


    private function _loadFileConfig()
    {
        $pathConfig = self::getPathApp() . 'Config' . DIRECTORY_SEPARATOR;
        include $pathConfig . 'constants.php';
    } 

    private function _hasRouter($uri)
    {
        return (array_key_exists($uri, self::_getRouterArr()));
    } 

    private function _getRouterArr()
    {
        $pathConfig = self::getPathApp() . 'Config' . DIRECTORY_SEPARATOR;
        $result = include $pathConfig . 'router.php';

        return (!is_array($result))? array(): $result;
    } 



    private function _hasRedirect($uri)
    {
        return (array_key_exists($uri, self::_getRedirectArr()));
    } 

    private function _getRedirectArr()
    {
        $pathConfig = self::getPathApp() . 'Config' . DIRECTORY_SEPARATOR;
        $result = include $pathConfig . 'redirect.php';

        return (!is_array($result))? array(): $result;
    } 







    private function _startConfig()
    {
        self::setPathRoot( dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR );
        self::_loadFileConfig();

        // prepara o get da url
        $uri = (!array_key_exists('zuniphp_uri', $_GET)) ? '': rtrim($_GET['zuniphp_uri'], '/');


        /*
         * --------------------------------------
         * configuracao do Redirect
         * se for parametro valido faz o redirecionamento
         */
        if (self::_hasRedirect($uri))
        {

        $result = self::_getRedirectArr();

            exit(header( sprintf(
                    'location: %s', $result[$uri])
                ) );
        }

        /*
         * --------------------------------------
         * configuracao do Router
         * se for parametro valido, faz o rota
         */

        if (self::_hasRouter($uri))
        {
            $result = self::_getRouterArr();
            $_GET['zuniphp_uri'] = $result[$uri];
        }

    } 


}





