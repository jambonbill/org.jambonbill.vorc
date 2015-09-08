<?php
// VORC :: WIKI EN
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
//$admin->title("news");
echo $admin;

$VORC=new VORC\Vorc();
?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> WIKI </h1>
</section>


<section class="content">
<?php

// Search //
include "box_search.php";


// FIND //
$sql="SELECT * FROM wiki_en WHERE 1 ORDER BY user_modified DESC LIMIT 100;";
echo "<pre>$sql</pre>";

$q=$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");

$htm=[];
$htm[]="<table class='table table-condensed'>";
$htm[]= "<thead>";
$htm[]= "<th>Name</th>";
$htm[]= "<th>Categ</th>";
$htm[]= "<th>User</th>";
$htm[]= "<th>Updated</th>";
$htm[]= "</thead>";
$htm[]= "<tbody>";
while($r=$q->fetch(PDO::FETCH_ASSOC)){
	//print_r($r);
	$htm[]= "<tr>";
	$htm[]= "<td>".$r['name_wikipage'];
	$htm[]= "<td>".$r['flag_category'];
	$htm[]= "<td>".$r['user_modified'];
	$t=strtotime($r['lastupdate']);
	$htm[]= "<td>".date("Y-m-d",$t);
}
$htm[]= "</tbody>";
$htm[]= "</table>";



$box=new LTE\Box;
$box->title("Result");
$box->icon("fa fa-list");
$box->body($htm);
echo $box;


$admin->footer("Vorc backup");
$admin->end();