<?php
// VORC :: WIKI SEARCH //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$VORC=new VORC\Vorc();

if($VORC->user_id()<1){
	header('location:../login');
}


$admin = new LTE\AdminLte2();
$admin->title('Search');
echo $admin;

?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> WIKI Search
  <small>New wiki system</small>
  </h1>
</section>


<section class="content">
<?php
// Search //
include "box_filter.php";

include "box_results.php";
?>
<script src="js/wikisearch.js"></script>
