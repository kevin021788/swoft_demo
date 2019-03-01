<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-22
 * Time: 16:50
 */
namespace App\Lib;

use Swoft\Core\ResultInterface;

interface UserInterface
{
    public function register(array $info);

    public function login(string $account, string $password);

    public function info(int $id, array $cond);

}