<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-02-28
 * Time: 16:24
 */
namespace App\Lib;

use Swoft\Core\ResultInterface;

interface ProdInterface
{
    public function addProd(array $info);

    public function findProd(int $id,array $cond);

    public function delProd(int $id);

    public function modifyProd(int $id,array $info);
}