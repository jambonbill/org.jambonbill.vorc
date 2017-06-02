<?php
// VORC :: NEWS INDEX
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
echo $admin;

$VORC=new VORC\Vorc();

$sql="SELECT COUNT(*) FROM vorc.tune_index;";
$q=$VORC->db()->query($sql) or die("Error:$sql");
$COUNT=$q->fetch()[0];
//print_r($r);
?>
<section class="content-header">
  <h1><i class='fa fa-music'></i> <?php echo $COUNT?> TUNES
  </h1>
</section>

<section class="content">
<?php

include "box_search.php";


$box=new LTE\Box;
$box->id("boxResult");
$box->title("Result");
$box->icon("fa fa-list");
$box->body("please wait");
$box->loading(true);
echo $box;
?>
<script type="text/javascript" src='js/index.js'></script>
<?php
$admin->footer("Vorc backup");
$admin->end();