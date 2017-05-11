<?php

use Yakuzan\Helpers\Session;

if (!function_exists('dump')) {
    function dump($data = [])
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}

if (!function_exists('dd')) {
    function dd($data = [])
    {
        dump($data);
        die();
    }
}

if (!function_exists('remove_accents')) {
    function remove_accents($str, $charset = 'utf-8')
    {
        $str = htmlentities($str, ENT_NOQUOTES, $charset);
        $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        $str = preg_replace('#&[^;]+;#', '', $str);

        return $str;
    }
}

if (!function_exists('getXML')) {
    function getXML($url = '')
    {
        return new SimpleXMLElement(file_get_contents($url));
    }
}

if (!function_exists('getHtml')) {
    function getHtml($url, $post = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        if (!empty($post)) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}

if (!function_exists('uri')) {
    function uri()
    {
        if (isset($_SERVER[ 'REQUEST_URI' ])) {
            return $_SERVER[ 'REQUEST_URI' ];
        }
    }
}

if (!function_exists('host')) {
    function host()
    {
        if (isset($_SERVER[ 'HTTP_HOST' ])) {

            return $_SERVER[ 'HTTP_HOST' ];
        }
    }
}

if (!function_exists('script')) {
    function script()
    {
        if (isset($_SERVER[ 'SCRIPT_NAME' ])) {

            return $_SERVER[ 'SCRIPT_NAME' ];
        }
    }
}

if (!function_exists('query')) {
    function query()
    {
        if (isset($_SERVER[ 'QUERY_STRING' ])) {

            return $_SERVER[ 'QUERY_STRING' ];
        }
    }
}

if (!function_exists('method')) {
    function method()
    {
        if (isset($_SERVER[ 'REQUEST_METHOD' ])) {

            return $_SERVER[ 'REQUEST_METHOD' ];
        }
    }
}

if (!function_exists('ip')) {
    function ip()
    {
        $types = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR',
        ];

        foreach ($types as $type) {
            if (isset($_SERVER[ $type ])) {
                return $_SERVER[ $type ];
            }
        }

        return 'UNKNOWN';
    }
}

if (!function_exists('protocol')) {
    function protocol()
    {
        $https = [
            !empty($t_1 = $_SERVER[ 'HTTPS' ]) && in_array($t_1, ['on', 1], true),
            !empty($t_2 = $_SERVER[ 'SERVER_PORT' ]) && 443 === $t_2,
            !empty($t_3 = $_SERVER[ 'REQUEST_SCHEME' ]) && 'https' === $t_3,
            !empty($t_4 = $_SERVER[ 'HTTP_X_FORWARDED_PROTO' ]) && 'https' === $t_4,
        ];

        return in_array(true, $https, true) ? 'https' : 'http';
    }

}

if (!function_exists('session')) {
    function session($name = null, $default = null)
    {
        if (is_null($name)) {
            return new Session();
        }

        if (is_array($name)) {
            return Session::put($name);
        }

        return Session::get($name, $default);
    }
}
