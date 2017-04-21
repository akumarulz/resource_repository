<?php
class specialist_areaObj{
private $subjects = [];
public function __construct($in_subjects){
	$this->subjects[] = $in_subjects;	
}
public function getHTML(){
	$result='<ul class="">';
		foreach($this->subjects as $rows){
			foreach($rows as $col){
				
				$result = $result.'<li>'.$col['specialist_area'].'</li>';
			}
		}
	
	$result = $result.'</ul>';
	return $result;
}
}
?>