<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/30下午7:08
 * @package Lfuture\LigLog
 */

namespace Lfuture\LigLog;

/**
 * Class Message
 * @package Lfuture\LigLog
 */
class Message
{
    public $message;
    public $level;
    public $context;
    public $time;

    public function __construct($level, $time, $message, $context)
    {
        $this->message = $message;
        $this->level = $level;
        $this->context = $context;
        $this->time = $time;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getTime()
    {
        return $this->time;
    }
}