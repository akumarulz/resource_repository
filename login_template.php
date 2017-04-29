<span class=""><?php if (isset($confirmed) != null) echo '<p>'.$confirmed.'</p>';?></span>
<div class="login_div">
	<h1>Login</h1>
	<div id="login_summary_div">
	<h3>Welcome to Teacher Share</h3>
	<p>We at <b>Teacher Share</b> value knowledge, and knowledge shared is wisdom emparted on to all.<br> We have provided a tool for 
	  teachers to share their knowledge, experience and skills within all computing topics such as programming in java, HTML 
	  and databases. The aim is to improve the standard of education in computing around the country and encourage more students
	  to take up the subject at a degree level and lead onto a successful career. <br> Upload and share lesson plans you may of created, submit a URL of a great
	  website you have come across and would like others to know about. <br> Rate and discuss resources you have used and tell others about your experience with it, 
	  or contribute to one of the many forums that may be discussing a topic you are interested in. <br>
	  Make new friends and increase your confidence and skill.
	   </p>


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
		<a id="reg_link" href="register">Register</a>
		
	
	</div>	

</div>
