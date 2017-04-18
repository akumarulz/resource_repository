<?php
class database_join_queries{
private $pdo;

public function __construct($connect){
			$this->pdo = $connect;
		}		

function findSubjects($userid){
	try{
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$query = 'SELECT `specialist_subjects`.`specialist_area` 
			FROM `users` 
			LEFT JOIN `has_specialist_subject` 
			ON `has_specialist_subject`.`user_id` = `users`.`user_id` 
			LEFT JOIN `specialist_subjects` 
			ON `has_specialist_subject`.`subject_id` = `specialist_subjects`.`speciality_id` 
			WHERE (`users`.`user_id` = :userid)';
			
			$array = ['userid'=>$userid];
			$stmt = $this->pdo->prepare($query);
			
			$stmt->execute($array);
			return $stmt->fetchall(PDO::FETCH_ASSOC);
		}catch(PDOException $e){
			echo $sql . "<br>" . $e->getMessage();
		}
	}
		function insertRatings($id,$rating,$total_rating,$total_rates,$rated_user_id){
			try{
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$array = [
			'rating' => $rating,
			'total_ratings' => $total_rating,
			'total_rates' => $total_rates,
			'rated_user_id' => ','.$rated_user_id,
			'id'=>$id
			];
			
			$query = 'UPDATE document_resources 
			SET rating =:rating, total_ratings =:total_ratings, total_rates =:total_rates, rated_user_id=CONCAT(rated_user_id,:rated_user_id)
			WHERE resource_id =:id';
	
			
			$stmt = $this-> pdo->prepare($query);
			$stmt->execute($array);
			$result = $stmt->rowCount();
			return $result;
			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}

	
	
	function counter($column,$topicid){
		try{
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$query='SELECT COUNT(`comment_id`) AS NUM FROM `discussion` WHERE '.$column.' = '.$topicid;
		$stmt = $this->pdo->query($query);
		return $stmt->fetch();
		}catch(PDOException $e){
				echo $e->getMessage();
			}
	}
	
	function newestmembers(){
		$query = 'SELECT * FROM `userhistorytable` order by `user_id` desc limit 5';
		$stmt = $this->pdo->query($query);
		return $stmt->fetchall(PDO::FETCH_ASSOC);
	}
	
	function updateReport($values){
		$query = 'UPDATE reports
		SET result =CONCAT(:result,result) WHERE report_id =:report_id';
	
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($values);
		return $result = $stmt->rowCount();
		
	}
	
	function block_user($values){
		$query = 'UPDATE '.$values['tablename'].' 
					SET blocked_users = CONCAT(blocked_users,CONCAT(",",'.$values['blocked'].'))
					WHERE '.$values['idtype'].' ='.$values['id'];
					$stmt = $this->pdo->query($query);
					return $stmt->rowCount();
					
	}

	function getMessage(array $value):array{
		$query = "SELECT * FROM messages WHERE reciever_id =:reciever AND mread = :mread";
		$stmt = $this->pdo->prepare($query);
		$stmt->execute($value);
		return $stmt->fetchall(PDO::FETCH_ASSOC);
	}

	function sendUploadNotification(array $values):array{
		$query = 'SELECT * FROM users 
				JOIN has_specialist_subject
				ON users.user_id = has_specialist_subject.user_id
				JOIN document_resources
				ON document_resources.category_id = has_specialist_subject.subject_id
				WHERE has_specialist_subject.subject_id = '.$values['subject_id'].'
				AND users.confirmed = \'Y\'
				AND users.user_id != '.$values['user_id'].'
				AND document_resources.resource_id = '.$values['resource_id'].'
				GROUP BY users.email';

		$stmt = $this->pdo->query($query);
		return $stmt->fetchall(PDO::FETCH_ASSOC);

	}
}
?>