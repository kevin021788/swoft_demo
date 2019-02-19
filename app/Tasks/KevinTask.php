<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-19
 * Time: 14:13
 */

namespace App\Tasks;

use App\Lib\DemoInterface;
use App\Models\Entity\Prod;
use App\Models\Entity\User;
use Swoft\App;
use Swoft\Bean\Annotation\Inject;
use Swoft\HttpClient\Client;
use Swoft\Redis\Redis;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use Swoft\Task\Bean\Annotation\Scheduled;
use Swoft\Task\Bean\Annotation\Task;
/**
 * Kevin task
 *
 * @Task("kevin")
 */
class KevinTask
{
    /**
     * Deliver co task
     *
     * @param string $p1
     * @param string $p2
     *
     * @return string
     */
    public function deliverCo(string $p1, string $p2)
    {
        App::profileStart('co');
        App::trace('trace');
        App::info('info');
        App::pushlog('key', 'stelin');
        App::profileEnd('co');

        return sprintf('deliverCo-%s-%s', $p1, $p2);
    }

    /**
     * Deliver async task
     *
     * @param string $p1
     * @param string $p2
     *
     * @return string
     */
    public function deliverAsync(string $p1, string $p2)
    {
        App::profileStart('co');
        App::trace('trace');
        App::info('info');
        App::pushlog('key', 'stelin');
        App::profileEnd('co');

        return sprintf('deliverCo-%s-%s', $p1, $p2);
    }

    public function http()
    {
        $client = new Client();
        $url = "http://www.baidu.com";
        $header = $client->get($url)->getResponse()->getHeaders();
        $body = $client->get($url)->getResponse()->getBody()->getContents();

        return [$header,$body];
    }
    /**
     * crontab定时任务
     * 每2秒执行一次
     *
     * @Scheduled(cron="*\/2 * * * * *")
     */
    public function cronTask()
    {
        echo time() ."----每2秒执行一次  \n";
        return 'cron';
    }
}