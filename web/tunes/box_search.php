<?php

$htm=[];
$htm[]="<div class='row'>";

$htm[]="<div class='col-xs-3'>";
$htm[]="<input type='text' class='form-control' placeholder='Platform' id='platform'>";
$htm[]="</div>";

$htm[]="<div class='col-xs-3'>";
$htm[]="<input type='text' class='form-control' placeholder='Extension' id='extension'>";
$htm[]="</div>";

// URL
$htm[]="<div class='col-xs-3'>";
$htm[]="<input type='text' class='form-control' placeholder='Url' id='url'>";
$htm[]="</div>";

$htm[]="<div class='col-xs-3'>";
$htm[]="<input type='text' class='form-control' placeholder='Date' id='date'>";
$htm[]="</div>";

$htm[]="</div>";



// Search //
$box=new LTE\Box;
$box->id("boxSearch");
$box->title("Search tunes");
$box->icon("fa fa-search");
$box->body($htm);
$box->collapsable(1);
echo $box;
