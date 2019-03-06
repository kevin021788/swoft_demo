<?php
namespace App\Controllers\Api;

use App\Models\Entity\News;
use Swoft\Db\Query;
use Swoft\Http\Message\Server\Request;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;

/**
 * @Controller("/api/news")
 */
class NewsController
{
    /**
     * @RequestMapping(route="/api/news", method={RequestMethod::GET})
     * @param Request $request
     * @return mixed
     */
    public function getList(Request $request)
    {
        $page = $request->input('page',1);
        $pageSize = $request->input('pageSize',5);
        $page = empty($page) ? 1 : $page;
        $pageSize = empty($pageSize) ? 5 : $pageSize;
        $offset = ($page - 1) * $pageSize;
        $result = Query::table(News::class)->orderBy("id","desc")->limit($pageSize,$offset)->get()->getResult();
        $a = get_last_sql();
        return [$result,$a];
    }

    /**
     * @RequestMapping(route="{id}",method={RequestMethod::GET})
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function detail(Request $request,int $id)
    {
        $get = $request->getQueryParams();
        $model = News::findOne(['id' =>$id])->getResult();
        $body['rs'] = $model;
        $body['get'] = $get;
        return $body;
    }

    /**
     * @RequestMapping(route="/api/news",method={RequestMethod::POST})
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        $name = $request->input('name');
        $body = $request->getParsedBody();
        if(empty($name)) return 'name not empty';

        $model = new News();
        $model->setTitle($name);
        $id = $model->save()->getResult();
        $body['id'] = $id;
        return $body;
    }

    /**
     * @RequestMapping(route="{id}",method={RequestMethod::PUT, RequestMethod::PATCH})
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function update(Request $request,int $id)
    {
        $name = $request->input('name');

        $model = News::findById($id)->getResult();
        $model->setTitle($name);
        $res = $model->update()->getResult();
        return $res;
    }

    /**
     * @RequestMapping(route="{id}",method={RequestMethod::DELETE})
     * @param Request $request
     * @param int $id
     * @return Request
     */
    public function delete(Request $request, int $id)
    {
        $result = News::deleteByIds([$id])->getResult();
        return $result;
    }

}
