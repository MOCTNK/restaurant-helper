<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

function debug($str) {
    echo '<pre>';
    echo var_dump($str);
    echo '</pre>';
    exit;
}

function sqlToDate($date) {
    $result = explode('-',$date);
    return $result[2].".".$result[1].".".$result[0];
}

function sqlToDateTime($date) {
    $resultDate = explode(' ',$date);
    $result = explode('-',$resultDate[0]);
    return $result[2].".".$result[1].".".$result[0]." ".$resultDate[1];
}