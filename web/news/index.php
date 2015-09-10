<?php
// VORC :: NEWS INDEX
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();

?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> VORC NEWS
  <small>Index</small>
  </h1>
</section>

<section class="content">
<?php

// Search //
$sql="SELECT * FROM news_index WHERE 1 ORDER BY nid DESC LIMIT 30;";
$q=$VORC->db()->query($sql) or die("Error:$sql"); 

while($r=$q->fetch(PDO::FETCH_ASSOC))
{
	echo "<pre>";print_r($r);exit;
}


$box=new LTE\Box;
$box->id("boxResult");
$box->title("Result");
$box->icon("fa fa-list");
$box->body("...");
echo $box;


$admin->footer("Vorc backup");
$admin->end();