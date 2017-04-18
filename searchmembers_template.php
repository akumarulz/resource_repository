<<<<<<< HEAD
<h1>Search Members</h1>
<div class="resource_side_div">

	<div class="resource_panel">
	<h3>Search Options</h3>
		<form id = "forum_search" class="resource_search_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'&page=searchmembers');?>" method="GET">
			<label for="firstname">Firstname:</label><br>
			<input id="firstname" type="text" name="search[firstname]" value="<?php if(isset($criteria['search']['firstname'])) echo $criteria['search']['firstname']; ?>" /><br><br>
			
			<label for="surname">Surname: </label><br>
				<input id="surname" type="input" name="search[surname]" value="<?php if(isset($criteria['search']['surname'])) echo $criteria['search']['surname']; ?>" autocomplete="off" />			
					
					<br><br><label for="school">School: </label><br>
				<input id="school" type="input" name="search[school]" value="<?php if(isset($criteria['search']['school'])) echo $criteria['search']['school']; ?>" autocomplete="off" />			
					
					<br><br><label for="location">Location: </label><br>
				<input id="location" type="input" name="search[location]" value="<?php if(isset($criteria['search']['location'])) echo $criteria['search']['location']; ?>" autocomplete="off" />			
					
					<?php if($is_admin =='Y'){
						$checked = (isset($criteria['search']['blocked'])) ? 'checked' : '';
						echo '<br><label for="blocked">Blocked From Site</label><input id="blocked" type="checkbox" name="search[blocked]" value="1" '.$checked.'/><br>'; 
					
					}
					?>
					<label for="blockedrequests">Blocked Friend Requests</label><input id="blockedrequests" type="checkbox" name="search[blockedrequests]" <?php if(isset($criteria['search']['blockedrequests'])) echo 'checked'; ?> />
					<br><br>Results per Page: <br>
					<input id="step" type="number" name="search[numResult]" min="1" max="100" step="1" value="<?php if (isset($criteria['search']['numResult'])) {echo $criteria['search']['numResult'];} else {echo 5;} ?>" /><br><br>

				<input id="asc" type="hidden" name="search[asc]" value="" />
				<input class="submit" type="submit" />
				
		</form>
	</div>


</div>

<div class="resource_main_div">
<h2>Results</h2>
<?php

echo $pageCtrl;

		if(sizeof($members) > 0){
			 foreach ($members as $member){
				 $unblock='';
				 $middle = ($member['middle_name'] !='' ) ? substr($member['middle_name'],0,1): '';
				 $profilepic = ($member['profilePic']=='' ) ? 'images/Profileavatar.png' : 'data:image/jpeg;base64,'.base64_encode($member['profilePic']) ;
				 
				 foreach($blockedRequests as $blockedRequest){
					 //var_dump($blockedRequest);
					if ($blockedRequest['from_user_id'] == $member['user_id']){
						$unblock = '<p><button class="unblock" id="'.$member['user_id'].'-'.$blockedRequest['id'].'" >Unblock</button>  this members friend request</p>';
					}
				 }
				 
				 echo '<div class="displaymembers">
				 <a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=profile&user_id='.$member['user_id'].'"><img class="profileavatar" src="'.$profilepic.'" alt="profile picture" />
				<p><b>'.$member['title'].' '.ucfirst(strtolower($member['first_name'])).' '.ucfirst($middle).' '.ucfirst(strtolower($member['surname'])).'</b><br> '.$member['school_name'].'<br>'.ucfirst(strtolower($member['location'])).'</p></a>
				'.$unblock.'
				</div>';
			} 
		}else{
			echo 'No Results Found';
		}
?>
=======
<h1>Search Members</h1>
<div class="resource_side_div">

	<div class="resource_panel">
	<h3>Search Options</h3>
		<form id = "forum_search" class="resource_search_form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'&page=searchmembers');?>" method="GET">
			<label for="firstname">Firstname:</label><br>
			<input id="firstname" type="text" name="search[firstname]" value="<?php if(isset($criteria['search']['firstname'])) echo $criteria['search']['firstname']; ?>" /><br><br>
			
			<label for="surname">Surname: </label><br>
				<input id="surname" type="input" name="search[surname]" value="<?php if(isset($criteria['search']['surname'])) echo $criteria['search']['surname']; ?>" autocomplete="off" />			
					
					<br><br><label for="school">School: </label><br>
				<input id="school" type="input" name="search[school]" value="<?php if(isset($criteria['search']['school'])) echo $criteria['search']['school']; ?>" autocomplete="off" />			
					
					<br><br><label for="location">Location: </label><br>
				<input id="location" type="input" name="search[location]" value="<?php if(isset($criteria['search']['location'])) echo $criteria['search']['location']; ?>" autocomplete="off" />			
					
					<?php if($is_admin =='Y'){
						$checked = (isset($criteria['search']['blocked'])) ? 'checked' : '';
						echo '<br><label for="blocked">Blocked From Site</label><input id="blocked" type="checkbox" name="search[blocked]" value="1" '.$checked.'/><br>'; 
					
					}
					?>
					<label for="blockedrequests">Blocked Friend Requests</label><input id="blockedrequests" type="checkbox" name="search[blockedrequests]" <?php if(isset($criteria['search']['blockedrequests'])) echo 'checked'; ?> />
					<br><br>Results per Page: <br>
					<input id="step" type="number" name="search[numResult]" min="1" max="100" step="1" value="<?php if (isset($criteria['search']['numResult'])) {echo $criteria['search']['numResult'];} else {echo 5;} ?>" /><br><br>

				<input id="asc" type="hidden" name="search[asc]" value="" />
				<input class="submit" type="submit" />
				
		</form>
	</div>


</div>

<div class="resource_main_div">
<h2>Results</h2>
<?php

echo $pageCtrl;

		if(sizeof($members) > 0){
			 foreach ($members as $member){
				 $unblock='';
				 $middle = ($member['middle_name'] !='' ) ? substr($member['middle_name'],0,1): '';
				 $profilepic = ($member['profilePic']=='' ) ? 'images/Profileavatar.png' : 'data:image/jpeg;base64,'.base64_encode($member['profilePic']) ;
				 
				 foreach($blockedRequests as $blockedRequest){
					 //var_dump($blockedRequest);
					if ($blockedRequest['from_user_id'] == $member['user_id']){
						$unblock = '<p><button class="unblock" id="'.$member['user_id'].'-'.$blockedRequest['id'].'" >Unblock</button>  this members friend request</p>';
					}
				 }
				 
				 echo '<div class="displaymembers">
				 <a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=profile&user_id='.$member['user_id'].'"><img class="profileavatar" src="'.$profilepic.'" alt="profile picture" />
				<p><b>'.$member['title'].' '.ucfirst(strtolower($member['first_name'])).' '.ucfirst($middle).' '.ucfirst(strtolower($member['surname'])).'</b><br> '.$member['school_name'].'<br>'.ucfirst(strtolower($member['location'])).'</p></a>
				'.$unblock.'
				</div>';
			} 
		}else{
			echo 'No Results Found';
		}
?>
>>>>>>> origin/master
</div>