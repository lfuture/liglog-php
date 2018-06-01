<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/6/1下午11:13
 * @package Lfuture\LigLog\Adapter
 */

namespace Lfuture\LigLog\Adapter;

use Lfuture\LigLog\AbstractAdapter;
use Lfuture\LigLog\Formatter\LineFormatter;

/**
 * Class Blackhole
 * @package Lfuture\LigLog\Adapter
 */
class Blackhole extends AbstractAdapter
{

    public function getFormatter()
    {
        if (empty($this->formatter)) {
            $this->formatter = new LineFormatter();
        }
        return $this->formatter;
    }

    protected function logWrite($level, $time, $message, $context)
    {
        // TODO: Implement logWrite() method.
    }

}