<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/30下午10:55
 * @package Lfuture\LigLog
 */

namespace Lfuture\LigLog;
use Lfuture\LigLog\Exception\LigLogException;

/**
 * Class LogLevel
 * @package Lfuture\LigLog
 */
class LogLevel
{
    const EMERGENCY = 0;
    const CRITICAL = 1;
    const ALERT = 2;
    const ERROR = 3;
    const WARNING = 4;
    const NOTICE = 5;
    const INFO = 6;
    const DEBUG = 7;

    protected static $levelMap = [
        'EMERGENCY' => 0,
        'CRITICAL' => 1,
        'ALERT' => 2,
        'ERROR' => 3,
        'WARNING' => 4,
        'NOTICE' => 5,
        'INFO' => 6,
        'DEBUG' => 7,
    ];

    public static function getLevelByString($type)
    {
        $levelType = strtoupper($type);
        if (isset(self::$levelMap[$levelType])) {
            return self::$levelMap[$levelType];
        }
        throw new LigLogException("error message type '$type'");
    }

    public static function getStringByLevel($level)
    {
        $levelMap = array_flip(self::$levelMap);
        if (isset($levelMap[$level])) {
            return $levelMap[$level];
        }
        throw new LigLogException("error message level '$level'");
    }
}