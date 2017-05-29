<?php
// log out
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";


$admin = new LTE\AdminLte2;
$admin->title("Logout");
echo $admin;
?>

<section class="content-header">
    <h1 class='text-center'><i class="fa fa-sign-out"></i> Logout</h1>
</section>

<!-- Main content -->
<section class="content">

<?php
$pdo= new VORC\Pdo();
$db = $pdo->getDatabase();
$UD=new VORC\UserDjango($db);

if ($UD->logout()) {
    $msg=new LTE\Callout("danger", "done", "Bye! <a href='index.php'>Login</a>");
    echo new LTE\Box("danger", "Logout", $msg);
    echo "<script>document.location.href='index.php';</script>";
} else {
    echo "logout error!";
    exit;
    echo "<script>document.location.href='index.php';</script>";
}
