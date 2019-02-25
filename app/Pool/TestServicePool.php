<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\Pool;

use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Pool;
use App\Pool\Config\TestPoolConfig;
use Swoft\Rpc\Client\Pool\ServicePool;

/**
 * the pool of test service
 *
 * @Pool(name="test")
 */
class TestServicePool extends ServicePool
{
    /**
     * @Inject()
     *
     * @var TestPoolConfig
     */
    protected $poolConfig;
}