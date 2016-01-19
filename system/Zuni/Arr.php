<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

class Arr {

    /**
     *     Arr->toAssoc(array('foo','bar'));
     *
     * @return  array
     */
    public function toAssoc($arr) {
        if (($count = count($arr)) % 2 > 0)
        {
            return array();
        }

        $keys = $vals = array();

        for ($i = 0; $i < $count - 1; $i += 2)
        {
            $keys[] = array_shift($arr);
            $vals[] = array_shift($arr);
        }
        return array_combine($keys, $vals);
    }

    /**
     * @param   array  $array  check
     * @return  bool   TRUE array assoc, FALSE se nao
     */
    public function isAssoc($array) 
    {
        if (!is_array($array))
        {
            return array();
        }

        $num = 0;
        foreach ($array as $key => $value)
        {
            if ((!is_int($key)) || ($key !== $num++))
            {
                return TRUE;
            }
        }

        return FALSE;
    }

    /**
     * array_unshift() encapsulated
     * @param array $array
     * @param mixed $value
     * @return array
     */
    public function addFirsh($array, $value) {

        if (!is_array($array))
            return array();


        array_unshift($array, $value);
        return $array;
    }

    /**
     * array_push() encapsulated
     * @param array $array
     * @param mixed $value
     * @return array
     */
    public function addLast($array, $value) {
        if (!is_array($array))
            return array();

        array_push($array, $value);
        return $array;
    }

    /**
     * array_shift()  encapsulated
     * @param array $array
     * @return array
     */
    public function removeFirsh($array) 
    {

        if (!is_array($array))
            return array();


        array_shift($array);
        return $array;
    }

    /**
     * array_pop() encapsulated
     * @param array $array
     * @return array
     */
    public function removeLast($array) {

        if (!is_array($array))
            return array();

        array_pop($array);
        return $array;
    }





    public function removeItem($removeArr, $arr)
    {
        foreach ($removeArr  as $row)
        {
            if(array_key_exists($row , $arr))
            {
                unset($arr[$row]);
            }
        }

        return $arr;
    } 


    /**
     * $arr = new \Zuni\Arr();
      $title = array(
      'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
      'Fusce interdum augue a lacus varius, eget suscipit tortor dictum',
      'Nullam porttitor massa id nisi elementum egestas',
      'Pellentesque ornare elit a lacus pharetra luctus',
      'Vivamus tempus ligula sit amet consequat adipiscing',
      'Ut semper leo ut dolor mollis tristique',
      );
      echo $arr->rand($title);
     */
    public function rand($array) {
        return (!is_array($array)) ? array() : $array[array_rand($array)];
    }

    public function value($key, $array, $default = FALSE) {
        return (!array_key_exists($key, $array)) ? $default : $array[$key];
    }



    
    public function flip($array) {
        return (!is_array($array)) ? array() : array_flip($array);
    }



    public function join() {
        $result = array();

        foreach (func_get_args() as $array) {
            if (!is_array($array))
                $array = array($array);

            $result = array_merge($result, $array);
        }
        return $result;
    }

    public function orderByKey($records, $reverse = FALSE) {
        $hash = array();

        foreach ($records as $k => $v)
            $hash[$k] = $v;

        ($reverse) ? krsort($hash) : ksort($hash);

        $records = array();

        foreach ($hash as $k => $v)
            $records[$k] = $v;

        return $records;
    }

    public function orderByValue($records, $reverse = FALSE) {
        $hash = array();
        foreach ($records as $k => $v)
            $hash[$k] = $v;

        ($reverse) ? arsort($hash) : asort($hash);

        $records = array();

        foreach ($hash as $k => $v)
            $records[$k] = $v;


        return $records;
    }

}

