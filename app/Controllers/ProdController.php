<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-28
 * Time: 16:50
 */
namespace App\Controllers;

use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Http\Message\Bean\Annotation\Middlewares;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use Swoft\Bean\Annotation\Number;
use Swoft\Bean\Annotation\ValidatorFrom;
use App\Lib\ProdInterface;
use App\Middlewares\JwtMiddleware;

/**
/**
 * Class TestController
 * @Controller("/prod")
 */
class ProdController
{
    /**
     * @Reference(name="prod")
     * @var ProdInterface
     */
    public $prodService;


    /**
     * @RequestMapping(route="find")
     */
    public function find()
    {
        $rs = $this->prodService->findProd(1,array());
        return ['rs' => $rs];

    }

    /**
     * @Middleware(JwtMiddleware::class)
     * @RequestMapping(route="del")
     * @return array
     */
    public function delete()
    {
        $rs = $this->prodService->delProd(2);
        return ['rs' => $rs];
    }

    /**
     * @RequestMapping(route="create")
     * @return array
     */
    public function add()
    {
        $info = [
            'name' => '测试姓名',
            'desc' => '描述说明',
            'content' => '内容',
        ];
        $rs = $this->prodService->addProd($info);
        return ['rs' => $rs];
    }

    /**
     * @RequestMapping("edit/{id}")
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function modify(Request $request,int $id)
    {
        $info = [
            'name' => '修改过的姓名',
            'desc' => '修改过后的描述',
            'content' => '修改过后的内容',
        ];
        $rs = $this->prodService->deferModifyProd($id, $info);
        return ['rs' => $rs];
    }


}