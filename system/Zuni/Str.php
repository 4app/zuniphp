<?php

/*
 * @package     ZuniPHP
 * @package     WordPress
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;




 
 class Str{
 
 
 
//  ----------------------------------------------------------------
// fonte: http://goo.gl/T7sX7
/**
 * Converte todos os caracteres acentuados para caracteres ASCII
 * Se nao houver caracteres acentuados, entao a string e apenas retornado
 * @package: WordPress
 * @since 1.2.1
 * @param string $string Texto que pode ter caracteres acentuados
 * @return string filtrada com substituiu o "bom" caracteres.

 */

function ascii($string) {
    if (!preg_match('/[\x80-\xff]/', $string))
        return $string;

    if ($this->seemsUtf8($string)) {
        $chars = array(
            // Decomposição Complemento para Latin-1
            chr(195) . chr(128) => 'A', chr(195) . chr(129) => 'A',
            chr(195) . chr(130) => 'A', chr(195) . chr(131) => 'A',
            chr(195) . chr(132) => 'A', chr(195) . chr(133) => 'A',
            chr(195) . chr(135) => 'C', chr(195) . chr(136) => 'E',
            chr(195) . chr(137) => 'E', chr(195) . chr(138) => 'E',
            chr(195) . chr(139) => 'E', chr(195) . chr(140) => 'I',
            chr(195) . chr(141) => 'I', chr(195) . chr(142) => 'I',
            chr(195) . chr(143) => 'I', chr(195) . chr(145) => 'N',
            chr(195) . chr(146) => 'O', chr(195) . chr(147) => 'O',
            chr(195) . chr(148) => 'O', chr(195) . chr(149) => 'O',
            chr(195) . chr(150) => 'O', chr(195) . chr(153) => 'U',
            chr(195) . chr(154) => 'U', chr(195) . chr(155) => 'U',
            chr(195) . chr(156) => 'U', chr(195) . chr(157) => 'Y',
            chr(195) . chr(159) => 's', chr(195) . chr(160) => 'a',
            chr(195) . chr(161) => 'a', chr(195) . chr(162) => 'a',
            chr(195) . chr(163) => 'a', chr(195) . chr(164) => 'a',
            chr(195) . chr(165) => 'a', chr(195) . chr(167) => 'c',
            chr(195) . chr(168) => 'e', chr(195) . chr(169) => 'e',
            chr(195) . chr(170) => 'e', chr(195) . chr(171) => 'e',
            chr(195) . chr(172) => 'i', chr(195) . chr(173) => 'i',
            chr(195) . chr(174) => 'i', chr(195) . chr(175) => 'i',
            chr(195) . chr(177) => 'n', chr(195) . chr(178) => 'o',
            chr(195) . chr(179) => 'o', chr(195) . chr(180) => 'o',
            chr(195) . chr(181) => 'o', chr(195) . chr(182) => 'o',
            chr(195) . chr(182) => 'o', chr(195) . chr(185) => 'u',
            chr(195) . chr(186) => 'u', chr(195) . chr(187) => 'u',
            chr(195) . chr(188) => 'u', chr(195) . chr(189) => 'y',
            chr(195) . chr(191) => 'y',
            // Decomposição de Latim estendido-A
            chr(196) . chr(128) => 'A', chr(196) . chr(129) => 'a',
            chr(196) . chr(130) => 'A', chr(196) . chr(131) => 'a',
            chr(196) . chr(132) => 'A', chr(196) . chr(133) => 'a',
            chr(196) . chr(134) => 'C', chr(196) . chr(135) => 'c',
            chr(196) . chr(136) => 'C', chr(196) . chr(137) => 'c',
            chr(196) . chr(138) => 'C', chr(196) . chr(139) => 'c',
            chr(196) . chr(140) => 'C', chr(196) . chr(141) => 'c',
            chr(196) . chr(142) => 'D', chr(196) . chr(143) => 'd',
            chr(196) . chr(144) => 'D', chr(196) . chr(145) => 'd',
            chr(196) . chr(146) => 'E', chr(196) . chr(147) => 'e',
            chr(196) . chr(148) => 'E', chr(196) . chr(149) => 'e',
            chr(196) . chr(150) => 'E', chr(196) . chr(151) => 'e',
            chr(196) . chr(152) => 'E', chr(196) . chr(153) => 'e',
            chr(196) . chr(154) => 'E', chr(196) . chr(155) => 'e',
            chr(196) . chr(156) => 'G', chr(196) . chr(157) => 'g',
            chr(196) . chr(158) => 'G', chr(196) . chr(159) => 'g',
            chr(196) . chr(160) => 'G', chr(196) . chr(161) => 'g',
            chr(196) . chr(162) => 'G', chr(196) . chr(163) => 'g',
            chr(196) . chr(164) => 'H', chr(196) . chr(165) => 'h',
            chr(196) . chr(166) => 'H', chr(196) . chr(167) => 'h',
            chr(196) . chr(168) => 'I', chr(196) . chr(169) => 'i',
            chr(196) . chr(170) => 'I', chr(196) . chr(171) => 'i',
            chr(196) . chr(172) => 'I', chr(196) . chr(173) => 'i',
            chr(196) . chr(174) => 'I', chr(196) . chr(175) => 'i',
            chr(196) . chr(176) => 'I', chr(196) . chr(177) => 'i',
            chr(196) . chr(178) => 'IJ', chr(196) . chr(179) => 'ij',
            chr(196) . chr(180) => 'J', chr(196) . chr(181) => 'j',
            chr(196) . chr(182) => 'K', chr(196) . chr(183) => 'k',
            chr(196) . chr(184) => 'k', chr(196) . chr(185) => 'L',
            chr(196) . chr(186) => 'l', chr(196) . chr(187) => 'L',
            chr(196) . chr(188) => 'l', chr(196) . chr(189) => 'L',
            chr(196) . chr(190) => 'l', chr(196) . chr(191) => 'L',
            chr(197) . chr(128) => 'l', chr(197) . chr(129) => 'L',
            chr(197) . chr(130) => 'l', chr(197) . chr(131) => 'N',
            chr(197) . chr(132) => 'n', chr(197) . chr(133) => 'N',
            chr(197) . chr(134) => 'n', chr(197) . chr(135) => 'N',
            chr(197) . chr(136) => 'n', chr(197) . chr(137) => 'N',
            chr(197) . chr(138) => 'n', chr(197) . chr(139) => 'N',
            chr(197) . chr(140) => 'O', chr(197) . chr(141) => 'o',
            chr(197) . chr(142) => 'O', chr(197) . chr(143) => 'o',
            chr(197) . chr(144) => 'O', chr(197) . chr(145) => 'o',
            chr(197) . chr(146) => 'OE', chr(197) . chr(147) => 'oe',
            chr(197) . chr(148) => 'R', chr(197) . chr(149) => 'r',
            chr(197) . chr(150) => 'R', chr(197) . chr(151) => 'r',
            chr(197) . chr(152) => 'R', chr(197) . chr(153) => 'r',
            chr(197) . chr(154) => 'S', chr(197) . chr(155) => 's',
            chr(197) . chr(156) => 'S', chr(197) . chr(157) => 's',
            chr(197) . chr(158) => 'S', chr(197) . chr(159) => 's',
            chr(197) . chr(160) => 'S', chr(197) . chr(161) => 's',
            chr(197) . chr(162) => 'T', chr(197) . chr(163) => 't',
            chr(197) . chr(164) => 'T', chr(197) . chr(165) => 't',
            chr(197) . chr(166) => 'T', chr(197) . chr(167) => 't',
            chr(197) . chr(168) => 'U', chr(197) . chr(169) => 'u',
            chr(197) . chr(170) => 'U', chr(197) . chr(171) => 'u',
            chr(197) . chr(172) => 'U', chr(197) . chr(173) => 'u',
            chr(197) . chr(174) => 'U', chr(197) . chr(175) => 'u',
            chr(197) . chr(176) => 'U', chr(197) . chr(177) => 'u',
            chr(197) . chr(178) => 'U', chr(197) . chr(179) => 'u',
            chr(197) . chr(180) => 'W', chr(197) . chr(181) => 'w',
            chr(197) . chr(182) => 'Y', chr(197) . chr(183) => 'y',
            chr(197) . chr(184) => 'Y', chr(197) . chr(185) => 'Z',
            chr(197) . chr(186) => 'z', chr(197) . chr(187) => 'Z',
            chr(197) . chr(188) => 'z', chr(197) . chr(189) => 'Z',
            chr(197) . chr(190) => 'z', chr(197) . chr(191) => 's',
            // Euro Sign
            chr(226) . chr(130) . chr(172) => 'E',
            // GBP (Pound) Sign
            chr(194) . chr(163) => '');

        $string = strtr($string, $chars);
    } else {
        // Suponha ISO-8859-1 caso nao seja UTF-8
        $chars['in'] = chr(128) . chr(131) . chr(138) . chr(142) . chr(154) . chr(158)
                . chr(159) . chr(162) . chr(165) . chr(181) . chr(192) . chr(193) . chr(194)
                . chr(195) . chr(196) . chr(197) . chr(199) . chr(200) . chr(201) . chr(202)
                . chr(203) . chr(204) . chr(205) . chr(206) . chr(207) . chr(209) . chr(210)
                . chr(211) . chr(212) . chr(213) . chr(214) . chr(216) . chr(217) . chr(218)
                . chr(219) . chr(220) . chr(221) . chr(224) . chr(225) . chr(226) . chr(227)
                . chr(228) . chr(229) . chr(231) . chr(232) . chr(233) . chr(234) . chr(235)
                . chr(236) . chr(237) . chr(238) . chr(239) . chr(241) . chr(242) . chr(243)
                . chr(244) . chr(245) . chr(246) . chr(248) . chr(249) . chr(250) . chr(251)
                . chr(252) . chr(253) . chr(255);

        $chars['out'] = "EfSZszYcYuAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy";

        $string = strtr($string, $chars['in'], $chars['out']);
        $double_chars['in'] = array(chr(140), chr(156), chr(198), chr(208), chr(222), chr(223), chr(230), chr(240), chr(254));
        $double_chars['out'] = array('OE', 'oe', 'AE', 'DH', 'TH', 'ss', 'ae', 'dh', 'th');
        $string = str_replace($double_chars['in'], $double_chars['out'], $string);
    }

    return $string;
}






//---------------------------------------------------------------
/**
 * Checks to see if a string is utf8 encoded. - ERIFICAÇÕES para ver se uma string é utf8 codificado.
 * NOTE: This function checks for 5-Byte sequences, UTF8
 *       has Bytes Sequences with a maximum length of 4.
 * @package: WordPress
 * @author bmorel at ssi dot fr (modified)
 * @since 1.2.1
 *
 * @param string $str The string to be checked
 * @return bool True if $str fits a UTF-8 model, false otherwise.
 */
function seemsUtf8($str) {
    $length = strlen($str);
    for ($i = 0; $i < $length; $i++) {
        $c = ord($str[$i]);
        if ($c < 0x80)
            $n = 0;# 0bbbbbbb
        elseif (($c & 0xE0) == 0xC0)
            $n = 1;# 110bbbbb
        elseif (($c & 0xF0) == 0xE0)
            $n = 2;# 1110bbbb
        elseif (($c & 0xF8) == 0xF0)
            $n = 3;# 11110bbb
        elseif (($c & 0xFC) == 0xF8)
            $n = 4;# 111110bb
        elseif (($c & 0xFE) == 0xFC)
            $n = 5;# 1111110b
        else
            return false;# Does not match any model
        for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
            if ((++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
                return false;
        }
    }
    return true;
}






//---------------------------------------------------------------
/**
 * Encode the Unicode values to be used in the URI.
 * @package: WordPress
 * @since 1.5.0
 *
 * @param string $utf8_string
 * @param int $length Max length of the string
 * @return string String with Unicode encoded for URI.
 */
function utf8UriEncode($utf8_string, $length = 0) {
    $unicode = '';
    $values = array();
    $num_octets = 1;
    $unicode_length = 0;

    $string_length = strlen($utf8_string);
    for ($i = 0; $i < $string_length; $i++) {

        $value = ord($utf8_string[$i]);

        if ($value < 128) {
            if ($length && ( $unicode_length >= $length ))
                break;
            $unicode .= chr($value);
            $unicode_length++;
        } else {
            if (count($values) == 0)
                $num_octets = ( $value < 224 ) ? 2 : 3;

            $values[] = $value;

            if ($length && ( $unicode_length + ($num_octets * 3) ) > $length)
                break;
            if (count($values) == $num_octets) {
                if ($num_octets == 3) {
                    $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]) . '%' . dechex($values[2]);
                    $unicode_length += 9;
                } else {
                    $unicode .= '%' . dechex($values[0]) . '%' . dechex($values[1]);
                    $unicode_length += 6;
                }

                $values = array();
                $num_octets = 1;
            }
        }
    }

    return $unicode;
}






//---------------------------------------------------------------
/**
 * título, substituindo espaços em branco com traços.<br />
 * Limita a saída para caracteres alfanuméricos, sublinhados (_) e traço (-).
 * @package: WordPress
 * @since 1.2.0
 * @param string $title - O título a ser higienizado.
 * @return string - O título higienizado.

  exemplo:
  echo slug("InTérnâcíonAl Câmpéão dO MùNDó");
  retorna internacional-campeao-do-mundo
 */
function slug($string, $space='-') {
    
    
    $string = strip_tags($string);
    // Preserve escaped octets.
    $string = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $string);
    // Remove percent signs that are not part of an octet.
    $string = str_replace('%', '', $string);
    // Restore octets.
    $string = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $string);

    $string = $this->ascii($string);
    if ($this->seemsUtf8($string)) {
        if (function_exists('mb_strtolower')) {
            $string = mb_strtolower($string, 'UTF-8');
        }
        $string = $this->utf8UriEncode($string, 200);
    }

    $space = str_replace(' ', '', $space);
    $space = (($space !='') && ($space !='-'))? $space: '-';
    
    $string = strtolower($string);
    $string = preg_replace('/&.+?;/', '', $string); // kill entities
    $string = str_replace('.', $space, $string);
    $string = preg_replace('/[^%a-z0-9 _-]/', '', $string);
    $string = preg_replace('/\s+/', $space, $string);
    $string = preg_replace('|-+|', $space, $string);
    $string = trim($string, $space);

    return $string;
}



//------------------------------------------------------------
/*
  exemplo:::
  echo stretch('Confira 15 dicas fundamentais para decorar casas de idosos Segurança',45);
  retorno:   Confira 15 dicas fundamentais para decorar ...
 */
/**
 * mostra um trecho do text sem cortar palavras e tira as tags HTML
 * @param string $string
 * @param int $n numero maximo de caracter
 * @param string [opcional] padrao '...'
 */
function truncate($string, $n = 100, $reluctance='...') {

    $total = strlen($string);
    $string = substr(strip_tags($string), 0, $n);
    $separator = explode(' ', $string);
    $end = '';
    
    if ($total >= $n) {
        $count = count($separator);
        
        for ($i = 0; $i < ($count - 1); $i++) {
            $end .= $separator[$i] . ' ';
        }
        $end .= $reluctance;
    } else {
        $end = $string;
    }
    return $end;
}




//------------------------------------------------------------
/**
 * Limpa completamente uma string retirando espacos e tags html/php/javascript
 * @param string $string
 * @return string
 */
function clean($string) {
    return strip_tags(trim($string));
}


//------------------------------------------------------------
/**
   Permite que voce substitua texts encontrados em um array associativo.
  @source: Wes Foster 17-Dec-2009 09:32 http://php.net/manual/en/function.str-replace.php

  exemplo:
$replace = array(
  'o carro'=>'a moto',
  'azul'=>'vermelha'
  );
  $string = 'o carro azul pertence ao fulano.';
  echo textReplaceAssoc($replace,$string);
  retorna: a moto vermelha pertence ao fulano.
 */

function replace($arraykeyValue, $string) {
    return str_replace(array_keys($arraykeyValue), array_values($arraykeyValue), $string);
}







//--------------------------------------------------
/**
 * destacas as palavras destacadas no texto
 * @param string $string texto que vai ser procurado a palavra
 * @param string $word palavra que vai ser destacada
 * @param string $highlight padrao &lt;span class="highlight"&gt;%s&lt;/span&gt;
 * 
 */
function highlight($string, $word, $highlight = '<span class="highlight">%s</span>') {
    
    $highlight = sprintf($highlight, $word);
    return str_replace($word, $highlight, $string);

}



//--------------------------------------------------
/*
 * nome original: parseHyperlinks($string)
 * @by: Cory LaViska
 * twitter@abeautifulsite
 * @source: http://migre.me/9UVRO
 */
/**
 * adiciona a tag <a> em todas as 
 * urls encontradas na string
 * @param string $string
 */
function autoLinkUrl($string) {
    // Add <a> tags around all hyperlinks in $string
    $ereg_replace = "[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]";
    $url = "<a href=\"\\0\">\\0</a>";
    return ereg_replace($ereg_replace, $url, $string);
}




//--------------------------------------------------
/*
 * nome original: parseEmails($string)
 * @by: Cory LaViska
 * twitter@abeautifulsite
 * @source: http://migre.me/9UVRO
 */
/**
 * adiciona a tag <a href="mailto:email">email</a>
 * em todos os emails encontrados na string
 * @param string $tex
 */
function autoLinkEmail($string) {
    // Add <a> tags around all email addresses in $string
    $ereg_replace = "[_A-Za-z0-9-]+(\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\.[A-Za-z0-9-]+)*(\.[A-Za-z]{2,3})";
    $email = "<a href=\"mailto:\\0\">\\0</a>";
    return ereg_replace($ereg_replace, $email, $string);
}

/**
 * Executa a funcionalidade em ambos 
 * os textAutoLinkUrl() e textAutoLinkEmails() 
 * na string fornecida
 * @param $string
 */
function autoLink($string) {

    return $this->autoLinkUrl($this->autoLinkEmail($string));
    
}



/**
 * cria uma string aleatoria
 * @param string $type validos: alnum, alpha, lowernum, uppernum, lower, upper, numeric ou num
 * @param int $len define o maximo de caracteres
 * @param string $extra adiciona outros caracteres
 * @return string 
 */
function random($type = NULL, $len = 6, $extra = NULL){
       
       $extra = str_replace(array('&', ';', ',', "'", '"'), '', $extra);
       $len = (int) ($len > 0) ? $len : 6;
       
       // abcdefghijklmnopqrstuvwxyz removidos letras: "o" e "l"
       $lower = 'abcdefghijkmnpqrstuvwxyz';
       
       // ABCDEFGHIJKLMNOPQRSTUVWXYZ - removidos letras: "O" e "I"
       $upper = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
       
       // removidos numeros: "0" e "1"
       $num = '23456789'; 
       
       
       // alnum, alpha, lowernum, uppernum, lower, upper, numeric ou num 
       
       $string = $lower . $upper . $num . $extra;
       
       switch (strtolower($type)) {
           case 'alnum':
               $string = $lower . $upper . $num . $extra;
               break;
           case 'alpha':
               $string = $lower . $upper . $extra;
               break;
           
           case 'lowernum':
               $string = $lower . $num . $extra;
               break;
           
           case 'uppernum':
               $string = $upper . $num . $extra;
               break;
           
           
           case 'lower':
               $string = $lower . $extra;
               break;
           
           
           case 'upper':
               $string = $upper . $extra;
               break;
           
           case 'numeric':
           case 'num':
               $string = $num . $extra;
               break;
      }
      
      $result = array();
      $lenStr = strlen($string);
      for ($n = 1; $n <= $len; $n++) {
		$rand = mt_rand(1, $lenStr);
		$result[]= $string[$rand-1];
	}
        
        return implode('', $result);
      
      
   }
   
   
   //------------------------------------------------------------
    /**
     * codifica o texto:
     * <, >, &, " e ' 
     * @param	string
     * @return	string
     */
    function encodeHtmlTag($str) {

        return str_replace(
                        array('<', '>', '&', '"', "'"), array('&lt;', '&gt;', '&amp;', '&#39;'), $str);
    }
    
    
    
    
    //-----------------------------------------------------------------
    /**  
     * remove a tabulacao e quebra de linha da string 
     * troca nome da funcao prara stripIdentation($str)
     * @param string
     */
    static function stripIndentation($str) {
        return str_replace(array('  ', "\r\n", "\n\r", "\r", "\n", "\t"), '', $str);
    }

 
 }
 
 
    

// path: Zuni/Helper/Str.php 

    
    
