<?php
/**
 *
 * @author ln6265431@163.com
 * @date: 2018/5/30下午6:25
 */
namespace Lfuture\LigLog\Tests;
use Lfuture\LigLog\Log;
use PHPUnit\Framework\TestCase;

/**
 * Class SimpleTest
 */
class SimpleTest extends TestCase
{
    protected function generateTempLogName() {
        return 'ligLog_test' . microtime(true);
    }
    public function testDemo()
    {
        $tempLog = $this->generateTempLogName();
        Log::getLogger($tempLog)->error('nihao{test}', [
            'test' => 'lfuture~~~~~'
        ]);
        $logBasePath = Log::getLogger($tempLog)->getLogBasePath();
        $pattern = $logBasePath . '/' . $tempLog . '*.log';
        $files = glob($pattern);

        $this->assertGreaterThan(0, count($files));
        foreach ($files as $file) {
            unlink($file);
        }
    }

    public function testDaily()
    {
        $tempLog = $this->generateTempLogName();
        Log::getLogger($tempLog)->setLogMode('daily')->error('~~~~~~~~{name}~~~~~~', [
            'name' => 'lfuture'
        ]);
    }

    public function testSysLog()
    {
        Log::getLogger('', 'syslog')->error('lfuture liglgo test~~~');
    }

    public function testErrorLog()
    {
        Log::getLogger('', 'errorlog')->error('lfuture liglgo test~~~');
    }

    public function testTransaction()
    {
        $tempLog = $this->generateTempLogName();
        Log::getLogger($tempLog)->begin();
        Log::getLogger($tempLog)->error('lfuture');
        Log::getLogger($tempLog)->error('lfuture1');
        Log::getLogger($tempLog)->error('lfuture2');
        Log::getLogger($tempLog)->error('lfuture3');
        Log::getLogger($tempLog)->commit();
    }
}