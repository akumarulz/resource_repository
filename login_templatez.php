<div class="login_div">
	<h1>Login</h1>
	<div id="login_summary_div">
	<h3>About this site</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae elit gravida, 
			pretium magna et, viverra odio. Fusce facilisis mauris a consectetur dapibus. Cras vitae
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer vitae elit gravida, 
			pretium magna et, viverra odio. Fusce facilisis mauris a consectetur dapibus. Cras vitae</p>


	</div>
	<div id="login_box">
		<form id="login_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=login');?>" method="POST">
			<label for="login[email]">Email:</label>
			<input type="text" name="login[email]" value="<?php if(isset($login['email'])) echo $login['email'];?>" required />
			<label for="login[password]">Password:</label>
			<input type="password" name="login[password]" required />
			<br><br>
			<input class="submit" type="submit" value="submit" />
			<a id="reg_link" href="register">Register</a>
		</form>
		<br><br><br>
	<a id="login_forgot_password" href="forgottenpw">Forgotten Password</a>
	
		<span class=""><?php if (isset($confirmed) != null) echo $confirmed;?></span>
	</div>	

</div>
