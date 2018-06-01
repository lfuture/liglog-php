<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/6/1下午11:08
 * @package Lfuture\LigLog\Formatter
 */

namespace Lfuture\LigLog\Formatter;

use Lfuture\LigLog\AbstractFormatter;
use Lfuture\LigLog\LogLevel;

/**
 * Class sslog
 * @package Lfuture\LigLog\Formatter
 */
class SyslogFormatter extends AbstractFormatter
{
    public function format($level, $time, $message, $context)
    {
        if (is_array($context) && !empty($context)) {
            $message = $this->interpolate($message, $context);
        }
        return [$level, $message];
    }
}