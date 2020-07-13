<?php

ini_set('display_errors', 1); // вивод помилок на екран
error_reporting(E_ALL); // вивід всіх помилок

function debug($str) {
    echo '<pre>';
    var_dump($str);
    echo '</pre>';
    exit;
}