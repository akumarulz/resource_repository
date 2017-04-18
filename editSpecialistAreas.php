<<<<<<< HEAD
<h1>Your Specialist Areas</h1>
<form id="Form" action="insertWorkHistory.php" method="POST" >
<input type = "hidden" name="work[userid]" value="<?php echo $userid?>" />
	<fieldset class ="profileEdit">
				<legend>Edit Specialist areas</legend>
			<?php if(isset($specialistSubjects)){
				//get the list of subjects that the user has selected
				$subject = new subjects_listObj($specialistSubjects,$user_subjects);
				echo $subject->getHTML();
			}
			?>
			<input type="submit" >
	</fieldset>
=======
<h1>Your Specialist Areas</h1>
<form id="Form" action="insertWorkHistory.php" method="POST" >
<input type = "hidden" name="work[userid]" value="<?php echo $userid?>" />
	<fieldset class ="profileEdit">
				<legend>Edit Specialist areas</legend>
			<?php if(isset($specialistSubjects)){
				//get the list of subjects that the user has selected
				$subject = new subjects_listObj($specialistSubjects,$user_subjects);
				echo $subject->getHTML();
			}
			?>
			<input type="submit" >
	</fieldset>
>>>>>>> origin/master
</form>