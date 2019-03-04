<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-03-04
 * Time: 11:22
 */

namespace App\Controllers;

use Swoft\App;
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\Controller;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
use Swoft\Http\Message\Server\Request;

/**
 * @Controller()
 * Class UploadController
 * @package App\Controllers
 */
class UploadController
{
    /**
     * @RequestMapping(route="img")
     * @param Request $request
     * @return array
     */
    function img(Request $request)
    {
        $files = $request->getUploadedFiles();
        $file = $files['img'];

        $dir = alias('@runtime/uploadfiles') . '/' . date('Ymd');
        if (!is_dir($dir)) {
            @mkdir($dir, 0777, true);
        }

        $path = $dir . '/' . 'name' . '.jpg';
        $file->moveTo($path);
        var_dump($file);
        return [$path];
    }
}