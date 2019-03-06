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
use Swoft\Http\Server\Bean\Annotation\RequestMapping;
use Swoft\Http\Server\Bean\Annotation\RequestMethod;
// use Swoft\View\Bean\Annotation\View;
// use Swoft\Http\Message\Server\Response;

/**
 * Class ChatController
 * @Controller(prefix="/chat")
 * @package App\Controllers
 */
class ChatController{
    /**
     * @RequestMapping(route="/chat/{uid}", method=RequestMethod::GET)
     * @param int $uid
     * @return \Swoft\Http\Message\Server\Response|\think\response\View
     */
    public function index(int $uid)
    {

        $users = [
            1 => '程心',
            2 => '云天明',
        ];
        $receiveUid = $uid == 1 ? 2 : 1;
        $userName = $users[$uid];
        $data = compact('uid', 'userName', 'receiveUid');
        return view('chat/index', $data);
    }
}