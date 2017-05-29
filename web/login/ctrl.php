<?php
//admin home
header('Content-Type: application/json');
session_start();

require __DIR__."/../../vendor/autoload.php";

//use Admin\AdminLte;

$admin = new LTE\AdminLte2;

//print_r($_POST);

switch ($_POST['do']) {

    case "login":
        print_r($_POST);
        break;

    case "logout": 
        print_r($_POST);
        $admin->logout();
        break;

    case "testProfile":
        //print_r($_POST);
        $configfile=__DIR__."/../../profiles/".$_POST['conf'];

        if (is_file($configfile)) {

            $conf = json_decode(file_get_contents($configfile));
            //exit;

            if ($err=json_last_error_msg()) {
                if ($err!='No error') {
                    //die("<pre>".print_r($err, true)."</pre>");
                    $dat['error']="Profile error (json) $err";
                    exit(json_encode($dat));
                }
            }

            //since we went this far...
            try{
                $LAWS = new LAWS\Laws;
                $dat['user']=$LAWS->user();    
            }
            catch(Exception $e){

            }


        } else {
            $dat["error"]="config file not found";
        }
        exit(json_encode($dat));

    default:
        die('Error');
}
