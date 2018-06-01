<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/6/1下午11:21
 * @package Lfuture\LigLog\Adapter
 */

namespace Lfuture\LigLog\Adapter;

use Lfuture\LigLog\AbstractAdapter;
use Lfuture\LigLog\Formatter\SyslogFormatter;

/**
 * Class Syslog
 * @package Lfuture\LigLog\Adapter
 */
class Syslog extends AbstractAdapter
{

    protected function logWrite($level, $time, $message, $context)
    {
        $formatter = $this->getFormatter();

        list($level, $message) = $formatter->format($level, $time, $message, $context);
        syslog($level, $message);
    }

    public function getFormatter()
    {
        if (empty($this->formatter)) {
            $this->formatter = new SyslogFormatter();
        }
        return $this->formatter;
    }
}