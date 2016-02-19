<?php
// box search //

// build list of categories //

//print_r($VORC->categories());
//print_r($VORC->platforms());
//print_r($VORC->users());

$htm=[];
$htm[]="<div class='row'>";

$htm[]="<div class='col-md-3'>";
$htm[]="<input type='text' class='form-control' placeholder='Search wiki' id='search'>";
$htm[]="</div>";

$htm[]="<div class='col-md-2'>";
$htm[]="<select class='form-control' id=category><option value=''>Category</option>";
foreach($VORC->categories() as $val=>$num)$htm[]="<option value='$val'>".ucfirst($val)."</option>";
$htm[]="</select></div>";

$htm[]="<div class='col-md-2'>";
$htm[]="<select class='form-control' id=platform><option value=''>Platform</option>";
foreach($VORC->platforms() as $val=>$num)$htm[]="<option value='$val'>".ucfirst($val)."</option>";
$htm[]="</select></div>";

$htm[]="<div class='col-md-2'>";
$htm[]="<select class='form-control' id=user><option value=''>By</option>";
foreach($VORC->wikiUsers() as $val)$htm[]="<option value='$val'>".ucfirst($val)."</option>";
$htm[]="</select></div>";

$htm[]="<div class='col-md-3'>";
$htm[]="<input type='date' id=date class='form-control'>";
$htm[]="</div>";

$htm[]="</div>";

$box=new LTE\Box;
$box->id("boxSearch");
$box->title("Search wiki");
$box->icon("fa fa-search");
$box->boxTools("<a href=# class='btn' title='Clear'>x</a>");
$box->body($htm);
echo $box;
?>
<div id='more'></div>
<script src='js/wiki_en.js'></script>