
	<h1>Your Work History</h1>
	<form id="Form" action="insertWorkHistory.php" method="POST" >
		<fieldset class ="profileEdit">
			<legend>Add to work history</legend>
			<input type = "hidden" name="work[userid]" value="<?php echo $userid?>" />
			<label>Establishment: </label><input id="est" type="text" name="work[establishment]" value="" />
			<label>From Date: </label><input id="frm" type="date" name="work[workFrom]" value="" />
			<label>To Date: </label><input id="to" type ="date" name="work[workTo]" value="" />
			<label>Current:<label><input id="cur" type="checkbox" name="work[current]" value="current" />
		<input type="submit" />
		</fieldset >	
		
	</form>
	<span id="output"></span>

