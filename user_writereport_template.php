<fieldset class="ReportformFieldset">
	<legend>Report Form</legend>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=makereport');?>" method="POST">
		<p><b>Necessary Fields Are Completed For You</b></p>
		<p>Please indication what or whom this report is concerning.</p>
		<label>A Topic: <label><input  type="radio" name="report[type]" value="Topic" <?php if(isset($type) && $type =='Topic') echo 'checked';  ?>  onclick="return false;" /> 
		<br><label >A Resource: <label><input  type="radio" name="report[type]" value="Resource" <?php if(isset($type) && $type =='Resource') echo 'checked'; ?>  onclick="return false;" /> 
		<br><label >A Member: <label><input  type="radio" name="report[type]" value="Offender" <?php if(isset($type) && $type =='Offender') echo 'checked'; ?> onclick="return false;" /> <br><br>
		<p>Please complete the appropriate fields</p> 
		
		<!--whos making the report-->
				
		<label>Title <label><br><input type="text" name="report[title]" value="<?php if(isset($resourceTitle)) echo $resourceTitle; ?>" readonly /><br>
		<input type="hidden" name="report[id]"  value="<?php if(isset($resource_id)) echo $resource_id; ?>" />
		<label >Name: <label><br><input  type="text" name="report[offender]" value ="<?php if(isset($offender)) echo $offender; ?>" autocomplete = "off" readonly/><br>
		<input id="searchID" type ="hidden" value="<?php if(isset($offender_id)) echo $offender_id; ?>" name="report[user_id]"/>
				<!--<div id="livesearch"></div>-->
		<label for="6">Please write your concern:<label><br><textarea id="6" name="report[reason]" cols="50" rows="10" maxlength="2000" ><?php if(isset($reason)) echo $reason; ?></textarea><br>
		<p>2000 Character limit</p>
		<br>
		<input type="submit" />
	</form>
	<span><?php if(isset($errormsg)) echo $errormsg; ?></span>
</fieldset>