<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\WebSocket;

use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use Swoft\App;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\WebSocket\Server\Bean\Annotation\WebSocket;
use Swoft\WebSocket\Server\HandlerInterface;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * 用WebSocket判断登录状态
 * 连接地址用
 * ws://192.168.5.181:81/auth?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLm9yZyIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUuY29tIiwiaWF0IjoxNTUxNzc0Mzg1LCJleHAiOjE1NTE3NzQ0NDUsIm5iZiI6MTU1MTc3NDM4NSwiYWNjb3VudCI6IjEzNzk4MTgwNDAyIiwidXNlcm5hbWUiOiJrZXZpbiJ9.A-l0OTisrYdwsZEF4UPbBRlHnNLcMsO11FARwOin8cQ
 *
 * Class AuthController - This is an controller for handle websocket
 * @package App\WebSocket
 * @WebSocket("auth")
 */
class AuthController implements HandlerInterface
{
    /**
     * 在这里你可以验证握手的请求信息
     * - 必须返回含有两个元素的array
     *  - 第一个元素的值来决定是否进行握手
     *  - 第二个元素是response对象
     * - 可以在response设置一些自定义header,body等信息
     * @param Request $request
     * @param Response $response
     * @return array
     * [
     *  self::HANDSHAKE_OK,
     *  $response
     * ]
     */
    public function checkHandshake(Request $request, Response $response): array
    {
        // some validate logic ...
        var_dump($request);
        return [self::HANDSHAKE_OK, $response];
    }

    /**
     * @param Server $server
     * @param Request $request
     * @param int $fd
     * @return mixed
     */
    public function onOpen(Server $server, Request $request, int $fd)
    {
        // $server->push($fd, 'hello, welcome! :)');


        try{

            $token = $request->getQueryParams()['token'];

            $auth = App::getBean('config')->get('auth.jwt');
            $key = $auth['secret'];
            $msg = '';

            $jwt = $token;

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
            $msg = '登录成功';
        }


        $server->push($fd, ($auth === true) ? 1 : 0);
    }

    /**
     * @param Server $server
     * @param Frame $frame
     * @return mixed
     */
    public function onMessage(Server $server, Frame $frame)
    {
//         $server->push($frame->fd, 'hello, I have received your message: ' . $frame->data);
    }

    /**
     * @param Server $server
     * @param int $fd
     * @return mixed
     */
    public function onClose(Server $server, int $fd)
    {
        // do something. eg. record log
    }
}
