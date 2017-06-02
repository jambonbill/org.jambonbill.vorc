<?php
// migrate
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();

$sql="SELECT w_id, w_name FROM vorc.wiki WHERE 1;";
$q=$VORC->db()->query($sql) or die("Error:$sql");

echo "<pre>$sql</pre>";

while($r=$q->fetch(PDO::FETCH_ASSOC)){

	$w_id=$r['w_id'];
	$name=$r['w_name'];
	//print_r($r);echo "<br />";

	echo "<li>[$w_id] $name";

	/*
	$sql="UPDATE vorc.wiki SET w_slug=".$VORC->db()->quote($slug)." WHERE w_id=$w_id LIMIT 1;";
	$VORC->db()->query($sql) or die("Error");
	echo "$sql<br />";
	*/
}