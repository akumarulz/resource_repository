<span class=""><?php if (isset($confirmed) != null) echo '<p>'.$confirmed.'</p>';?></span>
<div class="login_div">
	<h1>Login</h1>
	<div id="login_summary_div">
	<h3>About this site</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae elit gravida, 
			pretium magna et, viverra odio. Fusce facilisis mauris a consectetur dapibus. Cras vitae
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae elit gravida, 
			pretium magna et, viverra odio. Fusce facilisis mauris a consectetur dapibus. Cras vitae</p>


	</div>
	<div class="login_box">
		<form id="login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=login');?>" method="POST">
			<label for="login[email]">E-mail:</label>
			<input type="text" name="login[email]" value="<?php if(isset($login['email'])) echo $login['email'];?>" required />
			<label for="login[password]">Password:</label>
			<input type="password" name="login[password]" required />
			<br><br>
			<input class="submit" type="submit" value="submit" />
			
		</form>
		
	<a id="login_forgot_password" href="forgottenpw"><p>Forgotten Password</p></a>
		
	</div>
	<div class="login_box2">
		<h4>New user Registration</h4>
		<a id="reg_link" href="register"><p>Register</p></a>
		
	
	</div>	

</div>
