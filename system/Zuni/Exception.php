<?php

/*
 * @package     ZuniPHP
 * @author      Estefanio NS <estefanions AT gmail DOT com>
 * @link        http://4app.github.io/zuniphp
 * @copyright   2010 - 2015 
 * 
*/


namespace Zuni;

class Exception extends \Exception {

    static function Trace(\Exception $exception, $code = 0) {


        $traceAsString = $exception->getTrace();

        $style = implode('; ', array(
            'color: #444',
            'background: #f9f9f9',
            'padding: 10px',
            'margin: 10px',
            'border: 1px solid #ccc'
                ));

        $error = '<div style="' . $style . '">';
        $error .= '<b style="color: #6B0202">%s</b><br />%s</div>';

        $message = '';
        $message .= '<b>File:</b> ' . $traceAsString[$code]['file'] . '<br />';
        $message .= '<b>Line:</b> ' . $traceAsString[$code]['line'] . '<br />';
        $message .= '<b>Class:</b> ' . $traceAsString[$code]['class'];
        $message .= ' <b>' . $traceAsString[$code]['type'] . '</b> ';
        $message .= $traceAsString[$code]['function'] . '()<br />';
        $message .= '<b>Args:</b> ' . implode(', ', $traceAsString[$code]['args']) . '<br />';

        exit(sprintf($error, $exception->getMessage(), $message));
    }

    static function TraceAutoLoader(\Exception $exception) {


        $traceAsString = $exception->getTrace();

        $style = implode('; ', array(
            'color: #444',
            'background: #f9f9f9',
            'padding: 10px',
            'margin: 10px',
            'border: 1px solid #ccc'
                ));

        $error = '<div style="' . $style . '">';
        $error .= '<b style="color: #6B0202">%s</b><br />%s</div>';

        $message = '';
        $message .= '<b>File:</b> ' . $traceAsString[1]['file'] . '<br />';
        $message .= '<b>Line:</b> ' . $traceAsString[1]['line'] . '<br />';

        $message .= '<b>Not found:</b> ' . implode(', ', $traceAsString[1]['args']) . '<br />';

        exit(sprintf($error, $exception->getMessage(), $message));
    }

}

