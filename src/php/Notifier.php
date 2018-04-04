<?php

namespace PHP;

/**
 * Created by PhpStorm.
 * User: vittorio
 * Date: 25/03/18
 * Time: 12:30
 */
class Notifier
{
    public static function addErrorMessage($message)
    {
        $_SESSION['error'] = $message;
    }

    public static function addSuccessMessage($message)
    {
        $_SESSION['success'] = $message;
    }

    public static function isErrorMessage()
    {
        return isset($_SESSION['error']);
    }

    public static function isSuccessMessage()
    {
        return isset($_SESSION['success']);
    }

    public static function getErrorMessage()
    {
        return self::getAndDelete('error');
    }

    /**
     * @param $type string
     * @return string
     */
    private static function getAndDelete($type)
    {
        if (isset($_SESSION[$type])) {
            $message = $_SESSION[$type];
            unset($_SESSION[$type]);
            return $message;
        } else {
            return null;
        }
    }

    public static function getSuccessMessage()
    {
        return self::getAndDelete('success');
    }
}