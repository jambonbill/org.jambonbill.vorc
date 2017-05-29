<?php

$body=[];
$body[]="<form id=f role=form method='post' action='login_check.php'>";


//get config profiles
$configs=glob(__DIR__.'/../../profiles/*.json');

$body[]="<div class='form-group'>";
$body[]="<select name=configfile id='configs' class='form-control'>";
$body[]="<option value=''>Select profile</option>";
foreach ($configs as $conf) {
    $conf=basename($conf);
    $body[]="<option value=$conf>".explode(".json", $conf)[0]."</option>";
}
$body[]="</select>";
$body[]="</div>";

$body[]="<div class='form-group'>";
$body[]="<div class='input-group'>";
$body[]="<span class=input-group-addon>@</span>";
$body[]="<input type=email id='email' name='email' class=form-control placeholder='Email'>";
$body[]="</div></div>";


$body[]="<div class=form-group>";
$body[]="<div class=input-group>";
$body[]="<span class=input-group-addon><i class='fa fa-sign-in'></i></span>";
$body[]="<input type=password id=password name=password class=form-control placeholder='Password'>";
$body[]="</div></div>";
//$body[]="</form>";

$foot=[];
$foot[]="<button type=submit class='btn btn-primary'><i class='fa fa-sign-in'></i> Login</button>";
$foot[]="</form>";

$box=new LTE\Box;
$box->id("boxlogin");
$box->type("danger");
$box->icon('fa fa-sign-in');
$box->title('Enter your credentials');
$box->loading(true);
//$box->footer($foot);
echo $box->html($body, $foot);

?>
<div id='more'>more</div>
<script>

</script>