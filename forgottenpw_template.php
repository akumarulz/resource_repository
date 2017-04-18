<<<<<<< HEAD
<fieldset class="ResourceSubmissionForm">
<legend>Reset Password</legend>
	<p>Please enter your email address, a message will be sent here to reset your password.</p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=forgottenpw');?>" method="POST">
	<label for="email">Email: </label><input type="email" name="email" id="email" required /> <br><br>
	<input type="submit" />

	</form>
	<br><span><?php if(isset($reply))echo $reply;?></span>
</fieldset>
</div>