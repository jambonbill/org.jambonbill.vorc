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
  <h1><i class='fa fa-wiki'></i> WIKI</h1>
</section>


<section class="content">
<?php

// Search //



// FIND //
$sql="SELECT * FROM wiki_en WHERE 1 ORDER BY user_modified DESC LIMIT 100;";
echo "<pre>$sql</pre>";

$q=$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");


echo "<table class='table table-condensed'>";
echo "<thead>";
echo "<th>Name</th>";
echo "<th>Categ</th>";
echo "<th>User</th>";
echo "<th>Updated</th>";
echo "</thead>";
echo "<tbody>";
while($r=$q->fetch(PDO::FETCH_ASSOC)){
	//print_r($r);
	echo "<tr>";
	echo "<td>".$r['name_wikipage'];
	echo "<td>".$r['flag_category'];
	echo "<td>".$r['user_modified'];
	$t=strtotime($r['lastupdate']);
	echo "<td>".date("Y-m-d",$t);
}
echo "</tbody>";
echo "</table>";

$admin->footer("Vorc backup");
$admin->end();