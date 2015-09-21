<?php
// VORC :: WIKI PAGE EN
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
//$admin->title("news");
echo $admin;

$VORC=new VORC\Vorc();

$id=$_GET['id']*1;
$sql="SELECT * FROM wiki_jp WHERE id=$id;";
$q=$VORC->db()->query($sql) or die("Error: $sql");
$r=$q->fetch(PDO::FETCH_ASSOC);

if(!$r)die("Error : Wiki page not found");

?>
<section class="content-header">
  <h1><i class='fa fa-font'></i> <?php echo $r['name_wikipage']?></h1>
</section>


<section class="content">
<?php

/*
id	varchar(14)
name_wikipage	text	
name_alias	tinytext	
lastupdate	varchar(14)	
contents	mediumtext	
flag_public	tinyint(4)			
flag_freeze	tinyint(4)			
flag_category	tinytext	
user_created	tinytext	
user_modified	tinytext	
flag_platform	tinytext	
flag_system	tinyint(1)
ex_url
*/

$htm=[];
$htm[]=$VORC->process_jp($r['contents']);

// category
//$htm[]="<div class=row><div class='col-md-12'><input type=text class='form-control' placeholder='Category' ></div></div>";

$htm[]='<div class="form-horizontal">';

// Categ //
$htm[]='<hr />';
$htm[]='<div class="form-group">';
$htm[]='<label class="col-sm-2 control-label">Category</label>';
$htm[]='<div class="col-sm-10">';
$htm[]='<input type="text" class="form-control" id="category" placeholder="Category" value="'.$r['flag_category'].'" readonly>';
$htm[]='</div></div>';

// Platform //
$htm[]='<div class="form-group">';
$htm[]='<label class="col-sm-2 control-label">Platform</label>';
$htm[]='<div class="col-sm-10">';
$htm[]='<input type="text" class="form-control" id="platform" placeholder="Platform" value="'.$r['flag_platform'].'" readonly>';
$htm[]='</div></div>';

// URL //
$htm[]='<div class="form-group">';
$htm[]='<label class="col-sm-2 control-label">URL</label>';
$htm[]='<div class="col-sm-10">';
$htm[]='<input type="text" class="form-control" id="url" placeholder="URL" value="'.$r['ex_url'].'" readonly>';
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


$box=new LTE\Box();
$box->title($r['id']);
$box->icon('fa fa-edit');
$box->body($htm);
$box->footer("<a href=index.php class='btn btn-default'><i class='fa fa-arrow-left'></i> Back</a>");
echo $box;


//echo "<hr /><pre>";print_r($r);exit;
$admin->footer("Vorc backup");
$admin->end();