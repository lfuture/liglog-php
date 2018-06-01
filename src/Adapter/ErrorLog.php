<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/6/2上午1:26
 * @package Lfuture\LigLog\Adapter
 */

namespace Lfuture\LigLog\Adapter;

use Lfuture\LigLog\AbstractAdapter;
use Lfuture\LigLog\Formatter\LineFormatter;

/**
 * Class ErrorLog
 * @package Lfuture\LigLog\Adapter
 */
class ErrorLog extends AbstractAdapter
{

    protected $type = 0;

    protected $destination = '';

    protected function logWrite($level, $time, $message, $context)
    {
        $formatter = $this->getFormatter();

        $message = $formatter->format($level, $time, $message, $context);
        error_log($message);
    }


    public function setType($type)
    {
        $this->type = $type;
    }

    public function setDestination($destination)
    {
        $this->destination = $destination;
    }

    public function getFormatter()
    {
        if (empty($this->formatter)) {
            $this->formatter = new LineFormatter();
        }
        return $this->formatter;
    }
}