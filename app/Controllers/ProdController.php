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
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use App\Lib\ProdInterface;

/**
/**
 * Class TestController
 * @Controller("/prod")
 */
class ProdController
{
    /**
     * @Reference(name="prod",version="1.0.1")
     * @var ProdInterface
     */
    public $prodService;


    /**
     * @RequestMapping(route="find")
     */
    public function index()
    {
        $rs = $this->prodService->findProd(1,array());
        return ['rs' => $rs];

    }

}