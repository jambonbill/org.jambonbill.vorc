<?php
// IMPORT CATEGORIES
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();

exit('Uncomment me if you know what you are doing');

$DATA=$VORC->platforms();
echo "<pre>";print_r($DATA);

foreach($DATA as $name=>$num){
	$sql="INSERT INTO wiki_platform (wp_name, wp_updated) VALUES ('$name', NOW());";
	$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");
	echo "<li>$sql";
}
