<?php
$box=new LTE\Box;
$box->id("boxPlatform");
$box->title("Platform(s)");
$box->icon("fa fa-list");
$box->body('<a href=#btn id=btnAddPlatform class="btn btn-default">Add platform</a>');
echo $box;
