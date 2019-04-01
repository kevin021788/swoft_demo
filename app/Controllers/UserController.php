<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-03-01
 * Time: 15:07
 */
namespace App\Controllers;

use App\Lib\UserInterface;
use App\Helper\JwtToken;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use App\Middlewares\JwtMiddleware;

/**
 * @Controller()
 * Class UserController
 * @package App\Controllers
 */
class UserController
{
    /**
     * @Reference(name="user")
     * @var UserInterface
     */
    private $userService;
    /**
     * @RequestMapping(route="reg",method={RequestMethod::POST})
     * @param Request $request
     * @return array
     */
    public function register(Request $request)
    {
        $account = $request->post('account');
        $password = $request->post('password');
        $name = $request->post('name');
        $data = [
            'account' => $account,
            'password' => $password,
            'username' => $name,
        ];
        $rs = $this->userService->register($data);
        if(!empty($rs)) return returnData('', 200, '注册失败');
        return returnData($data,200,'注册成功');
    }


    /**
     * @RequestMapping(route="login",method={RequestMethod::POST})
     * @param Request $request
     * @return array
     */
    public function login(Request $request)
    {
        $account = $request->post('account');
        $password = $request->post('password');
        if(empty($account) || empty($password)) return ['fail', $account, $password];

        $rs = $this->userService->login($account, $password);
        if(empty($rs)) return ['false',$rs];

        $res = array(
            'account' => $rs['account'],
            'username' => $rs['username'],
        );

        try {
            $jwtToken = new JwtToken();
            $token = $jwtToken->encode($res);
        } catch (\Exception $exception) {
            return returnData([], 200, $exception->getMessage());
        }

        $data = [
            'token' => $token,
        ];
        return returnData($data, 200, '成功');

    }

    /**
     * @RequestMapping(route="get/{id}",method={RequestMethod::GET})
     * @Middleware(JwtMiddleware::class)
     * @param Request $request
     * @param int $id
     * @return array
     */
    public function find(Request $request,int $id)
    {
        $cond = [];
        $rs = $this->userService->info($id, $cond);
        return [
            'rs111' => $rs
        ];
    }
}