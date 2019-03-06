<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Controllers;

use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Message\Bean\Annotation\Middleware;
use Swoft\Http\Message\Bean\Annotation\Middlewares;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use App\Middlewares\GroupTestMiddleware;
use App\Middlewares\ActionTestMiddleware;
use App\Middlewares\SubMiddleware;
use App\Middlewares\ControllerSubMiddleware;
use App\Middlewares\ControllerTestMiddleware;
use App\Middlewares\JwtMiddleware;
use App\Middlewares\CorsMiddleware;


/**
 * @Controller("middleware")
 * @Middleware(class=ControllerTestMiddleware::class)
 * @Middlewares({
 *     @Middleware(ControllerSubMiddleware::class)
 * })
 */
class MiddlewareController
{
    /**
     * @RequestMapping()
     * @Middlewares({
     *     @Middleware(GroupTestMiddleware::class),
     *     @Middleware(ActionTestMiddleware::class)
     * })
     * @Middleware(SubMiddleware::class)
     */
    public function action1(): array
    {
        return ['middleware'];
    }

    /**
     * @RequestMapping()
     * @Middleware(SubMiddleware::class)
     * @Middlewares({
     *     @Middleware(GroupTestMiddleware::class),
     *     @Middleware(ActionTestMiddleware::class)
     * })
     */
    public function action2(): array
    {
        return ['middleware2'];
    }

    /**
     * @RequestMapping()
     */
    public function action3(): array
    {
        return ['middleware3'];
    }

    /**
     * @RequestMapping()
     * @Middleware(SomeMiddleware::class)
     * @return array
     */
    public function test(): array
    {
        return ['test'];
    }

    /**
     * @RequestMapping()
     * @Middleware(CorsMiddleware::class)
     * @return array
     */
    public function cors(): array
    {
        return ['cors'];
    }


}