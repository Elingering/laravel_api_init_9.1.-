<?php

namespace App\Models\Enum;

enum Auser: int
{
    // 状态类别
    case INVALID = -1; //已删除
    case NORMAL = 0; //正常
    case FREEZE = 1; //冻结

    public function getStatus()
    {
        return match ($this) {
            self::INVALID => '已删除',
            self::NORMAL => '正常',
            self::FREEZE => '冻结',
        };
    }
}
