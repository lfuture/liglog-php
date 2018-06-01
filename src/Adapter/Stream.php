<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/6/1下午11:44
 * @package Lfuture\LigLog\Adapter
 */

namespace Lfuture\LigLog\Adapter;

use Lfuture\LigLog\AbstractAdapter;
use Lfuture\LigLog\Exception\LigLogException;
use Lfuture\LigLog\Formatter\LineFormatter;

/**
 * Class Stream
 * @package Lfuture\LigLog\Adapter
 */
class Stream extends AbstractAdapter
{
    protected $path;

    public function __construct($path, $config)
    {
        $this->path = $path;
        parent::__construct($path, $config);
    }

    protected function logWrite($level, $time, $message, $context)
    {
        $fp = fopen($this->path, 'a');
        if (gettype($fp) !== 'resource') {
            throw new LigLogException("open file $this->path fail");
        }
        $formatter = $this->getFormatter();
        fwrite($fp, $formatter->format($level, $time, $message, $context));
        fclose($fp);
    }

    public function getFormatter()
    {
        if (empty($this->formatter)) {
            $this->formatter = new LineFormatter();
        }
        return $this->formatter;
    }
}