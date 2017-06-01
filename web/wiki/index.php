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
	$sql="SELECT * FROM vorc.wiki WHERE (w_slug LIKE ".$VORC->db()->quote($slug)." OR w_name LIKE ".$VORC->db()->quote($slug).");";
	$q=$VORC->db()->query($sql) or die("Error:$sql");
	$r=$q->fetch(PDO::FETCH_ASSOC);
	if(!$r){
		exit("WIKI slug ($slug) not found");
	}

}else if(isset($_GET['id'])&&$_GET['id']>0){
	$ID=$_GET['id']*=1;
	$sql="SELECT * FROM vorc.wiki WHERE w_id=$ID;";
	$q=$VORC->db()->query($sql) or die("Error:$sql");
	$r=$q->fetch(PDO::FETCH_ASSOC);
} else {
	$sql="SELECT * FROM vorc.wiki WHERE 1=1 ORDER BY RAND() LIMIT 1;";
	$q=$VORC->db()->query($sql) or die("Error:$sql");
	$r=$q->fetch(PDO::FETCH_ASSOC);
	//redirect//
	header('location: ?id='.$r['w_id']);
}

if ($r) {
	$ID=$r['w_id'];
	//print_r($r);
}else{
	exit("WIKI Page not found - <a href=../wiki_search>search</a> ");
}

if (!$r['w_slug']) {
	//TODO
	$slug=str_replace(" ","-",$r['w_name']);
	$r['w_slug']=strtolower($slug);
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
include "modal_edit.php";

//include "box_category.php";
//include "box_platform.php";
include "box_url.php";
include "modal_url.php";
?>
<script src="js/wiki.js"></script>
