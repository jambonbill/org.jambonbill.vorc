<?php
// VORC :: NEWS EN
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();

$id=$_GET['id'];
$sql="SELECT * FROM vorc.news_en WHERE nid=$id LIMIT 1;";
$q=$VORC->db()->query($sql) or die("Error");

$r=$q->fetch(PDO::FETCH_ASSOC);
if(!$r){
	die("Error");
}
?>
<section class="content-header">
  <h1><i class='fa fa-newspaper-o'></i> NEWS - EN 
  <small>#<?php echo $r['nid']?></small>
  </h1>
</section>

<section class="content">
<?php

$htm=[];
$htm[]=$r['newsbody'];
//$htm[]="<i class='text-muted'>".$r['newsbody']."</i>";

$htm[]='<div class="form-horizontal">';


$htm[]='<hr />';
// flag_wiki //
$htm[]='<div class="form-group">';
$htm[]='<label class="col-sm-2 control-label">flag_wiki</label>';
$htm[]='<div class="col-sm-10">';
$htm[]='<input type="text" class="form-control" id="category" placeholder="flag_wiki" value="'.$r['flag_wiki'].'" readonly>';
$htm[]='</div></div>';


// URL //
$htm[]='<div class="form-group">';
$htm[]='<label class="col-sm-2 control-label">URL</label>';
$htm[]='<div class="col-sm-10">';
$htm[]='<input type="text" class="form-control" id="url" placeholder="URL" value="'.$r['url'].'" readonly>';
$htm[]='</div></div>';


// Thanks //
$htm[]='<div class="form-group">';
$htm[]='<label class="col-sm-2 control-label">Thanks</label>';
$htm[]='<div class="col-sm-10">';
$htm[]='<input type="text" class="form-control" id="thanks" placeholder="Thanks" value="'.$r['thanks'].'" readonly>';
$htm[]='</div></div>';


// Memo //
$htm[]='<div class="form-group">';
$htm[]='<label class="col-sm-2 control-label">Memo</label>';
$htm[]='<div class="col-sm-10">';
$htm[]='<input type="text" class="form-control" id="memo" placeholder="Memo" value="'.$r['memo'].'" readonly>';
$htm[]='</div></div>';


// Last update //
$date=date("Y-m-d H:i:s",strtotime($r['lastupdate']));
$htm[]='<div class="form-group">';
$htm[]='<label for="inputEmail3" class="col-sm-2 control-label">Updated</label>';
$htm[]='<div class="col-xs-5">';
$htm[]='<input type="text" class="form-control" id="category" placeholder="Category" value="'.$date.'" readonly>';
$htm[]='</div>';
$htm[]='<div class="col-xs-5">';
$htm[]='<input type="text" class="form-control" id="category" placeholder="Category" value="'.$r['user_modified'].'" readonly>';
$htm[]='</div></div>';

$htm[]='</div>';


$btn=[];
$btn[]="<a href=index.php class='btn btn-default'><i class='fa fa-arrow-left'></i> Back</a>";
$btn[]="<a href=#del id=delete class='btn btn-default pull-right' title='Delete'><i class='fa fa-trash-o'></i></a>";

$box=new LTE\Box;
$box->id("boxNews");
$box->title($r['title']);
$box->icon("fa fa-list");
$box->body($htm);
$box->footer($btn);
echo $box;



?>
<script>
$(function(){
	$('#delete').click(function(){
		if(!confirm("Delete this news ?"))return false;
		alert("No");
	});
});
</script>
<?php
$admin->footer("Vorc backup");
$admin->end();

