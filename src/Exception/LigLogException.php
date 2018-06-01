<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/30下午6:58
 */
namespace Lfuture\LigLog\Exception;

use Exception;

/**
 * Class LigLogException
 */
class LigLogException extends \Exception
{
    public function __construct($message, $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}