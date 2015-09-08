<?php
// VORC :: NEWS JAP
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

