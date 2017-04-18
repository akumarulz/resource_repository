
<?php
class selectsubjectsobj{
	private $subjectsarray=[];
	private $subject_num;
		//this needs to be fixed for editing a re 
	public function __construct($in_subjects,$in_subject_num){
	$this->subjectsarray[] = $in_subjects;
	$this->subject_num = $in_subject_num;
	}
	
	public function getHTML(){
		$result='<select id ="selectedsubjectarea" name="resourcedoc[subject]">';
		
			foreach($this->subjectsarray as $rows){
				foreach($rows as $col){
					$selected = null;
					if($this->subject_num == $col['speciality_id']){
						$selected = 'selected';
					}
					
					$result = $result.'<option value="'.$col['speciality_id'].'" '.$selected.' >'.$col['specialist_area'].'</option>';
				}
			}
		$result=$result.'</select>';
		return $result;
	}
}


?>