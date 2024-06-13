<?php

namespace App\Helpers;

class Toastr
{
    public static function success($message)
    {
        flash($message, 'success');
    }

    public static function error($message)
    {
        flash($message, 'error');
    }

    public static function warning($message)
    {
        flash($message, 'warning');
    }
}
