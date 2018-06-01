<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/6/1下午10:52
 * @package Lfuture\LigLog\Formatter
 */

namespace Lfuture\LigLog\Formatter;

use Lfuture\LigLog\AbstractFormatter;
use Lfuture\LigLog\LogLevel;

/**
 * Class Json
 * @package Lfuture\LigLog\Formatter
 */
class JsonFormatter extends AbstractFormatter
{
    public function format($level, $time, $message, $context)
    {
        $levelType = LogLevel::getStringByLevel($level);
        if (is_array($context) && !empty($context)) {
            $message = $this->interpolate($message, $context);
        }

        $logContent = [
            'time' => $time,
            'level' => $levelType,
            'message' => $message,
        ];

        return json_encode($logContent, true);
    }
}