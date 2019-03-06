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
 * http://192.168.5.181:81/chat/1/3
 *
 * Class ChatController
 * @Controller(prefix="/chat")
 * @package App\Controllers
 */
class ChatController{
    /**
     * @RequestMapping(route="/chat/{uid}/{receiveUid}", method=RequestMethod::GET)
     * @param int $uid
     * @param int $receiveUid
     * @return \Swoft\Http\Message\Server\Response
     */
    public function index(int $uid, int $receiveUid)
    {

        $users = [
            1 => '程心',
            2 => '云天明',
            3 => '小高',
            4 => '美女客服',
        ];
//        $receiveUid = $uid == 1 ? 2 : 1;
        $userName = $users[$uid];
        $data = compact('uid', 'userName', 'receiveUid');
        return view('chat/index', $data);
    }
}