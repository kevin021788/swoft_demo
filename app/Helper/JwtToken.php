<?php
/**
 * Created by kevin0217@126.com
 * User: 曾剑杰
 * Date: 2019-03-06
 * Time: 11:43
 */

namespace App\Helper;


use Firebase\JWT\JWT;
use Swoft\App;
use Swoft\Bean\Annotation\Bean;

/**
 * @Bean()
 * JWT Token验证类
 * Class JWToken
 * @package App\Utils
 */
class JwtToken
{
    /**
     * Token 有效期为 7天
     */
    const EXPIRE_TIME = 7 * 24 * 3600;

    public $jwt_key;
    public $algorithm;

    /**
     * 加密的内容
     * @var array
     */
    public $payLoad = [];

    public function __construct()
    {
        $auth = App::getBean('config')->get('auth.jwt');
        $this->algorithm = (isset($auth['algorithm']) && !empty($auth['algorithm'])) ? $auth['algorithm'] : 'HS256';
        $this->jwt_key = (isset($auth['secret']) && !empty($auth['secret'])) ? $auth['secret'] : '43UF72vSkj-sA4aHHiYN5eoZ9Nb4w5Vb35PsLF9x_NY';
    }

    /**
     * 加密生成Token
     * @param array $param
     * @param int $time
     * @return string
     * @throws \Exception
     */
    public function encode(array $param, $time=self::EXPIRE_TIME):string
    {
        if (!is_array($param)) throw new \Exception('jwt Payload  must be a array');
        //设置Token的有效期
        $param['exp'] = time() + $time;
        $param['iat'] = time();
        $param['nbf'] = time();

        return JWT::encode($param, $this->jwt_key, $this->algorithm);
    }

    /**
     * 解析Token
     * @param string $token
     * @return array
     */
    public function decode(string $token):array
    {
        $decode = JWT::decode($token, $this->jwt_key, [$this->algorithm]);
        $this->payLoad = (array)$decode;
        return $this->payLoad;
    }

    /**
     * 验证Token
     * @param string $token
     * @return bool
     */
    public function verify(string $token):bool
    {
        $param = $this->decode($token);
        if(!isset($param['exp'])) return false;

        if((int)$param['exp']<time()) return false;

        return true;
    }

    /**
     * 返回原内容
     * @return array
     */
    public function getPayload():array
    {
        return $this->payLoad;
    }
}