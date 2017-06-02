<?php

//echo "<pre>";print_r($r);echo "</pre>";


$markdown=$VORC->toMarkdown($r['contents']);
$Parsedown = new Parsedown();
$HTML=$Parsedown->text($markdown);

$htm='';
$htm.='<div class="col-sm-12">'.$HTML.'</div>';

$cats=$VORC->categoryNames();
$plfs=$VORC->platformNames();

foreach($VORC->pageCategories($r['w_id']) as $k=>$v){
	//print_r($v);
	$htm.='<a href=../wiki_search/?category_id='.$v['wc_category_id'].'><span class="badge badge-default">'.$cats[$v['wc_category_id']].'</span></a> ';
}

foreach($VORC->pagePlatforms($r['w_id']) as $k=>$v){
	//print_r($v);
	$htm.='<a href=../wiki_search/?platform_id='.$v['wp_platform_id'].'><span class="badge badge-primary">'.$plfs[$v['wp_platform_id']].'</span></a> ';
}

//$htm.='<li><i class="text-muted">Tags: '.$r['flag_platform'].' - '.$r['flag_category'].'</i>';



$box=new LTE\Box;
$box->id("boxContent");
$box->title($r['w_name']);
$box->small("#".$r['w_id']." [".$r['w_slug']."]");
$box->body($htm);

$btns='<div class=row>';
$btns.='<div class=col-sm-4>';
$btns.='<a href=#btn class="btn btn-primary" id=btnEdit><i class="fa fa-edit"></i> Edit</a>';
$btns.='</div>';
$btns.='<div class="col-sm-8 pull-right">';
$btns.='<i class="text-muted">Last updated: '.$r['w_updated'];
if ($r['w_updater']>0) {
	$btns.=' by '.$VORC->username($r['w_updater']).'</i>';
}


$btns.='</div>';
$btns.='</div>';

$box->footer($btns);

$box->loading(1);
echo $box;
