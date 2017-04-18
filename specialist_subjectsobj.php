<<<<<<< HEAD
<?php 
class specialist_subjectsobj{
	private $subjects =[];

	public function __construct($in_subjects){
		$this->subjects = $in_subjects;
	}
	
	public function getHTML(){
		$result = '<select id="specialist_areaSelect" name = "speciality_id" >';
		foreach($this->subjects as $row){
			$result = $result.'<option value="'.$row['speciality_id'].'">'.$row['specialist_area'].'</option>';
		}
		$result = $result.'</select>';
		return $result;
	}
}

=======
<?php 
class specialist_subjectsobj{
	private $subjects =[];

	public function __construct($in_subjects){
		$this->subjects = $in_subjects;
	}
	
	public function getHTML(){
		$result = '<select id="specialist_areaSelect" name = "speciality_id" >';
		foreach($this->subjects as $row){
			$result = $result.'<option value="'.$row['speciality_id'].'">'.$row['specialist_area'].'</option>';
		}
		$result = $result.'</select>';
		return $result;
	}
}

>>>>>>> origin/master
?>