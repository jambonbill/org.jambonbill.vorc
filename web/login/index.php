<?php
//admin home
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$_SESSION['configfile']='';

$admin = new LTE\AdminLte2;
$admin->title("Login");
$admin->config()->layout->{'sidebar-collapse'}=true;
echo $admin;
?>

<!-- Main content -->
<section class="content">
<?php
include "box_login.php";
?>
</section>

<script src='js/login.js'></script>
