<?php
// migrate
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();


//GET CATEGORIES
$categs=[];
foreach($VORC->wiki_categories() as $k=>$v){
	$categs[$v['wc_name']]=$v['wc_id'];
}
//print_r($categs);exit;
$platforms=[];
foreach($VORC->wiki_platforms() as $k=>$v){
	//$categs[$v['wc_name']]=$v['wc_id'];
	$platforms[$v['wp_name']]=$v['wp_id'];
}
//print_r($platforms);exit;

$sql="SELECT w_id, flag_platform, flag_category FROM vorc.wiki;";
$q=$VORC->db()->query($sql) or die("Error");

while($r=$q->fetch()){
	//print_r($r);
	$fplatforms=explode(';',$r['flag_platform']);
	$fcategories=explode(';',$r['flag_category']);
	/*
	foreach($fplatforms as $str){
		if(!$str)continue;
		echo "<li>$str - #".$platforms[$str];
		$VORC->addPlatform($r['w_id'],$platforms[$str]);
	}
	*/
	/*
	foreach($fcategories as $str){
		if(!$str)continue;
		echo "<li>$str - #".$categs[$str];
		$VORC->addCategory($r['w_id'],$categs[$str]);
	}
	*/
	//echo "<br />";
}