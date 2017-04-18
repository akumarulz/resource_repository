
<?php

$redirect = (isset($page)) ? $page : 'login';

?>
<script>
	$(document).ready(function () {
    // Handler for .ready() called.
    window.setTimeout(function () {
        location.href = "<?php echo $_SERVER["PHP_SELF"].'?page='.$redirect; ?>";
    }, 5000);
});
</script>
<div class="confirm_box">
	<?php echo $response = (isset($reply)) ? '<p>'.$reply.'</p>' : '<p>Thank you</p>'; ?>
    <img src="images/tick_16.png" alt="confirmation tick" />
</div>