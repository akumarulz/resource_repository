<<<<<<< HEAD
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');

if (strtoupper($_SERVER['REQUEST_METHOD']) ==='POST'){
$searchtype = $_POST['typeofsearch'];

if(strlen($_POST['search']) > 1){
		$query ='SELECT * FROM '.$searchtype.' WHERE '.$_POST['title'].' LIKE \'%'.cleantext($_POST['search']).'%\'';
		$stmt = $pdo->query($query);
		$found = $stmt->fetchall(PDO::FETCH_ASSOC);
		if($found){
			$temp = array();
			foreach($found as $item){
				$array = [
					'id' =>current($item),
					'title'=>$item[$_POST['title']],
					'date'=>$item['date']
				];
					array_push($temp,$array);	
			}
			echo json_encode($temp);
		}else{
			echo 'NONE';
		}
	}
}
=======
<?php
require_once('connect.php');
require_once('autoload.php');
require_once('cleantext.php');

if (strtoupper($_SERVER['REQUEST_METHOD']) ==='POST'){
$searchtype = $_POST['typeofsearch'];

if(strlen($_POST['search']) > 1){
		$query ='SELECT * FROM '.$searchtype.' WHERE '.$_POST['title'].' LIKE \'%'.cleantext($_POST['search']).'%\'';
		$stmt = $pdo->query($query);
		$found = $stmt->fetchall(PDO::FETCH_ASSOC);
		if($found){
			$temp = array();
			foreach($found as $item){
				$array = [
					'id' =>current($item),
					'title'=>$item[$_POST['title']],
					'date'=>$item['date']
				];
					array_push($temp,$array);	
			}
			echo json_encode($temp);
		}else{
			echo 'NONE';
		}
	}
}
>>>>>>> origin/master
?>