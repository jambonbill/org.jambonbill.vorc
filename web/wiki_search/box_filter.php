<?php

$htm='<div class=row>';

$htm.='<div class=col-sm-4>';
$htm.='<div class=form-group>';
$htm.='<label>Search</label>';
$htm.='<input class="form-control" placeholder=search id=search>';
$htm.='</div>';
$htm.='</div>';

$htm.='<div class=col-sm-4>';
$htm.='<div class=form-group>';
$htm.='<label>Category</label>';
$htm.='<select class="form-control" id=category>';
$htm.='<option value="">Select category';
$categs=$VORC->wiki_categories();
//print_r($categs);
foreach($categs as $r){
	$htm.='<option value="'.$r['wc_id'].'">'.$r['wc_name'];
}
$htm.='</select>';
$htm.='</div>';
$htm.='</div>';


$htm.='<div class=col-sm-4>';
$htm.='<div class=form-group>';
$htm.='<label>Platform</label>';
$platforms=$VORC->wiki_platforms();
//print_r($platforms);
$htm.='<select class="form-control" id=platform>';
$htm.='<option value="">Select platform';
foreach($platforms as $r){
	$htm.='<option value="'.$r['wp_id'].'">'.$r['wp_name'];
}
$htm.='</select>';
$htm.='</div>';
$htm.='</div>';


$htm.='</div>';//End row

//Slug/Body
//Category
//Platform

$box=new LTE\Box;
$box->id('boxSearch');
$box->icon('fa fa-search');
$box->title('Search wiki');
$box->body($htm);
//$box->footer('<a href=# class="btn btn-default"><i class="fa fa-times"></i> Save</a>');
$box->collapsable(1);
$box->loading(1);
echo $box;