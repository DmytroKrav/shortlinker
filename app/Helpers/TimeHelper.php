<?php

namespace App\Helpers;

class TimeHelper
{
    public static function fromSecondsToHumanTime($timestamp): string
    {
        if (($res = $timestamp/3600) > 1) {
            return (int) $res . ' h';
        }

        if (($res = $timestamp/60) > 1) {
            return (int) $res . ' min';
        }
    }
}