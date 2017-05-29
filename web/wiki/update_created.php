<?php
// VORC :: WIKI NEW //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
//$admin->title("news");
echo $admin;

$VORC=new VORC\Vorc();


$slug='ouiedire';
$sql="SELECT id, old_id FROM vorc.wiki WHERE 1";
$q=$VORC->db()->query($sql) or die("Error:$sql");

echo "<pre>$sql</pre>";

while($r=$q->fetch()){
	print_r($r);
	$old=$r['old_id'];
	//2005-03-27 03-50-04
	preg_match("/([0-9]{4})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})/",$r['old_id'],$o);
	$created=$o[1].'-'.$o[2].'-'.$o[3].' '.$o[4].':'.$o[5].':'.$o[6];
	//echo "<li>$created";
	$sql="UPDATE vorc.wiki SET w_created='$created' WHERE id=".$r['id'];
	$VORC->db()->query($sql) or die("Error:$sql");
	echo "<li>$sql";
	//	exit;
}
