<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-25
 * Time: 15:11
 */
namespace App\Middlewares;

use App\Utils\JwtToken;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoft\Bean\Annotation\Bean;
use Swoft\Http\Message\Middleware\MiddlewareInterface;


/**
 * @Bean()
 * JWT登录验证中间件
 * Class SomeMiddleware
 * @package App\Middlewares
 */
class JwtMiddleware implements MiddlewareInterface
{

    /**
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $auth = false;
        $msg = '';
        try{
            $token = $request->getHeaderLine('Authorization');
            if(empty($token)) throw new \Exception('缺少token参数！');
            $jwtToken = new JwtToken();
            $verify = $jwtToken->verify($token);
            if(!empty($verify)) $auth = true;
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
        }

        // 如果验证不通过
        if (!$auth) {
            // response() 函数可以快速从 RequestContext 获得 Response 对象
//
            return response()->withContent(json_encode(returnData('',0,$msg)));
//            return response()->withStatus(401);
        }
        // 委托给下一个中间件处理
        $response = $handler->handle($request);
        return $response;
    }
}