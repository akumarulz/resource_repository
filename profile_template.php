<<<<<<< HEAD
<script src="js.cookie.js"></script>
<?php if($visitor === $userid) echo '<h1>Your Profile</h1>'; ?>
<div class="profile_div">
	

<div class="profile_detail_div">
	
		<?php
		if($visitor != $userid){
			echo '<a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=message&user_id='.$userid.'"><h3>'.$Name.'</h3></a>';
		}elseif($visitor === $userid){
			
			if(isset($Name)) echo '<h3>'.$Name.'</h3>';
		}
		
		?>
		<h5><?php if(isset($location)) echo $location;?></h5>
		
		<?php if ($visitor === $userid) echo'<form action="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=PersonalDetailsEdit').'" method="POST"><input type="hidden" value="'.$userid.'" name="userid"/> <label class = "formlabel" >Edit Personal details</label><br><input type="submit" value="Edit"/> </form>';?>
		<?php if($visitor != $userid){echo '<a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=makereport&source=offender&id='.$userid.'"><p>Report Member</p></a>';}?>
		
		<fieldset class="profile_fieldset_aboutYou">
		<legend>Personal Summary</legend>
		<p><?php if (isset($personalSummary)) echo $personalSummary; ?></p><br>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile');?>" method="POST">
			<?php if($visitor === $userid)echo'<input class="submit" type="submit" name="edit" value="Edit Summary" />';?>
		</form>
	</fieldset>
		
		<fieldset class="profile_fieldset">
	<legend>Work History :</legend>
	
	
	
	
	<!--<div class="profile_work_history">-->
		<?php 
		if(sizeof($workHistoryArray) > 0){
		
			$history = new workhistoryObj();
			$history->setHistory($workHistoryArray);
			$history->setUser($userid);
			$history->setVisitor($visitor);
			echo $history->getHTML();
				
		}else{
			echo '<p>None</p>';
		}
				?>
	<!--</div>	-->	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile');?>" method="POST">
			<?php if($visitor === $userid)echo'<input class="submit" type="submit" name="edit" value="Add Work history" />';?>
		</form>
			
	</fieldset>
	
		<fieldset class = "Interest_areas_div">
		<legend>Interest Areas :</legend>
		<?php  
		if($interestSubjects[0]['specialist_area'] != null){
			
			
			$interests = new specialist_areaObj($interestSubjects);
			echo $interests->getHTML();
			
		}else{
			echo '<p>None</p>';
		}
		?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile');?>" method="POST" >
		
		<?php if($visitor === $userid)echo'<input class="submit" type="submit" name="edit" value="Edit Interests" /> ';?>
		</form>
		</fieldset>
		
</div>
<img id="profileavatar_profile_page" src="<?php $chk = substr($profilePic,0,6); if($chk == 'images' ){ echo $profilePic;}else{echo 'data:image/jpeg;base64,'.base64_encode($profilePic);} ?>" alt="a profile picture" />

		
		
			<?php
			$id = (isset($userid)) ? $userid : '';
			
			if($visitor === $userid){echo'<form id="imgForm"  method="post" enctype="multipart/form-data" ><label>Upload Picture:</label> <input type="file" name="profile[img]" id="imgUpload" /> 
			<input type="hidden" id="userid" value="'.$id.'" /><input type="submit" value="Upload" /></form>';}
			else{
				echo '<form id="friendrequest" action="friendrequest.php" method="POST">
				<input type="hidden" name="request[user_id]" value="'.$visitor.'-'.$userid.'" />
				<label for="friendresponse" >Friend Request</label><input id="friendresponse" type="submit" name="request[request]" value="request" /> 
				</form>'; 
			}
			
			
			?>		
		
		<span id="imgReply"></span>

</div>
=======
<script src="js.cookie.js"></script>
<?php if($visitor === $userid) echo '<h1>Your Profile</h1>'; ?>
<div class="profile_div">
	

<div class="profile_detail_div">
	
		<?php
		if($visitor != $userid){
			echo '<a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=message&user_id='.$userid.'"><h3>'.$Name.'</h3></a>';
		}elseif($visitor === $userid){
			
			if(isset($Name)) echo '<h3>'.$Name.'</h3>';
		}
		
		?>
		<h5><?php if(isset($location)) echo $location;?></h5>
		
		<?php if ($visitor === $userid) echo'<form action="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=PersonalDetailsEdit').'" method="POST"><input type="hidden" value="'.$userid.'" name="userid"/> <label class = "formlabel" >Edit Personal details</label><br><input type="submit" value="Edit"/> </form>';?>
		<?php if($visitor != $userid){echo '<a href="'.htmlspecialchars($_SERVER["PHP_SELF"]).'?page=makereport&source=offender&id='.$userid.'"><p>Report Member</p></a>';}?>
		
		<fieldset class="profile_fieldset_aboutYou">
		<legend>Personal Summary</legend>
		<p><?php if (isset($personalSummary)) echo $personalSummary; ?></p><br>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile');?>" method="POST">
			<?php if($visitor === $userid)echo'<input class="submit" type="submit" name="edit" value="Edit Summary" />';?>
		</form>
	</fieldset>
		
		<fieldset class="profile_fieldset">
	<legend>Work History :</legend>
	
	
	
	
	<!--<div class="profile_work_history">-->
		<?php 
		if(sizeof($workHistoryArray) > 0){
		
			$history = new workhistoryObj();
			$history->setHistory($workHistoryArray);
			$history->setUser($userid);
			$history->setVisitor($visitor);
			echo $history->getHTML();
				
		}else{
			echo '<p>None</p>';
		}
				?>
	<!--</div>	-->	
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile');?>" method="POST">
			<?php if($visitor === $userid)echo'<input class="submit" type="submit" name="edit" value="Add Work history" />';?>
		</form>
			
	</fieldset>
	
		<fieldset class = "Interest_areas_div">
		<legend>Interest Areas :</legend>
		<?php  
		if($interestSubjects[0]['specialist_area'] != null){
			
			
			$interests = new specialist_areaObj($interestSubjects);
			echo $interests->getHTML();
			
		}else{
			echo '<p>None</p>';
		}
		?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=editProfile');?>" method="POST" >
		
		<?php if($visitor === $userid)echo'<input class="submit" type="submit" name="edit" value="Edit Interests" /> ';?>
		</form>
		</fieldset>
		
</div>
<img id="profileavatar_profile_page" src="<?php $chk = substr($profilePic,0,6); if($chk == 'images' ){ echo $profilePic;}else{echo 'data:image/jpeg;base64,'.base64_encode($profilePic);} ?>" alt="a profile picture" />

		
		
			<?php
			$id = (isset($userid)) ? $userid : '';
			
			if($visitor === $userid){echo'<form id="imgForm"  method="post" enctype="multipart/form-data" ><label>Upload Picture:</label> <input type="file" name="profile[img]" id="imgUpload" /> 
			<input type="hidden" id="userid" value="'.$id.'" /><input type="submit" value="Upload" /></form>';}
			else{
				echo '<form id="friendrequest" action="friendrequest.php" method="POST">
				<input type="hidden" name="request[user_id]" value="'.$visitor.'-'.$userid.'" />
				<label for="friendresponse" >Friend Request</label><input id="friendresponse" type="submit" name="request[request]" value="request" /> 
				</form>'; 
			}
			
			
			?>		
		
		<span id="imgReply"></span>

</div>
>>>>>>> origin/master
