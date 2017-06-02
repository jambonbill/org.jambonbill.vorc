<?php
// VORC :: WIKI CTL
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$VORC=new VORC\Vorc();

switch ($_POST['do']) {

	case 'search':

		//print_r($_POST);

		$WHERE=[];
		$WHERE[]='1=1';
		if($_POST['search'])$WHERE[]='name_wikipage LIKE "%'.$_POST['search'].'%" ';
		if($_POST['category'])$WHERE[]='flag_category LIKE "%;'.$_POST['category'].';%" ';
		if($_POST['platform'])$WHERE[]='flag_platform LIKE "%;'.$_POST['platform'].';%" ';
		if($_POST['user']){
			$WHERE[]='(user_created LIKE "'.$_POST['user'].'" OR user_modified LIKE "'.$_POST['user'].'" )';
		}
		$WHERE=implode(' AND ',$WHERE);

		// FIND //
		$sql ="SELECT * FROM vorc.wiki_en WHERE $WHERE ORDER BY user_modified DESC;";
		//echo "<pre>$sql</pre>";

		$q=$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");

		$htm=[];
		$htm[]= "<table class='table table-condensed table-hover'>";
		$htm[]= "<thead>";
		$htm[]= "<th>Page name</th>";
		$htm[]= "<th>Categ</th>";
		$htm[]= "<th>User</th>";
		$htm[]= "<th>Updated</th>";
		$htm[]= "</thead>";
		$htm[]= "<tbody>";
		$records=0;
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			//print_r($r);
			$htm[]= "<tr>";
			$htm[]= "<td><a href='page.php?id=".$r['id']."'>".$r['name_wikipage']."</a>";
			$htm[]= "<td>".implode(" ",explode(";",$r['flag_category']));
			$htm[]= "<td>".$r['user_modified'];
			$t=strtotime($r['lastupdate']);
			$htm[]= "<td>".date("Y-m-d",$t);
			$records++;
		}
		$htm[]= "</tbody>";
		$htm[]= "</table>";
		$htm[]= "<i class='text-muted'>$records records</i>";
		echo implode('',$htm);
		exit;
		break;

	default:
		# code...
		break;
}

die("Error");
