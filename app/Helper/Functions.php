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


