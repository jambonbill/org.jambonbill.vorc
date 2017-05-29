<?php
$box=new LTE\Box;
$box->id("boxUrl");
$box->title("Url's");
$box->icon("fa fa-list");
$box->body("please wait");
$box->footer('<a href=#btn id=btnAddUrl class="btn btn-default">Add url</a>');
echo $box;
