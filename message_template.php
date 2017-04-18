<h1>Messages</h1>
<div class="message-submit-form"> 
	<h2>Send Message</h2>
	<form id="Form" action="messageValidate.php" method="POST">
		<input id="searchID" type="hidden" name="message[to_id]" value="<?php if(isset($user)) echo $user['user_id']; ?>" maxlength="510"  /><br> <!--id of user message is going to-->
		<input type="hidden" name="message[user_id]" value="<?php if(isset($user_id)) echo $user_id; ?>"/> <!-- who message is from-->
		<label for="searchName">Name: </label><input id="searchName" type="text" name="message[to]" value="<?php if(isset($user)) echo ucfirst(strtolower($user['first_name'])) .' '. ucfirst(strtolower($user['surname'])); ?>" autocomplete = "off" required  <?php if(isset($user)) echo 'readonly'; ?> /><br><br>
		<?php if(!isset($user)) echo '<ul id="livesearch" class="livesearch"></ul>'; ?>
		<label for="title">Title: </label><input id="title" type="text" name="message[title]" value="" required maxlength="255" /> 255 character Limit<br><br>
		<label for="message">New Message: </label><br>
		<textarea id="message" cols="50" rows="5" name="message[message]" required maxlength="2000" ></textarea><p>2000 character Limit<br>
		<input type="submit" value="Send"/>
	</form>
	<span id="output"></span>
	
</div>
<div class="inbox">
<h2>Inbox</h2>
<?php 
	if(sizeof($inbox) > 0){
		
			foreach($inbox as $item){
				$temp=array();
				$temp['messageid'] = $item['messageid'];
				$temp['user_id']=$item['sender_id'];
				$temp['message_title'] = $item['message_title'];
				$temp['date']=$item['date'];
				$temp['mread']=$item['mread'];

			$item['messageid'] = new inboxitemobj();
			$item['messageid']->setConn($findusers);
			$item['messageid']->setUser_id($user_id);
			$item['messageid']->setItem($temp);
			echo $item['messageid']->getHTML();
			}
		
	}else{
		echo 'No Messages';
	}
?>
</div>