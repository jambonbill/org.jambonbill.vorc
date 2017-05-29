<?php
// Admin home //
header('Content-Type: application/json');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2;

//print_r($_POST);

switch ($_POST['do']) {

    case 'addUrl':
        break;

    case 'addCategory':
        break;

    case 'addPlatform':
        break;

    default:
        die('Error');
}
