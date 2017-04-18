<h1>Manage Members</h1>
<span><?php if (isset($reply)) echo $reply;?></span>
	<fieldset class="ManageMembers" >
	<legend>Manage Members</legend>
		<fieldset>
		
			<legend>Block A Memeber: </legend>
					<p>1. To block a Member from a discussion select the area you wish to block them from</p> 
					<form id="blockusers" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page=ManageUsers');?>" method="POST">
					<input id ="currentadmin" type="hidden" value ="<?php echo $adminid; ?>" />
					<input id="confirmblock" type="hidden" value="0" name="block[confirmblock]" />
					<input id="confirmuser" type="hidden" value="0" name="block[confirmuser]"/>
						<label for="topic">A Forum Topic: </label><input id="topic" type="radio" name="block[searchtype]" value = "topic_id" checked /><br>
						<label for="resource">A Resource Discussion: </label><input id="resource" type="radio" name="block[searchtype]" value="resource_id" /><br>
						<label for="all">Block From Site: </label><input id="all" type="radio" name="block[searchtype]" value="all" /><br>
			</fieldset>
			<br><p>OR</p>
			<fieldset>
		
				<legend>Undo Block: </legend>
					<p>1. To Unblock a Member, select the area you wish to allow them to access again </p>
					<label for="backinTopic">Allow back in Topic: </label><input id="backinTopic" type="radio" name="block[searchtype]" value="backinTopic" /><br>
					<label for="backinResource">Allow back in Resource: </label><input id="backinResource" type="radio" name="block[searchtype]" value="backinResource" /><br>
					<label for="bringback">Allow back on site: </label><input id="bringback" type="radio" name="block[searchtype]" value="bringback" /><br><br>
			</fieldset>
			
			<fieldset>
			<legend>Enter Details:</legend>
				<p>2. Enter the title of the resource or the forum topic to exclude the member from</p><br>
				<label for="Rid">Title of Topic or Resource discussion: </label><br><br><!--<input id="Rid" type="number" name ="block[id]" value="" />-->
				<input type="text" id="Rid" value="" autocomplete = "off"/>
				<input type="hidden" id="RidID" name="block[id]" value="" /><br>
				<ul id="liveresourceSearch" class="liveresourceSearch" ></ul>
				
					
				<p>3. Enter the name of the member</p>
				<label for="searchName">Enter Name: <label><br><input id="searchName" type="text"  autocomplete = "off" /><br>
				<input id="searchID" type ="hidden" value="" name="block[user]"/>
					<ul id="livesearch" class="livesearch"></ul>
				<!--<span id="userid"></span><br>
				<span id="username"></span><br>--><br>
				
				<input type="submit" />
			</fieldset>
		</form>	
	</fieldset>