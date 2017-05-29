<?php
// VORC :: WIKI NEW //
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$admin = new LTE\AdminLte2();
//$admin->title("news");
echo $admin;

$VORC=new VORC\Vorc();

?>
<section class="content-header">
  <h1><i class='fa fa-wikipedia-w'></i> WIKI
  <small>New wiki system</small>
  </h1>
</section>


<section class="content">
<?php
/*
New tables:
---------------
-wiki_category
-wiki_platform
-wiki_url
-wiki_user
*/

// Search //
//include "box_search.php";

include "box_category.php";
include "box_platform.php";
include "box_url.php";

