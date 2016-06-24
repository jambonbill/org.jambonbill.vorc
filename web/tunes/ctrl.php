<?php
// VORC :: TUNES

header('Content-Type: application/json');
session_start();

require __DIR__."/../../vendor/autoload.php";

$VORC=new VORC\Vorc();

$dat=[];
switch ($_POST['do']) {
	
	case 'search':

		//print_r($_POST);
		
		$dat['POST']=$_POST;

		$WHERE=[];
		$WHERE[]='1=1';
		
		
		if ($_POST['platform']) {
			$WHERE[]='flag_platform LIKE "%'.$_POST['platform'].'%" ';
		}

		if ($_POST['extension']) {
			$WHERE[]='flag_extension LIKE "%'.$_POST['extension'].'%" ';
		}

		if ($_POST['url']) {
			$WHERE[]='( url_tune1 LIKE "%'.$_POST['url'].'%" OR url_tune2 LIKE "%'.$_POST['url'].'%" )';
		}
		
		//if($_POST['user'])$WHERE[]='user_modified LIKE "'.$_POST['user'].'" ';
		
		$WHERE=implode(' AND ',$WHERE);
		
		$LIMIT=1000;

		// FIND //
		$sql="SELECT * FROM tune_index WHERE $WHERE ORDER BY tid DESC LIMIT $LIMIT;";
		
		$q=$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");
		
		//echo "<pre>$sql</pre>";
		
		$rows=[];
		while($r=$q->fetch(PDO::FETCH_ASSOC))
		{
			//trim crap
			if($r['flag_platform']){
				$r['flag_platform']=preg_replace("/^;|;$/",'',$r['flag_platform']);
			}
			
			if($r['flag_extension']){
				$r['flag_extension']=preg_replace("/^;|;$/",'',$r['flag_extension']);
			}

			$Y=substr($r['date'],0,4);
			$M=substr($r['date'],4,2);
			$D=substr($r['date'],6,2);
			$r['date']="$Y-$M-$D";
			$rows[]=$r;
		}

		$dat['rows']=$rows;

		$q=$VORC->db()->query($sql) or die("Error:".print_r($VORC->db()->errorInfo(), true)."<hr />$sql");

		exit(json_encode($dat));
		
	
	default:
		# code...
		$dat=$_POST;
		exit(json_encode($dat));
}


