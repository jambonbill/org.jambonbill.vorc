<?php
// migrate
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();

$sql="UPDATE vorc.wiki SET w_slug='' WHERE 1;";
$q=$VORC->db()->query($sql) or die("Error:$sql");
echo "<pre>$sql</pre>";

$sql="SELECT w_id, w_slug, w_name FROM vorc.wiki WHERE 1;";
$q=$VORC->db()->query($sql) or die("Error:$sql");

echo "<pre>$sql</pre>";

while($r=$q->fetch(PDO::FETCH_ASSOC)){

	$w_id=$r['w_id'];
	$slug=$r['w_slug'];
	if($slug)continue;

	//print_r($r);echo "<br />";

	$slug=str_replace(" ","-",trim($r['w_name']));//new slug
	$slug=str_replace("!","",$slug);
	$slug=str_replace("'","",$slug);
	$slug=str_replace('"',"",$slug);
	//$slug=str_replace(".","",$slug);//ok
	$slug=str_replace(",","",$slug);
	$slug=strtolower($slug);

	$sql="UPDATE vorc.wiki SET w_slug=".$VORC->db()->quote($slug)." WHERE w_id=$w_id LIMIT 1;";
	$VORC->db()->query($sql) or die("Error");
	echo "$sql<br />";
}