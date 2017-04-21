<h1>Your Personal Summary</h1>
<form id="Form" action="insertWorkHistory.php" method="POST" >
	<input type = "hidden" name="work[userid]" value="<?php echo $userid?>" />
		<fieldset class ="profileEdit">
					<legend>Edit personal Summary</legend>
				<textarea  id="personalSummaryForm" name="personalSummary[summary]" cols="100" rows="10"><?php if(isset($personalSummary)) echo $personalSummary; ?></textarea><br><br>
				<input type="submit">
				<div class="tooltip tooltip_wh"><img src="images/questionmark.png" alt="a question mark for a tool tip"/> <span class="tooltiptext">Describe what you are into, the years of students you teach and your experience with teaching computing. </span></div>
			
		</fieldset>
</form>