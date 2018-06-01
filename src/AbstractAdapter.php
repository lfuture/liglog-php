<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/30下午6:10
 */
namespace Lfuture\LigLog;

use Lfuture\LigLog\Exception\LigLogException;

/**
 * Class AbstractAdapter
 */
abstract class AbstractAdapter
{
    protected $transaction = false;

    /**
     *
     * @var Message[]
     */
    protected $queue = [];

    /**
     *
     * @var AbstractFormatter
     */
    protected $formatter;

    protected $logLevel = LogLevel::DEBUG;


    public function __construct($name, $config)
    {

    }

    public function begin(){
        $this->transaction = true;
        return $this;
    }

    public function rollback()
    {
        if (!$this->transaction) {
            throw new LigLogException("There is no transaction need rollback!");
        }
        $this->transaction = false;
        $this->queue = [];
        return $this;
    }

    public function commit() {
        if (!$this->transaction) {
            throw new LigLogException("There is no transaction need commit!");
        }
        $this->transaction = false;
        foreach ($this->queue as $message) {
            $this->logWrite($message->getLevel(), $message->getTime(), $message->message, $message->getContext());
        }
        return $this;
    }

    abstract protected function logWrite($level, $time, $message, $context);

    public function log($type, $message, $context = [])
    {
        if (gettype($type) === 'string') {
            $level = LogLevel::getLevelByString($type);
        } else if(gettype($type) === 'integer') {
            $level = $type;
        } else {
            throw new LigLogException("error log level $type");
        }
        if (gettype($message) !== 'string') {
            throw new LigLogException("message field type must be string");
        }
        if (gettype($context) !== 'array') {
            throw new LigLogException("context field type must be array");
        }
        if ($this->logLevel < $level) {
            return $this;
        }
        $time = date_format(new \DateTime(),'Y-m-d H:i:s.u');
        if ($this->transaction) {
            $message = new Message($level, $time, $message, $context);
            array_push($this->queue, $message);
        } else {
            $this->logWrite($level, $time, $message, $context);
        }
        return $this;
    }

    public function emergency($message, $context) {
        $this->log(LogLevel::EMERGENCY, $message, $context);
        return $this;
    }

    public function critical($message, $context) {
        $this->log(LogLevel::CRITICAL, $message, $context);
        return $this;
    }

    public function alert($message, $context = []) {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    public function error($message, $context = []) {
        $this->log(LogLevel::ERROR, $message, $context);
        return $this;
    }

    public function warning($message, $context = []) {
        $this->log(LogLevel::WARNING, $message, $context);
        return $this;
    }

    public function notice($message, $context = []) {
        $this->log(LogLevel::NOTICE, $message, $context);
        return $this;
    }

    public function info($message, $context = []) {
        $this->log(LogLevel::INFO, $message, $context);
        return $this;
    }

    public function debug($message, $context = []) {
        $this->log(LogLevel::DEBUG, $message, $context);
        return $this;
    }

    public function setFormatter($formatter)
    {
        $this->formatter = $formatter;
    }

    public function close()
    {
    }
}