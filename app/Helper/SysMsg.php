<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-03-06
 * Time: 15:58
 */

namespace App\Helper;

/**
 * 系统错误信息
 * Class SysMsg
 * @package App\Utils
 */
class SysMsg
{

    const SYSMSG = [
        SysCode::SUCCESS => '操作成功！',
        SysCode::ERROR => '操作失败！',
        SysCode::PARAM_VALID_ERROR => '参数校验失败！',
        SysCode::REQUEST_LIMIT_ERROR => '请求频率太频繁！',
        SysCode::USER_NEED_LOGIN_AGAIN => '请重新登录！',
        SysCode::USER_NOT_EXIST => '用户不存在！',
        SysCode::USER_PASSWORD_ERROR => '用户密码错误！',
        SysCode::USER_REGISTER_FAILURE => '注册失败！',
        SysCode::USER_HAS_EXIST => '用户已存在！',

    ];
}