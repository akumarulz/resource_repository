<?php
class friendrequestobj{
	private $item =[];
	
	public function __construct($in_item){
		$this->item[]=$in_item;
		
	}
	
	function getHTML(){
		$result='<div class ="summary_notification">';
		$result = $result.'<div class="summary_notification_timedate"><p>'.date( 'jS M Y',strtotime($this->item[0]['date'])).'</p></div>';
		$pic = ($this->item[0]['img']=='') ? 'images/Profileavatar.png' : 'data:image/jpeg;base64,'.base64_encode($this->item[0]['img']) ;
		$result = $result.'<img class="profileavatar" src="'.$pic.'" alt="a profile picture" />';
		$result = $result.'<br><br><br><p>'.wordwrap(substr($this->item[0]['message'],0,250),50 ,"\n",false).'</p>';
		//$result = $result.'<a href="#" ><img class="cancel_icon" src="images/cancel.png" /></a><br><br>';
		$result = $result.'</div>';		
		return $result;
	}
	
}



?>