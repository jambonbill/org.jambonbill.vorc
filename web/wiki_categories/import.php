<?php
// IMPORT CATEGORIES
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();

exit('Uncomment me if you know what you are doing');

$CATEGS=$VORC->categories();
echo "<pre>";print_r($CATEGS);

foreach($CATEGS as $categ=>$num){
	$sql="INSERT INTO wiki_category (wc_name, wc_updated) VALUES ('$categ', NOW());";
	$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");
	echo "<li>$sql";
}
