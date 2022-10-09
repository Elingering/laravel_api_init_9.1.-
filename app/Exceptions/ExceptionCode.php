<?php

namespace App\Exceptions;

/**
 * 自定义业务异常类
 * Class ExceptionCode
 * @package App\Exceptions
 */
class ExceptionCode
{
    const THIRD_PARTY_EXCEPTION = 4003;// 第三方服务异常
    const RPC_EXCEPTION = 4004;// rpc 服务异常

    const INTERNAL_EXCEPTION = 5000;// 系统异常
}
