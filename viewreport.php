<<<<<<< HEAD
	<?php
	$find = new database_query($pdo,'users');
	$admin = $_SESSION['user_id'];
	//check to make sure user id admin
	$id=null;
	$reportid = null;
	$delt_by = null;
	if($_SESSION['is_admin'] =='Y'){

			require_once('cleantext.php');
			//remember to make sure they are an admin user $_SESSION['is_admin']
			if(isset($_GET['user_id'])){$id=cleantext($_GET['user_id']);}
			if(isset($_GET['reportid'])){$reportid=cleantext($_GET['reportid']);}
			if(isset($_GET['delt_by']) != ''){$delt_by = cleantext($_GET['delt_by']);}

			$reports = new database_query($pdo,'reports');

			$reportAR=['report_id'=>$reportid];
			$ar=['user_id'=>$id];

			$report_submitting_user = $find->selectcols($ar);
			$getReport = $reports->selectcols($reportAR);
			$search = null;
			$about=null;
			$type=null;

			if($getReport){
				$var=null;
				$idtype = null;
				$type = $getReport['type'];
				
					switch($type){
				case'Topic':  $var= new database_query($pdo,'forum_topics'); $idtype='topic_id'; $found=$getReport['topic_id']; break;	
				case'Offender': $var= new database_query($pdo,'users'); $idtype='user_id'; $found=$getReport['offender_id']; break;	
				case'Resource': $var= new database_query($pdo,'document_resources'); $idtype='resource_id'; $found=$getReport['resource_id']; break;
				}

			$searchArray = [$idtype=>$found];
			$search = $var->selectcols($searchArray);

				switch($type){
				case'Topic': $about = '<a href="selectedForum&topic_id='.$search['topic_id'].'">'.$search['topic_title'].'</a>'; $id=$search['topic_id']; break;	
				case'Offender': $about = '<a href="profile&user_id='.$search['user_id'].'">'.ucfirst(strtolower($search['first_name'])).' '.ucfirst(strtolower($search['surname'])).'</a>'; $id=$search['user_id']; break;	
				case'Resource': $about = '<a href="resource_discussion&resource_id='.$search['resource_id'].'">'.$search['title'].'</a>'; $id = $search['resource_id']; break;	
				}

			}

	

			$templateVars = [
			'adminid' => $admin,
			'report_submitting_user'=> $report_submitting_user,
			'report'=>$getReport,
			'about'=>$about,
			'type'=>$type,
			'id'=>$id,
			'delt_by'=>$delt_by
			];

			$title = 'view report';
			$content = loadTemplate('viewreport_template.php', $templateVars);
	}else{
		// if not an admin 
		$title ='Error';
		$content = loadinnerTemplate('error_template.php');	
	}


=======
	<?php
	$find = new database_query($pdo,'users');
	$admin = $_SESSION['user_id'];
	//check to make sure user id admin
	$id=null;
	$reportid = null;
	$delt_by = null;
	if($_SESSION['is_admin'] =='Y'){

			require_once('cleantext.php');
			//remember to make sure they are an admin user $_SESSION['is_admin']
			if(isset($_GET['user_id'])){$id=cleantext($_GET['user_id']);}
			if(isset($_GET['reportid'])){$reportid=cleantext($_GET['reportid']);}
			if(isset($_GET['delt_by']) != ''){$delt_by = cleantext($_GET['delt_by']);}

			$reports = new database_query($pdo,'reports');

			$reportAR=['report_id'=>$reportid];
			$ar=['user_id'=>$id];

			$report_submitting_user = $find->selectcols($ar);
			$getReport = $reports->selectcols($reportAR);
			$search = null;
			$about=null;
			$type=null;

			if($getReport){
				$var=null;
				$idtype = null;
				$type = $getReport['type'];
				
					switch($type){
				case'Topic':  $var= new database_query($pdo,'forum_topics'); $idtype='topic_id'; $found=$getReport['topic_id']; break;	
				case'Offender': $var= new database_query($pdo,'users'); $idtype='user_id'; $found=$getReport['offender_id']; break;	
				case'Resource': $var= new database_query($pdo,'document_resources'); $idtype='resource_id'; $found=$getReport['resource_id']; break;
				}

			$searchArray = [$idtype=>$found];
			$search = $var->selectcols($searchArray);

				switch($type){
				case'Topic': $about = '<a href="selectedForum&topic_id='.$search['topic_id'].'">'.$search['topic_title'].'</a>'; $id=$search['topic_id']; break;	
				case'Offender': $about = '<a href="profile&user_id='.$search['user_id'].'">'.ucfirst(strtolower($search['first_name'])).' '.ucfirst(strtolower($search['surname'])).'</a>'; $id=$search['user_id']; break;	
				case'Resource': $about = '<a href="resource_discussion&resource_id='.$search['resource_id'].'">'.$search['title'].'</a>'; $id = $search['resource_id']; break;	
				}

			}

	

			$templateVars = [
			'adminid' => $admin,
			'report_submitting_user'=> $report_submitting_user,
			'report'=>$getReport,
			'about'=>$about,
			'type'=>$type,
			'id'=>$id,
			'delt_by'=>$delt_by
			];

			$title = 'view report';
			$content = loadTemplate('viewreport_template.php', $templateVars);
	}else{
		// if not an admin 
		$title ='Error';
		$content = loadinnerTemplate('error_template.php');	
	}


>>>>>>> origin/master
	?>