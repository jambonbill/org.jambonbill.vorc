<?php
// box search //

// build list of categories //

//print_r($VORC->categories());
//print_r($VORC->platforms());
//print_r($VORC->users());

$htm=[];
$htm[]="<div class='row'>";

$htm[]="<div class='col-md-3'>";
$htm[]="<input type='text' class='form-control' placeholder='Search wiki'>";
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
foreach($VORC->users() as $val)$htm[]="<option value='$val'>".ucfirst($val)."</option>";
$htm[]="</select></div>";

$htm[]="<div class='col-md-3'>";
$htm[]="<input type='date' class='form-control'>";
$htm[]="</div>";

$htm[]="</div>";

$box=new LTE\Box;
$box->title("Search wiki");
$box->icon("fa fa-search");
$box->body($htm);
echo $box;
?>
<script>
$(function(){
	
});
</script>