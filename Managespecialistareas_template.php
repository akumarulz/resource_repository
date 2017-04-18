<<<<<<< HEAD
<h3>Manage Specialist Areas</h3>
	<div class="manageSpecialistareas" >
		<span><?php if (isset($reply))echo $reply; ?></span>

			
			<fieldset>
				<legend>Edit Text</legend>
				<p>Edit the text displayed for a choosen subject.</p>
				<form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=Managespecialistareas');?>" method="POST">
					<label>Edit Subject: </label>
						<?php if(isset($specialist_subjects)){ $subject = new specialist_subjectsobj($specialist_subjects); echo $subject->getHTML();}?>
						<br><input id="selectedOption" type="text" name = "specialist_area[specialist_area]" value="<?php if (isset($editsubject)) echo $editsubject; ?>" maxlength="100" required />*<br><br>
					<input type="submit" name="specialist_area[edit]" value="Edit" />
				</form>
				
			</fieldset>
		
			<fieldset>
				<legend>Remove Specialist Area</legend>
					<p>Remove a selectable Specialist subject</p>
					<p><b>Only subjects that DO NOT have a resource linked to them can be removed</b></p>
						<form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=Managespecialistareas');?>" method="POST">
					<label>Remove Subject: </label><br>
						<?php if(isset($specialist_subjects)){ $subject = new specialist_subjectsobj($specialist_subjects); echo $subject->getHTML();}?>
						<br><br>
					<input type="submit" name="specialist_area[remove]" value="Remove"/>
				</form>
				
				
			</fieldset>
			
			<fieldset>
				<legend>Add Specialist Area</legend>
					<p>Add a selectable Specialist subject</p>
						<form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=Managespecialistareas');?>" method="POST">
					<label>Add Subject: </label>
						<br><input type="text" name = "specialist_area[specialist_area]" value="<?php if (isset($addsubject)) echo $addsubject; ?>" maxlength="100" required />*<br>
						<br>
					<input type="submit" name="specialist_area[add]" value="Add"/>
				</form>
				
				
			</fieldset>
		
		<p>* 100 character limit</p>
	</div>
=======
<h3>Manage Specialist Areas</h3>
	<div class="manageSpecialistareas" >
		<span><?php if (isset($reply))echo $reply; ?></span>

			
			<fieldset>
				<legend>Edit Text</legend>
				<p>Edit the text displayed for a choosen subject.</p>
				<form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=Managespecialistareas');?>" method="POST">
					<label>Edit Subject: </label>
						<?php if(isset($specialist_subjects)){ $subject = new specialist_subjectsobj($specialist_subjects); echo $subject->getHTML();}?>
						<br><input id="selectedOption" type="text" name = "specialist_area[specialist_area]" value="<?php if (isset($editsubject)) echo $editsubject; ?>" maxlength="100" required />*<br><br>
					<input type="submit" name="specialist_area[edit]" value="Edit" />
				</form>
				
			</fieldset>
		
			<fieldset>
				<legend>Remove Specialist Area</legend>
					<p>Remove a selectable Specialist subject</p>
					<p><b>Only subjects that DO NOT have a resource linked to them can be removed</b></p>
						<form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=Managespecialistareas');?>" method="POST">
					<label>Remove Subject: </label><br>
						<?php if(isset($specialist_subjects)){ $subject = new specialist_subjectsobj($specialist_subjects); echo $subject->getHTML();}?>
						<br><br>
					<input type="submit" name="specialist_area[remove]" value="Remove"/>
				</form>
				
				
			</fieldset>
			
			<fieldset>
				<legend>Add Specialist Area</legend>
					<p>Add a selectable Specialist subject</p>
						<form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=Managespecialistareas');?>" method="POST">
					<label>Add Subject: </label>
						<br><input type="text" name = "specialist_area[specialist_area]" value="<?php if (isset($addsubject)) echo $addsubject; ?>" maxlength="100" required />*<br>
						<br>
					<input type="submit" name="specialist_area[add]" value="Add"/>
				</form>
				
				
			</fieldset>
		
		<p>* 100 character limit</p>
	</div>
>>>>>>> origin/master
	