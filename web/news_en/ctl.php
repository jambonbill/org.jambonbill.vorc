<?php
// VORC :: NEW EN :: CTL
header('Content-Type: text/html; charset=utf-8');
session_start();

require __DIR__."/../../vendor/autoload.php";

$VORC=new VORC\Vorc();

switch ($_POST['do']) {

	case 'search':

		//print_r($_POST);

		$WHERE=[];
		$WHERE[]='1=1';
		$WHERE[]='newsbody<>""';
		if($_POST['search']){
			$WHERE[]='(title LIKE '.$VORC->db()->quote($_POST['search']).' OR newsbody LIKE '.$VORC->db()->quote($_POST['search']).')';
		}

		if($_POST['flag_wiki'])$WHERE[]='flag_wiki LIKE "%'.$_POST['flag_wiki'].'%" ';
		//if($_POST['platform'])$WHERE[]='flag_platform LIKE "%;'.$_POST['platform'].';%" ';
		if($_POST['user'])$WHERE[]='user_modified LIKE "'.$_POST['user'].'" ';
		$WHERE=implode(' AND ',$WHERE);

		// FIND //
		$sql ="SELECT * FROM vorc.news_en WHERE $WHERE ORDER BY user_modified DESC;";
		//echo "<pre>$sql</pre>";

		$q=$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");

		$htm=[];
		$htm[]= "<table class='table table-condensed table-hover'>";
		$htm[]= "<thead>";
		//$htm[]= "<th>Date</th>";
		$htm[]= "<th>Title</th>";
		$htm[]= "<th>By</th>";
		$htm[]= "<th>Updated</th>";
		$htm[]= "</thead>";
		$htm[]= "<tbody>";
		$records=0;
		while($r=$q->fetch(PDO::FETCH_ASSOC)){
			//print_r($r);
			$htm[]= "<tr>";
			//$htm[]= "<td>".;
			if(!$r['title'])$r['title']='#'.$r['nid'];
			$htm[]= "<td><a href='news.php?id=".$r['nid']."'>".substr($r['title'],0,255)."</a>";
			$htm[]= " <i class='text-muted'>".$r['disp_date']."</i>";
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
