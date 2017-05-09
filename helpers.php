<?php

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
