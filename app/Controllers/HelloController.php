<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-14
 * Time: 11:22
 */

namespace App\Controllers;

use Swoft\App;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Task\Task;

/**
 * Class IndexController
 * @Controller(prefix="/he")
 */
class HelloController
{
    /**
     * @RequestMapping()
     */
    function index()
    {
        $number = range(1, 50);
        foreach ($number as $key => $value) {
            $re[] = Task::deliver('sync', 'deliverCo', [$value, 2], Task::TYPE_CO);
        }
        return $re;

        //"deliverCo-p-p2"
        return 'hello word!';
    }

    /**
     * @RequestMapping()
     * @return string
     */
    function test()
    {
        return 'this test aaa';
    }

}