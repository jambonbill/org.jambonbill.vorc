<?php
// VORC :: WIKI STATS //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$VORC=new VORC\Vorc();

if($VORC->user_id()<1){
	header('location:../login');
}


$admin = new LTE\AdminLte2();
$admin->title('Search');
echo $admin;

$categories=$VORC->categoryNames();
$platforms=$VORC->platformNames()

?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> WIKI Stats
  <small><a href=index.php>Search</a></small>
  </h1>
</section>


<section class="content">
<div class=row>
	<div class="col-sm-6">
	<?php
	// Stats //
	$sql="SELECT COUNT(*) as n, wc_category_id FROM vorc.wiki_category WHERE wc_id>0 AND wc_wiki_id>0 GROUP BY wc_category_id ORDER BY n DESC;";
	$q=$VORC->db()->query($sql) or die("Error:$sql");
	$cats=[];
	while($r=$q->fetch()){
		$cats[$r['wc_category_id']]=$r['n'];
	}
	//print_r($cats);
	$htm='<table class="table table-sm">';
	$htm.="<thead>";
	$htm.="<th>Category</th>";
	$htm.='<th style="text-align:right">WIKI Pages</th>';
	$htm.='</thead>';
	$htm.='<tbody>';
	foreach($cats as $cat=>$n){
		$htm.='<tr>';
		$htm.='<td><a href=index.php?category_id='.$cat.'>'.$categories[$cat];
		$htm.='<td style="text-align:right">'.$n;
	}
	$htm.="</tbody>";
	$htm.="</table>";

	$box=new LTE\Box;
	$box->id('boxId');
	//$box->icon('fa fa-chart');
	$box->title('WIKI Categories');
	$box->body($htm);
	$box->footer('<a href=# class="btn btn-default"><i class="fa fa-times"></i> Save</a>');
	$box->collapsable(1);
	//$box->loading(1);
	echo $box;

	?>
	</div>
	<div class="col-sm-6">
	<?php
	$sql="SELECT COUNT(*) as n, wp_platform_id FROM vorc.wiki_platform WHERE wp_id>0 AND wp_wiki_id>0 GROUP BY wp_platform_id ORDER BY n DESC;";
	$q=$VORC->db()->query($sql) or die(print_r($VORC->db()->errorInfo(), true) . "<hr />$sql");
	$pfs=[];
	while($r=$q->fetch()){
		$pfs[$r['wp_platform_id']]=$r['n'];
	}
	//print_r($pfs);

	$htm='<table class="table table-sm">';
	$htm.='<thead>';
	$htm.='<th>Platform</th>';
	$htm.='<th style="text-align:right">WIKI Pages</th>';
	$htm.='</thead>';
	$htm.='<tbody>';
	foreach($pfs as $pf=>$n){
		$htm.='<tr>';
		$htm.='<td><a href=index.php?platform_id='.$pf.'>'.$platforms[$pf];
		$htm.='<td style="text-align:right">'.$n;
	}
	$htm.="</tbody>";
	$htm.="</table>";

	$box=new LTE\Box;
	$box->id('boxId');
	//$box->icon('fa fa-edit');
	$box->title('WIKI Platforms');
	$box->body($htm);
	//$box->footer('<a href=# class="btn btn-default"><i class="fa fa-times"></i> Save</a>');
	$box->collapsable(1);
	//$box->loading(1);
	echo $box;

	?>
	</div>