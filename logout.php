<?php
session_start();
require_once './config.php';
$session = new Session();
unset($_SESSION);
session_destroy();
?>
<?php include './views/common_header.php'; ?>

<script type="text/JavaScript">
Cookies.remove('meta_alert', {path:'/'});
setTimeout(function(){
	window.location.replace("./index.php");
}, 3000);
</script>
<div style="position:relative;top:200px;text-align:center;width:400px;margin:auto;">
<h2>You are now logged out.</h2>
<p>You will be redirected to the login page in a few seconds.  <br /><br /><a href="./index.php">Click Here</a> if you are not automatically redirected</p>
</div></a>

<?php include './views/common_footer.php'; ?>
