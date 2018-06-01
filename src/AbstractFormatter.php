<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/31上午12:20
 * @package Lfuture\LigLog
 */

namespace Lfuture\LigLog;

/**
 * Class AbstractFormatter
 * @package Lfuture\LigLog
 */
abstract class AbstractFormatter
{
    protected static $templateField = [
        'date' => '',
        'level' => '',
        'message' => '',
        '' => '',
        '%I' => '',
        '%H' => '',
        '%P' => [
            'name' => 'process_id',
            'value' => '',
        ],
        '%D' => '',
        '%R' => '',
        '%c' => 'client ip',
        '%i' => '',
    ];

    protected function interpolate($message, $context) {
        $replace = array();
        foreach ($context as $key => $val) {
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        return strtr($message, $replace);
    }

    abstract public function format($level, $time, $message, $context);
}