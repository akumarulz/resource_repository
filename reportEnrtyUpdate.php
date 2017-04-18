<?php
require_once('cleantext.php');
require_once('connect.php');
require_once('autoload.php');

if ($_SERVER['REQUEST_METHOD'] ==='POST'){
	$var = new database_query($pdo,'users');
	$var2 = new database_query($pdo,'reports');
	
	$adminid = cleantext($_POST['update']['admin']);
	$reportid = cleantext($_POST['update']['report_id']);
	
	$getRe = ['report_id'=>$reportid];
	$getar = ['user_id'=>$adminid];
	
	$foundAdmin=$var->selectcols($getar);
	$foundReport=$var2->selectcols($getRe);
	
	$valid = true;
	if(preg_match('/[£¬`$]/',$_POST['update']['result']) || trim($_POST['update']['result']=='') || ctype_space($_POST['update']['result'])){
		
		$valid=false;
	}
	
	if($foundAdmin == true && $foundReport == true && $valid==true){
		$var3 = new database_join_queries($pdo);
		$date = date("Y-m-d h:i:s");
		
		$string = $inputStr = $date.' -> '.$foundAdmin['first_name'].' '.$foundAdmin['surname'].' -> '.trim($_POST['update']['result']).'$$';
		
		$inputarray = [
		'result' => $string,
		'report_id'=>$reportid
		];
		$result = $var3->updateReport($inputarray);
		if($result){
			
			$array = ['result'=>'1', 'reportid'=>$reportid];
			echo json_encode($array);
		}else{
			$array = ['result'=>'2'];
			echo json_encode($array);
		}
	}else{
		$array = ['result'=>'3'];
		echo json_encode($array);
	}
	
}

?>