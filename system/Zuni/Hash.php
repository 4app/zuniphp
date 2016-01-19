<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2013 - 2015 
 * 
*/


namespace Zuni;





class Hash {
   
    
    /**
     * Hash md5 encode a string
     * @param string $str dados
     * @param string $salt [opcional] 
     * @param int $length maximo de caracter. permitido na string 
     */
    static function md5($str, $salt = '1', $length = 0){
	return self::alg('md5', $str, $salt, $length);
	
    }
    
    
    /**
     * Hash sha1 encode a string
     * @param string $str dados
     * @param string $salt [opcional] 
     * @param int $length maximo de caracter. permitido na string 
     */
    static function sha1($str, $salt = '1', $length = 0){
	return self::alg('sha1', $str, $salt, $length);
    }
    
    
    

    
         /**
     * Hash encode a string
     * @param string $algorithm exempl: md5, sha1, sha256, haval160,4, etc..
     * @param string $str dados
     * @param string $salt [opcional] 
     * @param int $length maximo de caracter. permitido na string 
     */
	 static function alg($algorithm, $str, $salt = '1', $length = 0) {

        $length = (int) $length;

        if ($length > 0)
            $str = substr($str, 0, $length);
	
        $string = hash_init($algorithm, HASH_HMAC, $salt);
        hash_update($string, $str);

        return hash_final($string);
    }
}

