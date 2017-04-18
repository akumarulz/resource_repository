<<<<<<< HEAD
<h1>Reset Password</h1>
<div class="passwordreset" >
	
<p>Please enter your new password</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=resetpw&user_id='.$user_id);?>" method="post">
<input type="hidden" name="user[user_id]" value="<?php if(isset($user_id)) echo $user_id; ?>" />
<input id="checker" type="hidden" name="user[checker]" value="" />

<label for="pw">Password: </label><br><input id="pw" type="password" name="user[password]" value="" /> <br>
	
	<label for="ckpw">Re-enter Password</label><br><input id="ckpw" type="password" /> <img class="confirmPw" src="images/cross.png" alt="password confirmation image"/>

	<input type="submit" />
	<span id="output"><?php if(isset($reply)) echo $reply; ?></span>
</form>
=======
<h1>Reset Password</h1>
<div class="passwordreset" >
	
<p>Please enter your new password</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=resetpw&user_id='.$user_id);?>" method="post">
<input type="hidden" name="user[user_id]" value="<?php if(isset($user_id)) echo $user_id; ?>" />
<input id="checker" type="hidden" name="user[checker]" value="" />

<label for="pw">Password: </label><br><input id="pw" type="password" name="user[password]" value="" /> <br>
	
	<label for="ckpw">Re-enter Password</label><br><input id="ckpw" type="password" /> <img class="confirmPw" src="images/cross.png" alt="password confirmation image"/>

	<input type="submit" />
	<span id="output"><?php if(isset($reply)) echo $reply; ?></span>
</form>
>>>>>>> origin/master
</div>