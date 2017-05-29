<?php
// MIGRATE URLS //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

exit("Yes?");

$VORC=new VORC\Vorc();

if(!$VORC->user_id())exit("login");

$sql="SELECT id, ex_url FROM vorc.wiki WHERE 1";
$q=$VORC->db()->query($sql) or die("Error:$sql");

echo "<pre>$sql</pre>";

while($r=$q->fetch(PDO::FETCH_ASSOC)){
	$url=trim($r['ex_url']);
	if(!$url)continue;
	print_r($r);

	$VORC->wikiUrlAdd($r['id'],$url);
}
