<?php
class newuserobj{
	private $user=[];
	private $friendRowId;

	public function __construct(array $in_user, int $in_friendRowId = 0){
		$this->user[] = $in_user;
		$this->friendRowId = $in_friendRowId;
	}
	
	public function getHTML(){
		$result = '<div class="profileavatar_div">';
		$pic = ($this->user[0]['profilePic']=='') ? 'images/Profileavatar.png' : 'data:image/jpeg;base64,'.base64_encode($this->user[0]['profilePic']) ;
		if($this->friendRowId > 0){
			$result = $result.'<a href="'.$this->friendRowId.'" class="unfriend"><p>Unfriend</p><a/>';
		}
		$result = $result.'<a href="profile&user_id='.$this->user[0]['user_id'].'"><img class="profileavatar" src="'.$pic.'" alt="a profile picture" /></a>';
		$result = $result.'<p><b>Name:</b> <a href="profile&user_id='.$this->user[0]['user_id'].'">'.ucfirst(strtolower($this->user[0]['first_name'])).' '.ucfirst(strtolower($this->user[0]['surname'])).'</p></a>';
		$result = $result.'<p><b>From:</b> '.$this->user[0]['location'].'</p>';
		$result = $result.'<p><b>School:</b> '.$this->user[0]['school_name'].'</p>';
		$result = $result.'</div>';
		return $result;
	}	
}
?>