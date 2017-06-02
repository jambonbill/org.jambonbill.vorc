<?php
// Admin home //
header('Content-Type: application/json');
session_start();

require __DIR__."/../../vendor/autoload.php";

//$admin = new LTE\AdminLte2;

$VORC=new VORC\Vorc();

//$_POST['do']='search';
//$_POST['search']='sid';
$dat=[];
$dat['POST']=$_POST;
switch ($_POST['do']) {


    case 'search':

    	$WHERE=[];
    	$WHERE[]='w_id>0';

        if (@$_POST['search']) {
            $WHERE[]='(w_name LIKE '.$VORC->db()->quote("%".$_POST['search']."%").' OR w_slug LIKE '.$VORC->db()->quote("%".$_POST['search']."%").')';
        }

        if (@$_POST['category']>0) {
            $_POST['category']*=1;
            $WHERE[]='w_id IN (SELECT wc_wiki_id FROM vorc.wiki_category WHERE wc_category_id='.$_POST['category'].')';
    	}

        if (@$_POST['platform']>0) {
            $_POST['platform']*=1;
            $WHERE[]='w_id IN (SELECT wp_wiki_id FROM vorc.wiki_platform WHERE wp_platform_id='.$_POST['platform'].')';
        }


    	$sql="SELECT w_id, w_name, w_slug, w_updated FROM vorc.wiki WHERE ".implode(" AND ", $WHERE)." LIMIT 100;";
    	$dat['sql']=$sql;

        $q=$VORC->db()->query($sql) or die("Error:$sql");

        $dat['pages']=[];
        while($r=$q->fetch(\PDO::FETCH_ASSOC)){
            $r['w_updated']=substr($r['w_updated'],0,16);
            $r['w_slug']=utf8_decode($r['w_slug']);
            $r['w_name']=utf8_decode($r['w_name']);
            $dat['pages'][]=$r;
        }
        $JSON=json_encode($dat);

        $err=json_last_error();
        if ($err) {
            exit("json error:".json_last_error_msg());
        }
        exit($JSON);


    default:
        die('Error');
}
