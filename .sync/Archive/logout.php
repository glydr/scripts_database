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
</script>
<div style="margin-left:20px;">
<h2>You are now logged out.</h2>
<a href="login.php">Login
</div></a>

<?php include './views/common_footer.php'; ?>
