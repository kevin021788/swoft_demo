<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace App\WebSocket;

use Swoft\Http\Message\Server\Request;
use Swoft\Http\Message\Server\Response;
use Swoft\WebSocket\Server\Bean\Annotation\WebSocket;
use Swoft\WebSocket\Server\HandlerInterface;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;

/**
 * Class ChatController - This is an controller for handle websocket
 * @package App\WebSocket
 * @WebSocket("chat")
 */
class ChatController implements HandlerInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @return array
     * [
     *  self::HANDSHAKE_OK,
     *  $response
     * ]
     */
    public function checkHandshake(Request $request, Response $response): array
    {
        return [self::HANDSHAKE_OK, $response];
    }

    /**
     * @param Server $server
     * @param Request $request
     * @param int $fd
     * @return mixed
     */
    public function onOpen(Server $server, Request $request, int $fd)
    {
    }

    /**
     * @param Server $server
     * @param Frame $frame
     * @return mixed
     */
    public function onMessage(Server $server, Frame $frame)
    {
        $fd = $frame->fd;
        $data = json_decode($frame->data, true);
        if ($data['type'] == 'bind') {
            // 将uid与fd绑定
            $server->bind($fd, $data['sendUid']);
        }
        $start_fd = 0;
        while(true)
        {
            // 获取所有fd连接
            $conn_list = $server->getClientList($start_fd, 10);
            if ($conn_list === false or count($conn_list) === 0)
            {
                break;
            }
            $start_fd = end($conn_list);
            foreach($conn_list as $v)
            {
                // 根据fd获取uid
                $connection = $server->connection_info($v);
                var_dump($connection);
                if (isset($connection['uid']) && in_array($connection['uid'], [$data['receiveUid'], $data['sendUid']])) {
                    if (isset($data['content'])) {
                        $response = [
                            'type' => 'response',
                            'content' => $data['content'],
                            'uid' => $data['receiveUid'],
                        ];
                        if ($v != $fd) { // 避免重复发送给消息发起者的fd
                            $server->push($v, json_encode($response, true));
                        }
                    }
                }
            }
        }
        // 推送消息给客户端
        \Swoft::$server->sendTo($fd, $frame->data);
    }

    /**
     * @param Server $server
     * @param int $fd
     * @return mixed
     */
    public function onClose(Server $server, int $fd)
    {
        // do something. eg. record log
    }
}