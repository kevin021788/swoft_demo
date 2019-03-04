<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-25
 * Time: 10:32
 */

namespace App\Controllers;

use App\Lib\ProdInterface;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use App\Lib\TestInterface;
/**
 * Class TestController
 * @Controller("/test")
 */
class TestController
{
    /**
     * @Reference(name="test")
     *
     * @var TestInterface
     */
    private $testService;

    /**
     *
     * @Reference(name="prod")
     * @var ProdInterface
     */
    private $prodService;

    /**
     * @RequestMapping(route="test")
     */
    public function test()
    {
        session()->put('aa', '测试一下');
        $session = session()->get('aa');
        $result  = $this->testService->getStr('-这儿是客户端！！！！！！！！！！！我是客户端');
        return [
            'result'  => $result,
            'session'  => $session,
        ];
    }

    /**
     * @RequestMapping(route="find")
     * @return array
     */
    public function find()
    {
        $b = array();
        $result = $this->testService->findProd(1, $b);
        return [
            'result' => $result,
            'session' => session()->all(),
        ];
    }

    /**
     * @RequestMapping(route="view")
     * @return array
     */
    public function modify()
    {
        $b = array();
        $result = $this->prodService->findProd(1, $b);
        return [
            'result' => $result,
            'session' => session()->all(),
        ];
    }
    /**
     * @RequestMapping(route="del")
     * @return array
     */
    public function del()
    {
        $result = $this->testService->delProd(2);
        return [
            'result' => $result,
            'session' => session()->all(),
        ];
    }

}
