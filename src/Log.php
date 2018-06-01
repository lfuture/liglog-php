<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/30下午6:33
 */
namespace Lfuture\LigLog;

use Lfuture\LigLog\Exception\LigLogException;

/**
 * Class Log
 */
class Log
{
    protected static $adapters = [
        'file' => 'Lfuture\\LigLog\\Adapter\\File',
        'blackhole' => 'Lfuture\\LigLog\\Adapter\\Blackhole',
        'errorlog' => 'Lfuture\\LigLog\\Adapter\\ErrorLog',
        'stream' => 'Lfuture\\LigLog\\Adapter\\Stream',
        'syslog' => 'Lfuture\\LigLog\\Adapter\\Syslog',
    ];
    protected static $loggers = [];

    /**
     * @param string $name
     * @param string $adapter
     * @param array $config
     * @return AbstractAdapter
     * @throws LigLogException
     */
    public static function getLogger($name = 'default', $adapter = 'file', $config = [])
    {
        if (isset(self::$loggers[$name])) {
            return self::$loggers[$name];
        }

        if (!isset(self::$adapters[$adapter])) {
            throw new LigLogException("adapter type $adapter not exist");
        }

        if (!class_exists(self::$adapters[$adapter])) {
            throw new LigLogException("adapter class " . self::$adapters[$adapter] . " not exist");
        }
        $reflect = new \ReflectionClass(self::$adapters[$adapter]);
        $logger = $reflect->newInstance($name, $config);
        self::$loggers[$name] = $logger;
        return $logger;
    }

    public static function addAdapter($name, $className)
    {
        if (!class_exists($className)) {
            throw new LigLogException("add adapter $name but $className not exist");
        }
        self::$adapters[$name] = $className;
    }

}