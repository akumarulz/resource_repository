<div class="viewReportdiv">
	<p>Submission date: <?php echo date( 'H:i l jS M Y',strtotime($report['date'])) ?> </p>
	<p>Report ID: <?php echo $report['report_id']; ?> </p>
	
	<p>Submitted by: <b><?php echo ucfirst(strtolower($report_submitting_user['first_name'])).' '.ucfirst(strtolower($report_submitting_user['surname'])); ?></b></p>
	
	<p>About: <b><?php echo $about; ?></b></p>
		<div>
			<h3>Member Concern</h3>
			<p><?php echo $report['reason']; ?></p>
		</div>
		
			<div class="reportResultsdiv">
				<h4>Entries</h4>
					
						<?php 
						$array = explode('$$',$report['result']);
						foreach($array as $entry){
							echo '<p>'.$entry.'</p>';
						}
						?>
				
			</div>

	<?php if($delt_by !=''){}else{
		
		echo '<form id="reportinput" class="reportupdate" action="reportEnrtyUpdate.php" method="POST">
		<input type="hidden" name="update[report_id]" value="'.$report['report_id'].'" />
		<input type="hidden" name="update[admin]" value="'.$adminid.'" />
		<textarea name="update[result]" cols="100" rows="5" ></textarea><br>
		<label>Submit entry into the report </label>
		<input type="submit" />
	</form>
	<br><hr>';
	}

	$str = null;
	switch($type){
		case "Offender": $str = 'Block member '.$about.' from the site and close the report.'; break;
		case "Topic": $str = 'Block all users from forum topic '.$about.' and close the report.'; break;
		case "Resource": $str = 'Delete resource '.$about.' and block all users from discussion and close the report.'; break;
	}

	 if($delt_by !=''){
		echo '<p>Report has been dealt with and is now closed.</p>';
	}else{
		echo '<br><p class="reportCloseforms">'.$str.'</p><form class = "reportresolve" action="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=reportresolution').'" method="POST">
	<input type="hidden" name="report[report_id]" value="'.$report['report_id'].'" />
	<input type="hidden" name="report[user_id]" value = "'.$adminid.'" />
	<input type="hidden" name="report[reported_id]" value="'.$id.'"/>
	<input type="hidden" name="report[type]" value="'.$type.'" />
	<input type="submit" value="Confirm" name="report[close]" />
	</form><hr>';

	echo'<br><p>Close report</p><form class = "reportresolve" action="'.htmlspecialchars($_SERVER["PHP_SELF"].'?page=reportresolution').'" method="POST">
		<input type="hidden" name="report[report_id]" value="'.$report['report_id'].'" />
		<input type="hidden" name="report[user_id]" value = "'.$adminid.'" />
		<input type="submit" name="report[close]" value="Close" />
		</form>';
	} 
	?>



</div>