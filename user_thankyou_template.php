
<?php

$redirect = (isset($page)) ? $page : 'login';

?>
<script>
	$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "<?php echo $_SERVER["PHP_SELF"].'?page='.$redirect; ?>";
    }, 4000);
});
</script>
<div class="confirm_box">
	<?php echo $response = (isset($reply)) ? '<p>'.$reply.'</p>' : '<p>Thank you</p>'; ?>
    <?php $image = (!isset($resend))? 'images/tick_16.png': 'images/stop.png'; ?>
    <img src="<?php echo $image?>" alt="confirmation tick" />
    <?php if(isset($resend)) echo '<a href ="'.$resend.'" class="resend" ><p>RESEND?</p></a>'; ?>
</div>