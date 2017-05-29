<div class="login-box">

  <div class="login-logo">
    <a href="index.php"><b>Login</b></a>
  </div><!-- /.login-logo -->

  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>
    <!--<form action="login.php" method="post">-->
    <form id='f' role='form' method='post' action='login_check.php'>
    <?php
    //get config profiles
    $configs=glob(__DIR__.'/../../profiles/*.json');

    $body=[];
    $body[]="<div class='form-group'>";

    if (count($configs)>1) {
        $body[]="<select name=configfile id='configs' class='form-control'>";
        $body[]="<option value=''>Select profile</option>";
    } else {
        $body[]="<select name=configfile id='configs' class='form-control' readonly style='display:none'>";
    }

    foreach ($configs as $conf) {
        $conf=basename($conf);
        $body[]='<option value="'.$conf.'">'.explode(".json", $conf)[0].'</option>';
    }

    $body[]='</select>';
    $body[]='</div>';
    
    echo implode('',$body);
    
    ?>

      <div class="form-group has-feedback">
        <input type="text" class="form-control" name='email' placeholder="Email">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" name='password' placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">    
        </div><!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div><!-- /.col -->
      </div>
    </form>

  </div><!-- /.login-box-body -->

</div>
