<?php namespace Romach3\ExtLaravel\Helpers;

class HTML
{

    public static function active($needle, $value)
    {
        return self::aActive($needle, $value, 'active');
    }

    public static function cActive($needle, $value)
    {
        return self::aActive($needle, $value, 'class="active"');
    }

    public static function aActive($needle, $value, $return)
    {
        if ($needle === $value) {
            return $return;
        }
        return '';
    }
}
