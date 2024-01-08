<?php

namespace App\Enums;

enum UserStatus: int
{
    case INACTIVE = 0;
    case ACTIVED = 1;
    case PENDING = 2;
    case BANNED = 3;


    public static function getLabels()
    {
        return [
            0 => __('Inactive'),
            1 => __('Active'),
            2 => __('Pending'),
            3 => __('Banned'),
        ];
    }

    public static function getColors()
    {
        return [
            0 => 'secondary',
            1 => 'primary',
            2 => 'warning',
            3 => 'danger',
        ];
    }

    public function getLabel()
    {
        return match ($this) {
            SELF::INACTIVE => __('Inactive'),
            SELF::ACTIVED => __('Active'),
            SELF::PENDING => __('Pending'),
            SELF::BANNED => __('Banned')
        };
    }

    public function getColor()
    {
        return match ($this) {
            SELF::INACTIVE => 'secondary',
            SELF::ACTIVED => 'primary',
            SELF::PENDING => 'warning',
            SELF::BANNED => 'danger'
        };
    }
}
