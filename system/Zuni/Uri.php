<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

class Uri {

    private static $_uri = FALSE;
    private static $_explode = array();
    private static $_controller = NULL;
    private static $_action = NULL;
    private static $_params = array();



    private function __construct() {}





    private static function _uri()
    {
        $uri = 'zuniphp_uri';
        $uri = (!array_key_exists($uri, $_GET)) ? FALSE : $_GET[$uri];
        return $uri;
    }






    private static function _init() 
    {
        self::$_uri = self::_uri();
        self::$_explode = (self::$_uri) ? explode('/', trim(self::$_uri, '/')) : NULL;
    }





    //-----------------------------------------------------------
    /**
     * retorna controller atual
     */
    public static function getController() 
    {
        self::_init();
        self::$_controller = 
            (
                (self::$_explode != NULL) &&
                (array_key_exists(0, self::$_explode))
            ) ?
            self::_clean(self::$_explode[0]) : INDEX_CONTROLLER;

        self::$_controller = str_replace('-', '_', self::$_controller);
        return self::$_controller;
    }





    //----------------------------------------------------------
    /**
     * retorna action atual
     * 
     */
    public static function getAction() 
    {
        self::_init();
        self::$_action = 
            (
                (self::$_explode != NULL) && 
                (array_key_exists(1, self::$_explode))
            ) ? 
            self::_clean(self::$_explode[1]) : 'index';

        self::$_action = str_replace('-', '_', self::$_action);
        return self::$_action;
    }





    //------------------------------------------------------------
    /**
     * Verifica se o controller esta identico ao valor passado
     * @param string $controllerUri
     * @return bool
     */
    public static function hasController($controllerUri)
    {
        return (self::controller() === $controllerUri);
    }





    //--------------------------------------------------------
    /**
     * Verifica se a action esta identico ao valor passado
     * @param string $actionUri
     * @return bool
     */
    public static function hasAction($actionUri)
    {
        return (self::action() === $actionUri);
    }





    //--------------------------------------------------------
    /**
     * Limpa parametros: permitindo somente: letras(a-zA-Z) numeros(0-9) e hifen/underline(-_)
     * se for diferente sera eliminado
     * @param $param string
     */
    private static function _clean($param) {
        return preg_replace('/[^a-zA-Z\]0-9\]_-]/', '', $param);
    }





    //----------------------------------------------------------------
    /**
     * retorna uma parte da url separado por "/"
     * @example
     * http://meu-site.com/noticia/esporte/fulano-fez-gol/56
     *
     * Zuni_Uri::segment(3) // considerando que o controller eh o numero 0
     *
     * retorna 56
     */
    public static function getSegment($n, $default = FALSE) 
    {
        self::_init();
        $n = (int) $n;
        $segment = (array_key_exists($n, self::$_explode)) ? self::_clean(self::$_explode[$n]) : $default;
        return $segment;
    }





    //----------------------------------------------------------------
    /**
     * retorna a uri completa
     */
    public static function getFull() 
    {
        self::_init();

        return self::$_uri;
    }








    //----------------------------------------------------------------
    /**
     * Permite tranformar segmentos URI em uma array associativa de pares key/value
     * @param $name string [opcional]
     * @example http://meusite.com/sapato/couro/id/1
     * 
     * Zuni_Uri::assoc('id'); // retorna 1
     * @return string
     */
    public static function getAssoc($name, $default = NULL)
    {
        self::_init();

        $ind = array();
        $value = array();

        unset(self::$_explode[0], self::$_explode[1]);
        if (end(self::$_explode) == null)
            array_pop(self::$_explode);

        $i = 0;
        if (!empty(self::$_explode))
        {
            foreach (self::$_explode as $val) 
            {
                if ($i % 2 == 0)
                {
                    $ind[] = $val;
                }
                else
                {
                    $value[] = $val;
                }

                $i++;
            }
        }

        if (!empty($ind) && !empty($value) && count($ind) == count($value))
            self::$_params = array_combine($ind, $value);

        return (($name != '') && (array_key_exists($name, self::$_params))) ? self::$_params[$name] : $default;
    }








    //-----------------------------------------------------------------
    /**
     *  Redirect
     * @param string $url /
     */
    public static function redirect($url = '') 
    {
        $constBaseUrl = (defined('BASE_URL'));
        if (($url) && (!strstr($url, '//')) && ($constBaseUrl))
            $url = BASE_URL . $url;


        exit(header('Location: ' . $url));
    }



    //-----------------------------------------------------------------
    /**
     * 
     * 
     * 
     * faz o refresh na pagina
     * @param string $url - destino (string)
     * $param int $second - segundos (int)
     */
    public static function refresh($url = '', $second = 0) 
    {

        $constBaseUrl = (defined('BASE_URL'));

        if (($url) && (!strstr($url, '//')) && ($constBaseUrl))
            $url = BASE_URL . $url;

        header('refresh:' . $second . ';url=' . $url); // refresh
    }








}

// Path: system/Zuni/Uri.php


