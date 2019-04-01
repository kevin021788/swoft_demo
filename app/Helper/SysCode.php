<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-03-06
 * Time: 15:58
 */

namespace App\Helper;

/**
 * 系统错误码
 * Class SysCode
 * @package App\Utils
 */
class SysCode
{

    //=============================================通用状态码
    const SUCCESS = 0; //0成功返回
    const ERROR = 1; //1失败返回

    const PARAM_VALID_ERROR = 0000001; //参数验证失败
    const REQUEST_LIMIT_ERROR = 0000002; //请求限制失败

    //=============================================用户模块：10===========
    const USER_NEED_LOGIN_AGAIN = 1000000; //登录异常
    const USER_NOT_EXIST = 1000001; //用户不存在
    const USER_PASSWORD_ERROR = 1000002; //用户密码错误
    const USER_REGISTER_FAILURE = 1000003; //用户注册失败
    const USER_HAS_EXIST = 1000004; //用户已存在


}