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
        if (isset($_SERVER['REQUEST_URI'])) {
            return $_SERVER['REQUEST_URI'];
        }
    }
}

if (!function_exists('host')) {
    function host()
    {
        if (isset($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }
    }
}

if (!function_exists('script')) {
    function script()
    {
        if (isset($_SERVER['SCRIPT_NAME'])) {
            return $_SERVER['SCRIPT_NAME'];
        }
    }
}

if (!function_exists('query')) {
    function query()
    {
        if (isset($_SERVER['QUERY_STRING'])) {
            return $_SERVER['QUERY_STRING'];
        }
    }
}

if (!function_exists('method')) {
    function method()
    {
        if (isset($_SERVER['REQUEST_METHOD'])) {
            return $_SERVER['REQUEST_METHOD'];
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
            if (isset($_SERVER[$type])) {
                return $_SERVER[$type];
            }
        }

        return 'UNKNOWN';
    }
}

if (!function_exists('protocol')) {
    function protocol()
    {
        $https = [
            !empty($t_1 = $_SERVER['HTTPS']) && in_array($t_1, ['on', 1], true),
            !empty($t_2 = $_SERVER['SERVER_PORT']) && 443 === $t_2,
            !empty($t_3 = $_SERVER['REQUEST_SCHEME']) && 'https' === $t_3,
            !empty($t_4 = $_SERVER['HTTP_X_FORWARDED_PROTO']) && 'https' === $t_4,
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

if (!function_exists('cookie')) {
    function cookie($name = null, $default = null)
    {
        if (is_null($name)) {
            return new Cookie();
        }

        if (is_array($name)) {
            return Cookie::put($name);
        }

        return Cookie::get($name, $default);
    }
}

if (!function_exists('csrf_field')) {
    function csrf_field()
    {
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token()
    {
    }
}

if (!function_exists('request')) {
    function request($key = null, $default = null)
    {
    }
}

if (!function_exists('json')) {
    function json($data)
    {
        header('Content-Type: application/json');

        return json_encode($data);
    }
}

if ( ! function_exists('array_get')) {
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $default
     *
     * @return mixed
     */
    function array_get(array $array, $key, $default = null) {
        if ($key === null) {
            return null;
        }

        if (isset($array[$key])) {
            return $array[$key];
        }

        foreach (explode('.', $key) as $segment) {
            if ( ! is_array($array) || ! array_key_exists($segment, $array)) {
                return $default;
            }

            $array = $array[$segment];
        }

        return $array;
    }
}

if ( ! function_exists('array_has')) {
    /**
     * Check if an item exists in an array using "dot" notation.
     *
     * @param  array $array
     * @param  string $key
     *
     * @return bool
     */
    function array_has(array $array, $key) {
        if (empty($array) || $key === null) {
            return false;
        }

        if (array_key_exists($key, $array)) {
            return true;
        }

        foreach (explode('.', $key) as $segment) {
            if ( ! is_array($array) || ! array_key_exists($segment, $array)) {
                return false;
            }

            $array = $array[$segment];
        }

        return true;
    }
}

if ( ! function_exists('array_set')) {
    /**
     * Set an array item to a given value using "dot" notation.
     *
     * @param  array $array
     * @param  string $key
     * @param  mixed $value
     *
     * @return array
     */
    function array_set(array &$array, $key, $value) {
        if ($key === null) {
            return null;
        }

        $keys = explode('.', $key);

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if ( ! isset($array[$key]) || ! is_array($array[$key])) {
                $array[$key] = [];
            }

            $array = &$array[$key];
        }

        $array[array_shift($keys)] = $value;

        return $array;
    }
}

if ( ! function_exists('array_remove')) {
    /**
     * Remove one or many array items from a given array using "dot" notation.
     *
     * @param  array $array
     * @param  array|string $keys
     *
     * @return void
     */
    function array_remove(array &$array, $keys) {
        $original = &$array;

        if ( ! is_array($keys)) {
            $keys = [$keys];
        }

        foreach ((array) $keys as $key) {
            $parts = explode('.', $key);

            while (count($parts) > 1) {
                $part = array_shift($parts);

                if (isset($array[$part]) && is_array($array[$part])) {
                    $array = &$array[$part];
                }
            }

            unset($array[array_shift($parts)]);

            $array = &$original;
        }
    }
}

if ( ! function_exists('array_add')) {
    /**
     * Add an element to the array at a specific location
     * using the "dot" notation.
     *
     * @param array $array
     * @param $key
     * @param $value
     *
     * @return array
     */
    function array_add(array &$array, $key, $value) {
        $target = array_get($array, $key, []);

        if ( ! is_array($target)) {
            $target = [$target];
        }

        $target[] = $value;
         array_set($array, $key, $target);

        return $array;
    }
}

if ( ! function_exists('array_take')) {
    /**
     * Get an item and remove it from the array.
     *
     * @param array $array
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    function array_take(array &$array, $key, $default = null) {
        $value = array_get($array, $key, $default);

        if (array_has($array, $key)) {
            array_remove($array, $key);
        }

        return $value;
    }
}

if ( ! function_exists('array_first')) {
    /**
     * @param array $array
     * @param null $default
     *
     * @return mixed
     */
    function array_first(array $array, $default = null) {
        if (empty($array)) {
            return $default;
        }

        return reset($array);
    }
}
