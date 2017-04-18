<<<<<<< HEAD
<?php
class subjects_listObj{
private $StoredSubjects=[];
private $usersubjects=[];

public function __construct($in_storedSubjects, $in_usersubjects){
	$this->StoredSubjects[] = $in_storedSubjects;
	$this->usersubjects[] = $in_usersubjects;
}

public function getHTML(){
	$result = '<input type ="hidden" name=choice[send] />';
	foreach($this->StoredSubjects as $rows){
		foreach($rows as $row){
		
	$result = $result.'<label>'.$row['specialist_area'].'</label>';
	$result = $result.'<input type ="checkbox" name="choice['.$row['specialist_area'].']"';
	$result = $result.' value="'.$row['speciality_id'].'"';
		foreach($this->usersubjects as $Urows){
			foreach($Urows as $cols){
				if($cols['subject_id'] == $row['speciality_id']){
					$result = $result.' checked ';
				}
				
				
			}$result = $result.' /><br>';
		}
	
	
		}
	
	return $result;
	
	}
	
	
	
	
}
}

=======
<?php
class subjects_listObj{
private $StoredSubjects=[];
private $usersubjects=[];

public function __construct($in_storedSubjects, $in_usersubjects){
	$this->StoredSubjects[] = $in_storedSubjects;
	$this->usersubjects[] = $in_usersubjects;
}

public function getHTML(){
	$result = '<input type ="hidden" name=choice[send] />';
	foreach($this->StoredSubjects as $rows){
		foreach($rows as $row){
		
	$result = $result.'<label>'.$row['specialist_area'].'</label>';
	$result = $result.'<input type ="checkbox" name="choice['.$row['specialist_area'].']"';
	$result = $result.' value="'.$row['speciality_id'].'"';
		foreach($this->usersubjects as $Urows){
			foreach($Urows as $cols){
				if($cols['subject_id'] == $row['speciality_id']){
					$result = $result.' checked ';
				}
				
				
			}$result = $result.' /><br>';
		}
	
	
		}
	
	return $result;
	
	}
	
	
	
	
}
}

>>>>>>> origin/master
?>