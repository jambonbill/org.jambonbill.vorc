<?php

//echo "<pre>";print_r($r);echo "</pre>";
$htm='';
//$htm='<pre>'.print_r($r,1).'</pre>';
$htm.='<div class="row">';
$htm.='<div class="col-sm-6">';
$htm.='<input class="form-control" placeholder=Name>';
$htm.='</div>';

$htm.='<div class="col-sm-6">';
$htm.='<input class="form-control" placeholder=Slug>';
$htm.='</div>';

$Parsedown = new Parsedown();
$HTML=$Parsedown->text($r['contents']);

$htm.='<div class="col-sm-12">'.$HTML.'</div>';

$htm.='</div>';


$htm.='<i class="text-muted">Last updated: '.$r['w_updated'].' by '.$r['w_updater'].'</i>';

$box=new LTE\Box;
$box->id("boxContent");
$box->title($r['w_name']);
$box->small("#".$r['w_id']);
$box->body($htm);
$box->footer('<a href=#btn class="btn btn-primary"><i class="fa fa-edit"></i> Edit</a>');
$box->loading(1);
echo $box;
