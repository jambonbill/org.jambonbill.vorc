<?php
// VORC :: WIKI NEW //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$VORC=new VORC\Vorc();

if($VORC->user_id()<1){
	header('location:../login');
}

if(isset($_GET['slug'])){
	$slug=$_GET['slug'];
}else if(isset($_GET['id'])&&$_GET['id']>0){
	$ID=$_GET['id']*=1;
	$sql="SELECT * FROM vorc.wiki WHERE w_id=$ID;";
	$q=$VORC->db()->query($sql) or die("Error:$sql");
	$r=$q->fetch(PDO::FETCH_ASSOC);
}else{
	$slug=$VORC->random_slug();
	$sql="SELECT * FROM vorc.wiki WHERE w_slug LIKE ".$VORC->db()->quote($slug);
	$q=$VORC->db()->query($sql) or die("Error:$sql");
	$r=$q->fetch(PDO::FETCH_ASSOC);
}



if ($r) {
	$ID=$r['w_id'];
	//print_r($r);
}else{
	exit("WIKI Page not found");
}

$admin = new LTE\AdminLte2();
$admin->title($r['w_name']);
echo $admin;
echo "<input type=hidden id=w_id value=$ID>";
?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> WIKI
  <small>New wiki system</small>
  </h1>
</section>


<section class="content">
<?php

//echo "<pre>$sql</pre>";


/*
New tables:
---------------
-wiki_category
-wiki_platform
-wiki_url
-wiki_user
*/

// Search //
//include "box_search.php";

include "box_content.php";
//include "box_category.php";
//include "box_platform.php";
include "box_url.php";
?>
<script src="js/wiki.js"></script>
