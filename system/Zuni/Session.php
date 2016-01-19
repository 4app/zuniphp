<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

class Session
{


    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
        return $this;
    }


    public function get($key, $default = '') 
    {
        return (!self::isBykey($key))? $default : $_SESSION[$key];
    }




    public function remove($key) 
    {
        if ($this->isBykey($key)) 
        {
            unset($_SESSION[$key]);
            return TRUE;
        }

        return FALSE;
    }




    /**
     * @return string with the session id.
     */
    public function getId() 
    {
        return session_id();
    }



    /**
     * return the session array
     * @return array of session indexes
     */
    public function display()
    {
        return $_SESSION;
    }




    //---------------------------------------------------------------
    /**
     * 360 = 6hs
     * @param int $cache_expire_num
     */ 
    public function start($cache_expire_num = '')
    {
        session_start();

        if(is_numeric($cache_expire_num))
        {
            session_cache_expire($cache_expire_num);
        }

        return $this;
    }  

    public function destroy() 
    {

        session_start();
        session_unset();
        session_destroy();

        return $this;

    }





    public function pull($key)
    {
        $value = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $value;
    }





    //---------------------------------------------------------------
    /**
     * @return bool
     */
    public function isBykey($key) 
    {
        return array_key_exists($key, $_SESSION);
    }



    /**
     * @param string $key 
     * @param array $valueValidArr example: array(1,2,3)
     * @return bool
     */
    public function isByKeyInArr($key, $valueValidArr) 
    {
        return (in_array(self::get($key), $valueValidArr));
    }

}

// path: Zuni/Session.php 
