<?php

$htm='<pre>no data</pre>';

$box=new LTE\Box;
$box->id('boxResults');
$box->icon('fa fa-search');
$box->title('Search wiki');
$box->body($htm);
//$box->footer('<a href=# class="btn btn-default"><i class="fa fa-times"></i> Save</a>');
$box->collapsable(1);
$box->loading(1);
echo $box;