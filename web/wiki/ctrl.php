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

    case 'update':
        $dat['POST']=$_POST;

        $w_id=trim($_POST['w_id']);
        $w_name=trim($_POST['w_name']);
        $w_slug=trim($_POST['w_slug']);
        $contents=trim($_POST['contents']);

        $sql="UPDATE vorc.wiki SET w_name=".$VORC->db()->quote($w_name).", ";
        $sql.=" w_slug=".$VORC->db()->quote($w_slug).", ";
        $sql.=" contents=".$VORC->db()->quote($contents).", ";
        $sql.=" w_updated=NOW(),";
        $sql.=" w_updater=".$VORC->user_id();
        $sql.=" WHERE w_id=$w_id LIMIT 1;";

        $VORC->db()->query($sql) or die(print_r($VORC->db()->errorInfo(), true) . "<hr />$sql");

        $dat['updated']=date('c');

        exit(json_encode($dat));


    case 'addCategory':
        break;


    case 'addPlatform':
        break;

    default:
        die('Error');
}
