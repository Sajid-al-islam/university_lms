<?php


if (!function_exists('getRandomHex')) {
    function getRandomHex($num_bytes = 4)
    {

        return strval(bin2hex(openssl_random_pseudo_bytes($num_bytes)));
    }
}

if (!function_exists('fuckOff')) {
    function fuckOff()
    {
        return 'fuck you';
    }
}
