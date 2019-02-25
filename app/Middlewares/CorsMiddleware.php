<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-25
 * Time: 15:44
 */
namespace App\Middlewares;
use \Swoft\Http\Message\Middleware\MiddlewareInterface;
use \Psr\Http\Message\ServerRequestInterface;
use \Psr\Http\Server\RequestHandlerInterface;
use \Psr\Http\Message\ResponseInterface;
use Swoft\Bean\Annotation\Bean;

/**
 * @Bean()
 * Class CorsMiddleware
 * @package App\Middlewares
 */
class CorsMiddleware implements MiddlewareInterface
{

    /**
     * 示例：允许跨域
     * Process an incoming server request and return a response, optionally delegating
     * response creation to a handler.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Server\RequestHandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // TODO: Implement process() method.
        if ('OPTIONS' === $request->getMethod()) {
            return $this->configResponse(\response());
        }

        $response = $handler->handle($request);

        return $this->configResponse($response);
    }

    private function configResponse(ResponseInterface $response)
    {
        return $response
            ->withHeader('Access-Control-Allow-Origin', 'http://img.com')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    }
}