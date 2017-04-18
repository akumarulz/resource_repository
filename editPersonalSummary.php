<h1>Your Personal Summary</h1>
<form id="Form" action="insertWorkHistory.php" method="POST" >
	<input type = "hidden" name="work[userid]" value="<?php echo $userid?>" />
		<fieldset class ="profileEdit">
					<legend>Edit personal Summary</legend>
				<textarea  id="personalSummaryForm" name="personalSummary[summary]" cols="100" rows="10"><?php if(isset($personalSummary)) echo $personalSummary; ?></textarea><br><br>
				<input type="submit">
		</fieldset>
</form>