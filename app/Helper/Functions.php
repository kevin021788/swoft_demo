<?php
/**
 * This file is part of Swoft.
 *
 * @link https://swoft.org
 * @document https://doc.swoft.org
 * @contact group@swoft.org
 * @license https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

// you can add some custom functions.
if (!function_exists('returnData')) {
    /**
     * @param string $data
     * @param int $code
     * @param string $message
     * @return array
     */
    function returnData($data='', $code=200, $message='')
    {
        return ['code' => $code, 'msg' => $message, 'data' => $data];
    }
}

if (!function_exists('error_exit')) {
    function error_exit(int $code, string $msg='')
    {
        throw new \App\Exception\HttpException($msg, $code);
    }
}