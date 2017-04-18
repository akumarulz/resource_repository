<<<<<<< HEAD
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesSheet.css" />
		<link rel="stylesheet" href="jquery/jRating.jquery.css" type="text/css" />
		<script src="js.cookie.js"></script>	
		<script src="jquery-3.1.1.js"></script>
		<script src="ascript.js" ></script>
		<script src="jquery/jRating.jquery.js"></script>
		
	</head>

	<body>
		<header class="navbar">
		<li class ="navLogo"><img class="navLogo" src="images/logo.png" alt="loggo picture" /></li>
			<div class="nav"> 
				<ul>
					<?php if ($logged_in){
						
						echo '<li class="dropdown"><a href="summary">Home</a></li>
						<li class="dropdown"><a href ="resources"> Resources</a>
							<div class="dropdown-content">
								<a href="resources">Search</a>
								<a href="upLoadResource">Upload Resource</a>
								<a href="linkresource_upload">Submit Link Resource</a>
							</div>
						</li>
					
					
						<li class="dropdown"><a href="message">Connections</a>
							<div class ="dropdown-content">
								
								<a href="message">Private Message</a>
								<a href="searchmembers">Search Members</a>
							</div>
						</li>

						<li class="dropdown"><a href="message">Forums</a>
							<div class ="dropdown-content">
								<a href="forums">Forum</a>
								<a href="newtopic">New topic</a>
								
							</div>
						</li>
											
						<li class="dropdown"><a href="profile">Profile</a>
							<div class="dropdown-content">
								<a href="profile">View</a>
								<a href="myresources">MY Resources</a>
								</div>
						</li>
					
					
						<li class="dropdown"><a href="#">Help</a>
							<div class="dropdown-content">

								</div>
						</li>';
						
					if($is_admin=='Y')
					{		echo '<li class="dropdown"><a href="#">Admin</a>
							<div class="dropdown-content">
								<a href="Reports">Reports</a>
								<a href="ManageUsers">Manage Users</a>
								<a href="Managespecialistareas">Manage Specialist Areas</a>
							</div>
						
						</li>
							</ul>
			</div>';
					}
						echo '<div class="log"><a href="logout">logout</a></div>';
					}else{
						echo '<li class="dropdown"><a href="login">login</a></li>';
					}
					?>
			
		
		</header>
		
		<main id="main">
			<?php echo $content; ?>
		</main>
		
		
	</body>	
=======
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="stylesSheet.css" />
		<link rel="stylesheet" href="jquery/jRating.jquery.css" type="text/css" />
		<script src="js.cookie.js"></script>	
		<script src="jquery-3.1.1.js"></script>
		<script src="ascript.js" ></script>
		<script src="jquery/jRating.jquery.js"></script>
		
	</head>

	<body>
		<header class="navbar">
		<li class ="navLogo"><img class="navLogo" src="images/logo.png" alt="loggo picture" /></li>
			<div class="nav"> 
				<ul>
					<?php if ($logged_in){
						
						echo '<li class="dropdown"><a href="summary">Home</a></li>
						<li class="dropdown"><a href ="resources"> Resources</a>
							<div class="dropdown-content">
								<a href="resources">Search</a>
								<a href="upLoadResource">Upload Resource</a>
								<a href="linkresource_upload">Submit Link Resource</a>
							</div>
						</li>
					
					
						<li class="dropdown"><a href="message">Connections</a>
							<div class ="dropdown-content">
								
								<a href="message">Private Message</a>
								<a href="searchmembers">Search Members</a>
							</div>
						</li>

						<li class="dropdown"><a href="message">Forums</a>
							<div class ="dropdown-content">
								<a href="forums">Forum</a>
								<a href="newtopic">New topic</a>
								
							</div>
						</li>
											
						<li class="dropdown"><a href="profile">Profile</a>
							<div class="dropdown-content">
								<a href="profile">View</a>
								<a href="myresources">MY Resources</a>
								</div>
						</li>
					
					
						<li class="dropdown"><a href="#">Help</a>
							<div class="dropdown-content">

								</div>
						</li>';
						
					if($is_admin=='Y')
					{		echo '<li class="dropdown"><a href="#">Admin</a>
							<div class="dropdown-content">
								<a href="Reports">Reports</a>
								<a href="ManageUsers">Manage Users</a>
								<a href="Managespecialistareas">Manage Specialist Areas</a>
							</div>
						
						</li>
							</ul>
			</div>';
					}
						echo '<div class="log"><a href="logout">logout</a></div>';
					}else{
						echo '<li class="dropdown"><a href="login">login</a></li>';
					}
					?>
			
		
		</header>
		
		<main id="main">
			<?php echo $content; ?>
		</main>
		
		
	</body>	
>>>>>>> origin/master
</html>