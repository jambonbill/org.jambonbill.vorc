<?php
// VORC :: WIKI CATEOGRIES //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
$admin->title('Categories');
echo $admin;

$VORC=new VORC\Vorc();

?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> WIKI Categories
  <small>New wiki system</small>
  </h1>
</section>

<section class="content">
<?php



$sql="SELECT * FROM wiki_category WHERE 1";
$q=$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");

$htm=[];
$htm[]= "<table class='table table-condensed table-hover'>";
$htm[]= "<thead>";
$htm[]= "<th width=30>#</th>";
$htm[]= "<th>Categ</th>";
$htm[]= "<th>Comment</th>";
$htm[]= "<th width=130>Updated</th>";
$htm[]= "</thead>";

$htm[]= "<tbody>";
$records=0;
while($r=$q->fetch(PDO::FETCH_ASSOC)){
	//print_r($r);
	$htm[]= '<tr>';
	$htm[]= '<td><i class="text-muted">'.$r['wc_id']."</a>";
	$htm[]= "<td>".$r['wc_name']."</a>";
	$htm[]= "<td>".$r['wc_comment'];
	$htm[]= '<td style="text-align:right">'.$r['wc_updated'];

	$records++;
}
$htm[]= "</tbody>";
$htm[]= "</table>";
$htm[]= "<i class='text-muted'>$records records</i>";


$box=new LTE\Box;
$box->id('boxId');
$box->icon('fa fa-edit');
$box->title('title');
$box->body($htm);
$box->footer('<a href=# class="btn btn-default">Add a category</a>');
$box->collapsable(1);
$box->loading(0);
echo $box;
