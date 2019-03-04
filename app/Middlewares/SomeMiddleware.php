<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-25
 * Time: 15:11
 */
namespace App\Middlewares;

use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Swoft\App;
use Swoft\Bean\Annotation\Bean;
use Swoft\Http\Message\Middleware\MiddlewareInterface;


/**
 * @Bean()
 * 登录验证中间件
 * Class SomeMiddleware
 * @package App\Middlewares
 */
class SomeMiddleware implements MiddlewareInterface
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
        $auth = App::getBean('config')->get('auth.jwt');
        $key = $auth['secret'];

        try{

            $authorization = $request->getHeader('Authorization');

            if(empty($authorization)) throw new \Exception('无效访问');

            $msg = '';

            $jwt = $authorization[0];

            list($header64, $payload64, $sign64) = explode('.', $jwt);

            $alg = JWT::jsonDecode(JWT::urlsafeB64Decode($header64));

            $res = JWT::decode($jwt, $key, [$alg->alg]);


        }catch (ExpiredException $exception)
        {
            $auth = false;
            $msg = $exception->getMessage();
        }catch (SignatureInvalidException $exception)
        {
            $auth = false;
            $msg = $exception->getMessage();
        }catch (\UnexpectedValueException $exception)
        {
            $auth = false;
            $msg = $exception->getMessage();
        }catch (\InvalidArgumentException $exception)
        {
            $auth = false;
            $msg = $exception->getMessage();
        }catch (\Exception $exception)
        {
            $auth = false;
            $msg = $exception->getMessage();
        }


        if (isset($res) && $res->iat) {
            $auth = true;
        }

        // 如果验证不通过
        if (!$auth) {
            // response() 函数可以快速从 RequestContext 获得 Response 对象
            $data = [
                'code' => 0,
                'msg' => $msg,
            ];
            return response()->withContent(json_encode($data));
//            return response()->withStatus(401);
        }
        // 委托给下一个中间件处理
        $response = $handler->handle($request);
        return $response;
    }
}