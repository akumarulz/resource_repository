<<<<<<< HEAD
<div class="readMessage">
	<p class="readMessagechild2">Sent: <?php echo date('H:i jS M Y', strtotime($message['date'])); ?></p>
	<p>From: <?php echo '<b>'.ucfirst(strtolower($sender['first_name'])).' '.ucfirst(strtolower($sender['surname'])).'</b>'; ?> </p>
	
	<h2><?php echo wordwrap($message['message_title'],50,"<br>\n",true); ?></h2>
	<p class="readMessagelast-child"><?php echo $message['message']; ?></p>
	<button class="inboxreplybtn">REPLY</button>
</div>

<div class="inboxreply">
	<fieldset class="privateMessage"> 
	<legend>REPLY</legend>
	<form id="Form" action="messageValidate.php" method="POST">
		<input id="searchID" type="hidden" name="message[to_id]" value="<?php if(isset($sender)) echo $sender['user_id']; ?>" maxlength="510" /><br> <!--id of user message is going to-->
		<input type="hidden" name="message[user_id]" value="<?php echo $user_id; ?>"/> <!-- who message is from-->
		<p><?php echo '<b>'.ucfirst(strtolower($sender['first_name'])) .' '. ucfirst(strtolower($sender['surname'])).'</b>'; ?></p>
		<label for="title">Title: </label><input id="title" type="text" name="message[title]" value="<?php  echo 'RE: '.$message['message_title']; ?>" required maxlength="255" /> 255 character Limit<br><br>
		<label for="message">Message: </label><br>
		<textarea id="message" cols="110" rows="10" name="message[message]" required ><?php  echo 'ORIGINAL MESSAGE SENT '.date('H:i l jS M Y', strtotime($message['date'])).': '.wordwrap($message['message'],70); ?></textarea>
		<input type="submit" value="Send"/>
	</form>
	<span id="output"></span>
	
</fieldset>


=======
<div class="readMessage">
	<p class="readMessagechild2">Sent: <?php echo date('H:i jS M Y', strtotime($message['date'])); ?></p>
	<p>From: <?php echo '<b>'.ucfirst(strtolower($sender['first_name'])).' '.ucfirst(strtolower($sender['surname'])).'</b>'; ?> </p>
	
	<h2><?php echo wordwrap($message['message_title'],50,"<br>\n",true); ?></h2>
	<p class="readMessagelast-child"><?php echo $message['message']; ?></p>
	<button class="inboxreplybtn">REPLY</button>
</div>

<div class="inboxreply">
	<fieldset class="privateMessage"> 
	<legend>REPLY</legend>
	<form id="Form" action="messageValidate.php" method="POST">
		<input id="searchID" type="hidden" name="message[to_id]" value="<?php if(isset($sender)) echo $sender['user_id']; ?>" maxlength="510" /><br> <!--id of user message is going to-->
		<input type="hidden" name="message[user_id]" value="<?php echo $user_id; ?>"/> <!-- who message is from-->
		<p><?php echo '<b>'.ucfirst(strtolower($sender['first_name'])) .' '. ucfirst(strtolower($sender['surname'])).'</b>'; ?></p>
		<label for="title">Title: </label><input id="title" type="text" name="message[title]" value="<?php  echo 'RE: '.$message['message_title']; ?>" required maxlength="255" /> 255 character Limit<br><br>
		<label for="message">Message: </label><br>
		<textarea id="message" cols="110" rows="10" name="message[message]" required ><?php  echo 'ORIGINAL MESSAGE SENT '.date('H:i l jS M Y', strtotime($message['date'])).': '.wordwrap($message['message'],70); ?></textarea>
		<input type="submit" value="Send"/>
	</form>
	<span id="output"></span>
	
</fieldset>


>>>>>>> origin/master
<div>