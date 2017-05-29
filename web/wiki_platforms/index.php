<?php
// VORC :: WIKI PLATFORMS //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
$admin->title('Platforms');
echo $admin;

$VORC=new VORC\Vorc();

?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> WIKI Platforms
  <small>New wiki system</small>
  </h1>
</section>

<section class="content">
<?php



$sql="SELECT * FROM vorc.wiki_platform WHERE 1";
$q=$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");

$htm=[];
$htm[]= "<table class='table table-condensed table-hover'>";
$htm[]= "<thead>";
$htm[]= "<th width=30>#</th>";
$htm[]= "<th>Platform</th>";
$htm[]= "<th>Comment</th>";
$htm[]= "<th width=130>Updated</th>";
$htm[]= "</thead>";

$htm[]= "<tbody>";
$records=0;
while($r=$q->fetch(PDO::FETCH_ASSOC)){
	//print_r($r);
	$htm[]= '<tr>';
	$htm[]= '<td><i class="text-muted">'.$r['wp_id'];
	$htm[]= '<td>'.$r['wp_name']."</a>";
	$htm[]= '<td>'.$r['wp_comment'];
	$htm[]= '<td style="text-align:right">'.$r['wp_updated'];

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
$box->footer('<a href=# class="btn btn-default">Add</a>');
$box->collapsable(1);
$box->loading(0);
echo $box;
