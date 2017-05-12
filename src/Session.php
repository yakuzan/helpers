<?php

namespace Yakuzan\Helpers;

class Session
{
    public static function start()
    {
        if (self::sessionStarted()) {
            session_start();
        }
    }

    public static function sessionStarted()
    {
        return PHP_SESSION_NONE === session_status() || '' === session_id();
    }

    public static function exists($name)
    {
        if (is_array($name)) {
            $output = [];
            foreach ($name as $item) {
                $output[(string) $item] = isset($_SESSION[(string) $item]);
            }

            return $output;
        }

        return isset($_SESSION[(string) $name]);
    }

    public static function get($name)
    {
        if (is_array($name)) {
            $output = [];
            foreach ($name as $item) {
                $output[(string) $item] = self::exists($item) ? $_SESSION[(string) $item] : null;
            }

            return $output;
        }

        return self::exists($name) ? $_SESSION[(string) $name] : null;
    }

    public static function put($name, $value = null)
    {
        if (is_array($name)) {
            foreach ($name as $key => $v) {
                $_SESSION[(string) $key] = $v;
            }

            return $name;
        }

        return $_SESSION[(string) $name] = $value;
    }

    public static function delete($name)
    {
        $output = self::get($name);

        if (null !== $output && is_array($output)) {
            foreach ($output as $item) {
                if (self::exists($item)) {
                    unset($_SESSION[(string) $item]);
                }
            }
        }

        if (null !== $output && !is_array($output)) {
            unset($_SESSION[(string) $name]);
        }

        return $output;
    }

    public static function destroy()
    {
        if (self::sessionStarted()) {
            session_destroy();
            $_SESSION = [];
        }
    }
}
