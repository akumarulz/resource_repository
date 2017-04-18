
  <script src="jquery-ui-1.12.1/jquery-ui.min.js"></script>
  

<div class="login_div">
	<?php
    $legend = (isset($member)) ? 'Edit Personal Details' : 'Registration Form';
    $formsubmission = (isset($member)) ? 'PersonalDetailsEdit' : 'register';
    
    ?>
    
        <h1>Register on Teacher Share</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"].'?page='.$formsubmission.'');?>" method="POST">
        <div class="col-left">
            <label>Title</label><select name="user[title]">
            <option value="Mr" <?php if (isset($member) && $member->getTitle() == 'Mr') {
                echo 'selected';
} ?> >Mr</option>
            <option value="Mrs" <?php if (isset($member) && $member->getTitle() == 'Mrs') {
                echo 'selected';
} ?> >Mrs</option>
            <option value="Miss" <?php if (isset($member) && $member->getTitle() == 'Miss') {
                echo 'selected';
} ?> >Miss</option>
            <option value="Ms" <?php if (isset($member) && $member->getTitle() == 'Ms') {
                echo 'selected';
} ?>>Ms</option>
    <option value="Dr" <?php if (isset($member) && $member->getTitle() == 'Dr') {
                echo 'selected';
} ?> >Dr</option>
                <option value="Prof" <?php if (isset($member) && $member->getTitle() == 'Prof') {
                echo 'selected';
} ?> >Prof</option>
            </select>
            <br>
            <br><label for="fname">Firstname</label><input id="fname" type="text" name="user[first_name]" 
            value="<?php if (isset($user['first_name'])) {
                echo $user['first_name'];
} if (isset($member)) {
    echo $member->getFirstname();
}?>" required maxlength="255" /> <br>
            <br>
            <label for="sname">Middle name (optional)</label><input id="sname" type="text" name="user[middle_name]" 
            value="<?php if (isset($user['middle_name']) != null) {
                echo $user['middle_name'];
} if (isset($member)) {
    echo $member->getMiddlename();
}?>" maxlength="255" /><br>
            <br>
            <label for="mname">Surname</label><input id="mname" type="text" name="user[surname]" 
            value="<?php if (isset($user['surname'])) {
                echo $user['surname'];
} if (isset($member)) {
    echo $member->getSurname();
}?>" required maxlength="255"  /><br>
            <br>
            <label for="email">E-mail</label><input id="email" type="text" name="user[email]" 
            value="<?php if (isset($user['email'])) {
                echo $user['email'];
} if (isset($member)) {
    echo $member->getEmail();
} ?>" required maxlength="255" /><br>
            </div>
            <div class="col-right">
            <label for="location">School Location</label><input id="location" type="text" name="user[location]" 
            value="<?php if (isset($user['location'])) {
                echo $user['location'];
} if (isset($member)) {
    echo $member->getLocation();
}?>" required maxlength="255" /> <br>
            <br>
            <label for="school">School</label><input id="school" type="text" name="user[school_name]" 
            value="<?php if (isset($user['school_name'])) {
                echo $user['school_name'];
} if (isset($member)) {
    echo $member->getSchool();
}?>" required maxlength="255" /> <br>
            <br>
                <?php if (isset($member)) {
                    echo '<p>To change your password please enter the new password below, other wise leave blank.</p>';
}?>
            <label for="pw">Password</label><input id="pw" type="password" name="user[password]" 
            value="<?php if (isset($user['password'])) {
                echo $user['password'];
}?>" <?php if (!isset($member)) {
    echo 'required maxlength="255"';
} ?> /> <br>
            <br>
            <label for="ckpw">Re-enter Password</label><input id="ckpw" type="password" <?php if (!isset($member)) {
                echo 'required maxlength="255"';
} ?>  /> <img class="confirmPw" src="images/cross.png" alt="password confirmation image"/><br>
                </div>
            <input id="checker" type="hidden" name="user[checker]" value="" />
            <?php
            if (isset($member)) {
                echo '<input type="hidden" name="user[user_id]" value="'.$member->getUser_id().'" />';
            }?>
            
            <br>
            <input type="submit" <?php if (isset($member)) {
                echo 'value="Edit Details" name="Edit"';
} ?> />
        </form>
</div>
<?php if (!isset($member)) {
    echo'<p>*After successfully registering, please confirm your account by following the link sent to your email. 
		you will not be able to sign in untill your account is confirmed</p>';
}?>
    <span><?php if (isset($response)) {
        echo $response;
}?></span>
<!--add checked for matching passwords-->