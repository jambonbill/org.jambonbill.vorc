<?php
// VORC :: WIKI EN
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
//$admin->title("news");
echo $admin;

$VORC=new VORC\Vorc();

?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> WIKI - JAP
  <small><?php echo $VORC->wikiJpCount();?> pages in VORC wiki JAP</small>
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