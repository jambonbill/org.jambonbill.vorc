<?php
// VORC NEWS :: box search //

$htm=[];

$htm[]="<div class='row'>";

$htm[]="<div class='col-md-2'>";
$htm[]="<input type='text' class='form-control' placeholder='Search news' id='search'>";
$htm[]="</div>";

$htm[]="<div class='col-md-2'>";
$htm[]="<input type='text' class='form-control' placeholder='Flag wiki' id='flag_wiki'>";
$htm[]="</div>";


$htm[]="<div class='col-md-2'>";
$htm[]="<input type='text' class='form-control' placeholder='Search memo' id='memo'>";
$htm[]="</div>";


$htm[]="<div class='col-md-2'>";
$htm[]="<input type='text' class='form-control' placeholder='Search url' id='url'>";
$htm[]="</div>";

/*
$htm[]="<div class='col-md-2'>";
$htm[]="<select class='form-control' id=platform><option value=''>Platform</option>";
foreach($VORC->platforms() as $val=>$num)$htm[]="<option value='$val'>".ucfirst($val)."</option>";
$htm[]="</select></div>";
*/

$htm[]="<div class='col-md-2'>";
$htm[]="<select class='form-control' id=user><option value=''>By</option>";
foreach($VORC->newsUsers() as $val)$htm[]="<option value='$val'>".ucfirst($val)."</option>";
$htm[]="</select></div>";

$htm[]="<div class='col-md-2'>";
$htm[]="<input type='date' id=date class='form-control'>";
$htm[]="</div>";

$htm[]="</div>";

$box=new LTE\Box;
$box->id("boxSearch");
$box->title("Search news");
$box->icon("fa fa-search");
$box->boxTools("<a href=# class='btn' title='Clear'>x</a>");
$box->body($htm);
echo $box;
?>

<script>
$(function(){
	
	$('#search,#flag_wiki,#user,#date').change(function(){
		console.log('change');
		searchNews();
	});

	var searchNews=function(){

		var p={
			'do':'search',
			'search':$('#search').val(),
			'flag_wiki':$('#flag_wiki').val(),
			//'platform':$('#platform').val(),
			'user':$('#user').val(),
			'date':$('#date').val()
		}
		$('#boxResult .box-body').load('ctl.php',p,function(){

		});
	}
	searchNews();
});
</script>