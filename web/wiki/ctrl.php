<?php
// VORC CTRL
header('Content-Type: application/json');
session_start();

require __DIR__."/../../vendor/autoload.php";

//$admin = new LTE\AdminLte2;
$VORC=new VORC\Vorc();

//print_r($_POST);
$dat=[];
switch ($_POST['do']) {

    case 'addUrl':
        $dat['POST']=$_POST;
        if($dat['id']=$VORC->wikiUrlAdd($_POST['w_id'],$_POST['url'])){
        	//ok
        }
        exit(json_encode($dat));

    case 'addCategory':
        break;

    case 'addPlatform':
        break;

    default:
        die('Error');
}
