<?php

namespace App\Helpers;

class Toastr
{
    public static function success($message)
    {
        return "<script>toastr.success('{$message}')</script>";
    }

    public static function error($message)
    {
        return "<script>toastr.error('{$message}')</script>";
    }

    public static function warning($message)
    {
        return "<script>toastr.warning('{$message}')</script>";
    }

    public static function info($message)
    {
        return "<script>toastr.info('{$message}')</script>";
    }
}
