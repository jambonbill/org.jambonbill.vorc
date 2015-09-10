<?php
// VORC :: NEWS EN
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();

?>
<section class="content-header">
  <h1><i class='fa fa-newspaper-o'></i> NEWS - EN 
  <small></small>
  </h1>
</section>

<section class="content">
<?php

// Search //
include "box_search.php";




$box=new LTE\Box;
$box->id("boxResult");
$box->title("Result");
$box->icon("fa fa-list");
$box->body("...");
echo $box;


$admin->footer("Vorc backup");
$admin->end();