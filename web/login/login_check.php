<?php
// login
//header('Access-Control-Allow-Origin: http://mysite1.com');
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;

$admin = new LTE\AdminLte2();
$admin->title("Login");
$admin->config()->layout->{'sidebar-collapse'}=true;
//print_r($admin->config()->layout);exit;
echo $admin;
?>


<!-- Main content -->
<section class="content">

<?php
//check login, redirect on success

$cf=__DIR__."/../../profiles/".$_POST['configfile'];

if (is_file($cf)) {
    $_SESSION['configfile']=realpath($cf);
    $admin = new LTE\AdminLte2();
} else {
    echo "Error : file $cf not found";
    exit("<script>document.location.href='index.php';</script>");
}

$pdo= new VORC\Pdo();
$UD=new VORC\UserDjango($pdo->db());

if (isset($_POST['email']) && isset($_POST['password'])) {

    if ($UD->login($_POST['email'], $_POST['password'])) {

        $msg=new LTE\Callout("info", "Please wait", "You are being redirected...");

        $box=new LTE\Box;
        $box->type("success");
        $box->title("<i class='fa fa-home'></i> Welcome !");
        $box->icon('fa fa-ok');
        $box->body($msg);
        echo $box->html();

        echo "<script>document.location.href='../home/index.php';</script>";

    } else {

        // nope

        $msg ="<p>Please try again</p>";



        $foot=[];
        $foot[]="<a href='index.php' class='btn btn-default'><i class='fa fa-sign-in'></i> Try again</a>";

        $box=new LTE\Box;
        $box->type("danger");
        $box->title("Invalid login or password");
        $box->icon('fa fa-ban');
        $box->body('<script>document.location.href="index.php";</script>');
        $box->footer($foot);
        echo $box->html();

        //echo $admin->box("danger", "<i class='fa fa-sign-in'></i> Login <small>profile</small>", $callout, $foot);
    }
} else {
    echo $admin->box("danger", "<i class='fa fa-ban'></i> Login error", "Hello ?" . print_r($_POST, true));
}
