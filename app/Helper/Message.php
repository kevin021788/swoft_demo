<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-03-06
 * Time: 15:55
 */

namespace App\Helper;


class Message
{
    /**
     * 成功返回
     * @param array $data
     * @param string $msg
     * @param int $code
     * @return array
     */
    public function success(array $data = [],string $msg='',int $code=0):array
    {
        $returnData = ['code' => $code, 'msg' => $msg ?: SysMsg::SYSMSG[$code], 'data' => $data];
        if(empty($returnData['data'])) unset($returnData['data']);
        return $returnData;
    }

    /**
     * 错误返回
     * @param int $code
     * @param string $msg
     * @return array
     */
    public function error(int $code=SysCode::ERROR ,string $msg=''):array
    {
        return ['code' => $code, 'msg' => $msg ?: SysMsg::SYSMSG[$code]];
    }

    /**
     * 自动返回成功还是错误
     * @param $data
     * @return array
     */
    public function resp($data):array
    {
        if (is_array($data)) {
            return $this->success($data, '', SysCode::SUCCESS);
        } else {
            return $this->error(SysCode::ERROR, '');
        }
    }
}