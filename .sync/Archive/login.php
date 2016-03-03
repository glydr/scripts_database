<?php
session_start();

require_once './config.php';

// Setup common vars
$db = new Database(HOST, USER, PASS, DATABASE);
$db->connect();
$session = new Session();

// Check for any redirect info
$redirect_type = '';
$redirect_user_id = '';
$redirect_report_id = '';
$redirect_version_id = '';
if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
    switch ($_GET['redirect']) {
        case 'user_edit':
            if (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
                $redirect_type = 'user_edit';
                $redirect_user_id = $_GET['user_id'];
            }
            break;
        case 'edit_report':
            if (isset($_GET['id']) && !empty($_GET['id']) &&
                isset($_GET['version']) && !empty($_GET['version'])) {
                $redirect_type = 'edit_report';
                $redirect_report_id = $_GET['id'];
                $redirect_version_id = $_GET['version'];
            }
            break;
    }
}
    
// Check for errors
$hasError = false;
if (isset($_GET['error']) && !empty($_GET['error'])) {
    $hasError = true;
}

?>
<?php include './views/common_header.php'; ?>

<form id="login" action="./controllers/LoginController.php" method="POST">
    
    <input type="hidden" name="redirect_type" value="<?php echo $redirect_type; ?>" />
    <input type="hidden" name="redirect_user_id" value="<?php echo $redirect_user_id; ?>" />
    <input type="hidden" name="redirect_report_id" value="<?php echo $redirect_report_id; ?>" />
    <input type="hidden" name="redirect_version_id" value="<?php echo $redirect_version_id; ?>" />
    
    <div id="loginContainter">
        <h2>Ascension Knowledge Repository</h2>
        
        <?php if ($hasError): ?>
        <div class="loginError">
            <img src="./images/exclamation.png" alt="Error on login" />
            <div class="errorText">Either your username or your password is incorrect.</div>
        </div>
        <?php endif; ?>
        
        <div class="login-control-left">
            <div class="loginText">Username:</div>
            <div class="loginText">Password:</div>
        </div>
        <div class="login-control-right">
            <input type="text" name="username" id="username" value=""  />
            <input id="password" type="password" value="" name="password">
        </div>
        <div class="login-control-full">
            <button data-theme="a" data-mini="true" type="submit">Login</button>
        </div>
        <br>
        <br>
        <h3>Visitors</h3>
        <p>If you would like to sign in and just view the site you can use the following login:</p>
        &nbsp;&nbsp;&nbsp;&nbsp;<span class="bold">Username:&nbsp;</span>visitor<br>
        &nbsp;&nbsp;&nbsp;&nbsp;<span class="bold">Password:&nbsp;</span>visitor
    </div>
</form>

<?php include './views/common_footer.php'; ?>