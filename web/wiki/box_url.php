<?php
//URL's
$URLS=$VORC->wikiUrls($ID);
//print_r($URLS);
$htm='<table class="table table-sm table-hover" style="cursor:pointer">';
$htm.='<thead>';
$htm.='<th>#</th>';
$htm.='<th>URL</th>';
//$htm.='<th>Comment</th>';
$htm.='<th style="text-align:right"></th>';
$htm.='</thead>';
$htm.='<tbody>';
foreach($URLS as $r){
	$htm.='<tr data-id='.$r['wu_id'].'>';
	$htm.='<td><i class="text-muted">'.$r['wu_id'];
	$htm.='<td>'.$r['wu_url'];
	$htm.='<td><i class="fa fa-times"></i>';//Delete
	//$htm.='<td style="text-align:right">'.$r['wu_updated'];
}
$htm.='</tbody>';
$htm.='</table>';

$box=new LTE\Box;
$box->id("boxUrl");
$box->title("Url's");
$box->icon("fa fa-list");
$box->body($htm);
$box->footer('<a href=#btn id=btnAddUrl class="btn btn-secondary"><i class="fa fa-plus-circle"></i> Add url</a>');
$box->loading(1);
echo $box;
