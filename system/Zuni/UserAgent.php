<?php

/*
 *  Part of the ZuniPHP.
 *  
 * @package     ZuniPHP
 * @package	    CodeIgniter
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @author	    EllisLab Dev Team
 * @link        http://4app.github.io/zuniphp
 * @copyright   2015 ZuniPHP 
 * @copyright	2014 - 2015, British CIT (http://bcit.ca/)
*/


namespace Zuni;

class UserAgent {

    private $_agent     = NULL;
    private $isBrowser  = FALSE;
    private $isRobot    = FALSE;
    private $isMobile   = FALSE;
    private $languages  = array();
    private $charsets   = array();
    private $platforms  = array();
    private $browsers   = array();
    private $mobiles    = array();
    private $robots     = array();
    private $platform   = '';
    private $browser    = '';
    private $version    = '';
    private $mobile     = '';
    private $robot      = '';
    private $configAgentArr  = array();
    

    public function __construct(array $configAgentArr)
    {

       $this->configAgentArr = $configAgentArr; 

        if (isset($_SERVER['HTTP_USER_AGENT']))
        {
            $this->_agent = trim($_SERVER['HTTP_USER_AGENT']);
        }

        if ($this->_agent !== NULL && $this->_loadAgentFile())
        {
            $this->_compileData();
        }

    }


    protected function _loadAgentFile()
    {
        $return = FALSE;

        $arr = $this->configAgentArr; 

            if (isset($arr['platforms']))
            {
                $this->platforms = $arr['platforms'];
                unset($arr['platforms']);
                $return = TRUE;
            }

            if (isset($arr['browsers']))
            {
                $this->browsers = $arr['browsers'];
                unset($arr['browsers']);
                $return = TRUE;
            }

            if (isset($arr['mobiles']))
            {
                $this->mobiles = $arr['mobiles'];
                unset($arr['mobiles']);
                $return = TRUE;
            }

            if (isset($arr['robots']))
            {
                $this->robots = $arr['robots'];
                unset($arr['robots']);
                $return = TRUE;
            }

        return $return;
    }


    protected function _compileData()
    {
        $this->_setPlatform();

        foreach (array('_setRobot', '_setBrowser', '_setMobile') as $function)
        {
            if ($this->$function() === TRUE)
            {
                break;
            }
        }
    }


    protected function _setPlatform()
    {
        if (is_array($this->platforms) && count($this->platforms) > 0)
        {
            foreach ($this->platforms as $key => $val)
            {
                if (preg_match('|'.preg_quote($key).'|i', $this->_agent))
                {
                    $this->platform = $val;
                    return TRUE;
                }
            }
        }

        $this->platform = 'Unknown Platform';
        return FALSE;
    }


    protected function _setBrowser()
    {
        if (is_array($this->browsers) && count($this->browsers) > 0)
        {
            foreach ($this->browsers as $key => $val)
            {
                if (preg_match('|'. $key .'.*?([0-9\.]+)|i', $this->_agent, $match))
                {
                    $this->isBrowser = TRUE;
                    $this->version = $match[1];
                    $this->browser = $val;
                    $this->_setMobile();
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    protected function _setRobot()
    {
        if (is_array($this->robots) && count($this->robots) > 0)
        {
            foreach ($this->robots as $key => $val)
            {
                if (preg_match('|'. preg_quote($key) .'|i', $this->_agent))
                {
                    $this->isRobot = TRUE;
                    $this->robot = $val;
                    $this->_setMobile();
                    return TRUE;
                }
            }
        }

        return FALSE;
    }


    protected function _setMobile()
    {
        if (is_array($this->mobiles) && count($this->mobiles) > 0)
        {
            foreach ($this->mobiles as $key => $val)
            {
                if (FALSE !== (stripos($this->_agent, $key)))
                {
                    $this->isMobile = TRUE;
                    $this->mobile = $val;
                    return TRUE;
                }
            }
        }

        return FALSE;
    }

    public function isBrowser($key = NULL)
    {
        if ( ! $this->isBrowser)
        {
            return FALSE;
        }

        if ($key === NULL)
        {
            return TRUE;
        }

        return (isset($this->browsers[$key]) && $this->browser === $this->browsers[$key]);
    }


    public function isRobot($key = NULL)
    {
        if ( ! $this->isRobot)
        {
            return FALSE;
        }

        // No need to be specific, it's a robot
        if ($key === NULL)
        {
            return TRUE;
        }

        // Check for a specific robot
        return (isset($this->robots[$key]) && $this->robot === $this->robots[$key]);
    }


    public function isMobile($key = NULL)
    {
        if ( ! $this->isMobile)
        {
            return FALSE;
        }

        // No need to be specific, it's a mobile
        if ($key === NULL)
        {
            return TRUE;
        }

        // Check for a specific robot
        return (isset($this->mobiles[$key]) && $this->mobile === $this->mobiles[$key]);
    }

    /**
     * Agent String
     *
     * @return	string
     */
    public function getAgentString()
    {
        return $this->_agent;
    }


    public function getPlatform()
    {
        return $this->platform;
    }


    public function getBrowser()
    {
        return $this->browser;
    }




    public function getVersion()
    {
        return $this->version;
    }


    public function getRobot()
    {
        return $this->robot;
    }

    public function getMobile()
    {
        return $this->mobile;
    }
}
