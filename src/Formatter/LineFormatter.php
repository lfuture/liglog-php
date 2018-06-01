<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/31上午12:35
 */
namespace Lfuture\LigLog\Formatter;

use Lfuture\LigLog\AbstractFormatter;
use Lfuture\LigLog\LogLevel;

/**
 * Class Line
 */
class LineFormatter extends AbstractFormatter
{
    protected $template = '[%date%] [%level%] %message%';

    public function format($level, $time, $message, $context)
    {
        $logContent = $this->template;
        $levelType = LogLevel::getStringByLevel($level);
        if (is_array($context) && !empty($context)) {
            $message = $this->interpolate($message, $context);
        }
        if (strpos($logContent, '%date%') !== false) {
            $logContent = str_replace('%date%', date('Y-m-d H:i:s'), $logContent);
        }
        if (strpos($logContent, '[%level%]') !== false) {
            $logContent = str_replace('[%level%]', $levelType, $logContent);
        }
        $logContent = str_replace('%message%', $message, $logContent);
        return $logContent;
    }
}