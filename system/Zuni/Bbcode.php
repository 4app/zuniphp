<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

 
class Bbcode{


/**
 * @param string $str
 * @param array $addBbcodeArr
 * 
 */
static function toHtml($str, $addBbcodeArr = array(), $entities = FALSE) {  
if($entities)
$str = htmlentities($str);  



    $addBbcodeArr = (!is_array($addBbcodeArr)) ? array() : $addBbcodeArr;
  
    $replaceArr = array(  
                '/\{baseUrl}/is' => BASE_URL, 
                '/\[<\]/is' => '&lt;', 
                '/\[>\]/is' => '&gt;', 
                '/\[br\]/is' => '<br />', 
                '/\[div.(.*?)\]/is' => '<div class="$1">', 
                '/\[div#(.*?)\]/is' => '<div id="$1">', 
                '/\[\/div\]/is' => '</div>', 
                '/\[b\](.*?)\[\/b\]/is' => '<strong>$1</strong>',    
                '/\[ul\](.*?)\[\/ul\]/is' => '<ul>$1</ul>',    
                '/\[ol\=1](.*?)\[\/ol\]/is' => '<ol>$1</ol>',    
                '/\[\*\](.*?)\[\]/is' => '<li>$1</li>',    
                '/\[li\](.*?)\[\/li\]/is' => '<li>$1</li>',  
                '/\[li\](.*?)\[\]/is' => '<li>$1</li>',  
                '/\[i\](.*?)\[\/i\]/is' => '<em>$1</em>',  
                '/\[u\](.*?)\[\/u\]/is' => '<u>$1</u>',   
                '/\[url\=(.*?)\](.*?)\[\/url\]/is' => '<a href="$1" title="$2 - $1">$2</a>',  
                '/\[url\](.*?)\[\/url\]/is' => '<a href="$1" title="$1">$1</a>',   
                '/\[a\=(.*?)\](.*?)\[\/a\]/is' => '<a href="$1" title="$2 - $1">$2</a>',  
                '/\[a\](.*?)\[\/a\]/is' => '<a href="$1" title="$1">$1</a>',   
                '/\[align\=(left|center|right)\](.*?)\[\/align\]/is' => '<div style="text-align: $1;">$2</div>',  
                '/\[img\](.*?)\[\/img\]/is' => '<img src="$1" alt="" />',  
                '/\[img\=(.*?)\](.*?)\[\/img\]/is' => '<img src="$1" alt="$2" />',  
                '/\[mailto\=(.*?)\](.*?)\[\/mailto\]/is' => '<a href="mailto:$1">$2</a>',  
                '/\[mailto\](.*?)\[\/mailto\]/is' => '<a href="mailto:$1">$1</a>',  
                '/\[mailsafe\](.*?)@(.*?)\[\/mailsafe\]/is' => '<script type="text/javascript">var user = "$1";var at = "@";var domain = "$2";document.write(user + at + domain);</script>',  
                '/\[mailtosafe\](.*?)@(.*?)\[\/mailtosafe\]/is' => '<script type="text/javascript">var user = "$1";var at = "@";var domain = "$2";document.write(\'<a href="\'+ \'mail\' +\'to:\'+ user + at + domain +\'">\'+ user + at + domain +\'</a>\');</script>',  
                '/\[mailtosafe\=(.*?)@(.*?)\](.*?)\[\/mailtosafe\]/is' => '<script type="text/javascript">var user = "$1";var at = "@";var domain = "$2";document.write(\'<a href="\'+ \'mail\' +\'to:\'+ user + at + domain +\'">\'+ \'$3\' +\'</a>\');</script>',  
                '/\[font\=(.*?)\](.*?)\[\/font\]/is' => '<span style="font-family: $1;">$2</span>',  
                '/\[size\=(.*?)\](.*?)\[\/size\]/is' => '<span style="font-size: $1;">$2</span>',  
                '/\[color\=(.*?)\](.*?)\[\/color\]/is' => '<span style="color: $1;">$2</span>', 
              '/\[pre\](.*?)\[\/pre\]/is' => '<pre>$1</pre>',  
              '/\[code\](.*?)\[\/code\]/is' => '<pre>$1</pre>',  
              '/\[p\](.*?)\[\/p\]/is'  => '<p>$1</p>' 
                );  

    $replaceArr = $replaceArr + $addBbcodeArr;
    $search = array_keys($replaceArr);
    $replace = array_values($replaceArr);
    
    // Do simple BBCode's  
    return preg_replace ($search, $replace, $str);  
  
}


}


   
// path: Zuni/Helper/Bbcode.php 
