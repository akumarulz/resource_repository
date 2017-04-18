<?php
class summaryobj{
	private $item =[];
	
	public function __construct($in_item){
		$this->item[]=$in_item;
	}
	
	function getHTML(){
		
		$link = null;
		$notificationID = null;
		switch($this->item[0]['type']){
			case 'Resource Comment': $notificationID = $this->item[0]['id']; $link = '<p>Title: <a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=resource_discussion&resource_id='.$this->item[0]['discussion_id'].'">'.$this->item[0]['title'].'</a></p>'; break;
			case 'Forum Comment': $notificationID = $this->item[0]['id']; $link = '<p>Title: <a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=selectedForum&topic_id='.$this->item[0]['discussion_id'].'">'.$this->item[0]['title'].'</a></p>'; break;
			case 'message': 
								$messageid = explode('-',$this->item[0]['id']);
							$link = '<p><a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=readmessage&messageid='.$messageid[0].'"><b>READ MESSAGE</b></a></p>'; break;
		}
		$result='<div class ="summary_notification">';
		$result = $result.'<div class="summary_notification_timedate"><p>'.date( 'H:i D jS M Y',strtotime($this->item[0]['date'])).'</p></div>';
			$pic = ($this->item[0]['img']=='') ?'images/Profileavatar.png' : 'data:image/jpeg;base64,'.base64_encode($this->item[0]['img']) ;
		$result = $result.'<img class="profileavatar" src="'.$pic.'" alt="a profile picture" />';
		$result = $result.'<br><br><br><br><p>New message from: <b>'.$this->item[0]['name'].'</b></p>';
		$result = $result.$link;
			$text = wordwrap(substr($this->item[0]['message'],0,200),50 ,"\n",false);
		$result = $result.'<p>'.$text.'</p>';
			if($notificationID != null && $this->item[0]['accept'] != 'BLOCK' ){
				$result = $result.'<button class="blocknotification" id="'.$this->item[0]['id'].'">Block</button>';
			}
		$result = $result.'<a href="'.$this->item[0]['id'].'-'.$this->item[0]['type'].'" class="notificationManage" ><img class="cancel_summary_icon"  src="images/cancel.png" /></a><br><br>';
		$result = $result.'</div>';		
		return $result;
	}
	
}

?>