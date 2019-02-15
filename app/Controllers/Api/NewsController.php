<?php
namespace App\Controllers\Api;

use App\Models\Entity\News;
use Swoft\Db\Query;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;

/**
 * @Controller("/news")
 */
class NewsController
{
    /**
     * @RequestMapping(route="list", method={RequestMethod::GET})
     */
    public function getList()
    {
        $b = Query::table(News::class)->orderBy("id","desc")->limit(3)->get()->getResult();
        return $b;
        return ["id"=>1,"title"=>"title11111"];
    }

}
