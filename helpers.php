<?php

function toCamelCase($str): string
{
    return preg_replace_callback('/_([a-z])/', function ($c) {
        return strtoupper($c[1]);
    }, $str);
}

function fromCamelCase($str): string
{
    $str[0] = strtolower($str[0]);

    return preg_replace_callback('/([A-Z])/', function ($c) {
        return '_'.strtolower($c[1]);
    }, $str);
}