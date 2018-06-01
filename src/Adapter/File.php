<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/31上午12:14
 */
namespace Lfuture\LigLog\Adapter;

use Lfuture\LigLog\AbstractAdapter;
use Lfuture\LigLog\Exception\LigLogException;
use Lfuture\LigLog\Formatter\LineFormatter;

/**
 * Class File
 */
class File extends AbstractAdapter
{

    protected $module;

    protected $logBasePath = '/var/log/www';

    protected $defaultModuleName = 'default';

    protected $mode = 'single';

    protected $maxLogNum = 30;

    protected $enableModes = [
        'single',
        'daily',
    ];

    protected $dailyFilenameFormat = '{module}-{date}.log';

    public function __construct($module, $config)
    {
        $this->module = $module;
        parent::__construct($module, $config);
    }

    protected function logWrite($level, $time, $message, $context)
    {
        $logFile = $this->getLogPath();
        $fp = fopen($logFile, 'a');
        if (gettype($fp) !== 'resource') {
            throw new LigLogException("open log file $logFile fail");
        }
        $formatter = $this->getFormatter();
        fwrite($fp, $formatter->format($level, $time, $message, $context) . PHP_EOL);
        fclose($fp);
    }

    protected function getLogPath()
    {
        $loggerFileName = 'default.log';
        if ($this->mode === 'single') {
            $loggerFileName = $this->module . '.log';
        } elseif ($this->mode === 'daily') {
            $loggerFileName = str_replace(array('{module}', '{date}')
                ,array($this->module, date('Y-m-d')), $this->dailyFilenameFormat);
        }

        $logFile = $this->logBasePath . '/' . $loggerFileName;
        if (!file_exists($logFile)) {
            $this->rotate();
        }
        return $logFile;
    }

    protected function rotate()
    {
        $pathPattern = str_replace(
            array('{module}', '{date}'),
            array($this->module, '*'),
            $this->logBasePath . '/' . $this->dailyFilenameFormat
        );
        $logFiles = glob($pathPattern);
        if ($this->maxLogNum >= count($logFiles)) {
            return;
        }
        usort($logFiles, function ($a, $b) {
            return strcmp($b, $a);
        });
        foreach (array_slice($logFiles, $this->maxLogNum) as $file) {
            if (is_writable($file)) {
                set_error_handler(function ($errno, $errstr, $errfile, $errline) {});
                unlink($file);
                restore_error_handler();
            }
        }
    }

    public function getFormatter()
    {
        if (empty($this->formatter)) {
            $this->formatter = new LineFormatter();
        }
        return $this->formatter;
    }

    public function setLogBasePath($path)
    {
        if (!file_exists($path) || !is_dir($path)) {
            throw new LigLogException("set log base path $path not exist");
        }
        $this->logBasePath = rtrim($path, '/');
        return $this;
    }

    public function setLogMode($mode)
    {
        if (!in_array($mode, $this->enableModes, true)) {
            throw new LigLogException("file log mode of $mode not exist");
        }
        $this->mode = $mode;
        return $this;
    }

    public function getLogBasePath()
    {
        return $this->logBasePath;
    }
}