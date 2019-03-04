<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-03-01
 * Time: 15:07
 */
namespace App\Controllers;

use App\Lib\UserInterface;
use Firebase\JWT\JWT;
use Swoft\App;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Rpc\Client\Bean\Annotation\Reference;
use Swoft\Log\Log;
use Swoft\View\Bean\Annotation\View;
use Swoft\Contract\Arrayable;
use Swoft\Http\Server\Exception\BadRequestException;
use Swoft\Http\Message\Server\Response;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use App\Middlewares\SomeMiddleware;

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
        if(!empty($rs)) return ['success',$data, $rs];
        return ['fail',$data];
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

        $jwt = App::getBean('config')->get('auth.jwt');
        $key = $jwt['secret'];
        $algorithm = $jwt['algorithm'];

        /*
    iss: token的发行者
    sub: token的题目
    aud: token的客户
    exp: 经常使用的，以数字时间定义失效期，也就是当前时间以后的某个时间本token失效。
    nbf: 定义在此时间之前，JWT不会接受处理。
    iat: JWT发布时间，能用于决定JWT年龄
    jti: JWT唯一标识. 能用于防止 JWT重复使用，一次只用一个token
*/
        $payload = array(
            "iss" => "http://example.org",
            "aud" => "http://example.com",
            "iat" => time(),
            'exp' => time() + 60,
            "nbf" => time(),
            'account' => $rs['account'],
            'username' => $rs['username'],
        );


        $token = JWT::encode($payload, $key);
        $decoded = JWT::decode($token, $key, array($algorithm));


        $data = [
            'token' => $token,
        ];

        return ['success', $data];

    }

    /**
     * @RequestMapping(route="get/{id}",method={RequestMethod::GET})
     * @Middleware(SomeMiddleware::class)
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