<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2014 - 2015 
 * 
*/


namespace Zuni;


class Css 
{

    private static $_charset = "@charset \"%s\";\n";
    private static $_comment = "/**\n%s\n*/\n";
    private static $_importOpen = "@import '%s'%s;\n";
    private static $_block = "%s{\n%s\n}\n\n";
    private static $_blockMedia = "\t%s{\n%s\n\t}\n\n";
    private static $_media = "@media %s{\n\n%s\n}\n\n";
    private static $_tab = "\t";


    public static function importFile($fileCss, $media= '')
    {
        if (!strstr($fileCss, '//'))
        {
            $fileCss = (!defined('BASE_URL')) ? $fileCss : BASE_URL . $fileCss;
        }

        $media = ($media !=='')? ' '. $media : '';
        $result = sprintf(self::$_importOpen, $fileCss, $media);

        return $result;

    }



    public static function charset($type = 'UTF-8')
    {
        return sprintf(self::$_charset, $type);
    }





    public static function selector($data)
    {
        $style = '';
        $arr = array();

        $name = $data[0];
        $properties = $data[1];

        if(is_array($properties) && count($properties))
        {
            foreach ($properties as $propertie => $value)
            {
                $arr[] = self::$_tab . $propertie . ': ' . $value;
            }
        }


        if(count($arr))
        {
            $style = implode(";\n", $arr);
        }

        $result = sprintf(self::$_block, $name, $style);

        return $result; 

    }




    public static function media($data)
    {

        $media = $data[0];
        self::$_tab = "\t\t";
        self::$_block = self::$_blockMedia;

        unset($data[0]);
        sort($data);

        $selector = self::selector($data);
        $style = sprintf(self::$_media, $media, $selector);

        return $style;

    }







    public static function comment($text)
    {
        return sprintf(self::$_comment, $text);
    }



}

