<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;


class Input {
    
    
    
    
    

    //-----------------------------------------------------------------
    /**
     * verifica se o $_POT foi acionado
     * @param string $name valor da chave (key)
     * @param string $default se nao foi acionado retorna padrao 
     */
    public function post($name, $default = '') {
        return self::type($_POST, $name, $default);
    }
    
    

    //-----------------------------------------------------------------
    /**
     * verifica se o $_GET foi acionado
     * @param string $param valor da chave (key)
     * @param string $default se nao foi acionado retorna padrao 
     */
    public function get($name, $default = '') {
        return self::type($_GET, $name, $default);
    }

    //-----------------------------------------------------------------
    /**
     * verifica se o $_SESSION foi acionado
     * @param string $param valor da chave (key)
     * @param string $default se nao foi acionado retorna padrao 
     */
    public function session($name, $default = '') {
        return self::type($_SESSION, $name, $default);
    }

    //-----------------------------------------------------------------
    /**
     * verifica se o $_COOKIE foi acionado
     * @param string $name valor da chave (key)
     * @param string $default se nao foi acionado retorna padrao 
     */
    public function cookie($name, $default = '') {
        return self::type($_COOKIE, $name, $default);
    }

    //-----------------------------------------------------------------
    /**
     * verifica se o $_COOKIE foi acionado
     * @param string $name valor da chave (key)
     * @param string $default se nao foi acionado retorna padrao 
     */
    public function request($name, $default = '') {
        return self::type($_REQUEST, $name, $default);
    }

    /**
     * verifica se foi definido os array: $_POST, $_GET etc
     * @example type($_POST, 'nome') ou type($_POST, array('nome', 'fulano'))
     */
    public function type($type, $name, $default = '') {


        $key = (is_array($name)) ? $name[0] : $name;
        $isset = (array_key_exists($key, $type)) ? TRUE : FAlSE;

        if (is_array($name)) {

            $key = $name[0];
            $value = (array_key_exists(1, $name)) ? $name[1] : FALSE;
            $isset = (array_key_exists($key, $type) && $type[$key] == $value) ? TRUE : FAlSE;
        }

        return ($isset) ? $type[$key] : $default;
    }
    
 
}

