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
<div id="logoContainer">
    <img src="./images/ascension-logo-sm.png" />
</div>
<div id="loginOuterContainer">
<form id="login" action="./controllers/LoginController.php" method="POST">
    
    <input type="hidden" name="redirect_type" value="<?php echo $redirect_type; ?>" />
    <input type="hidden" name="redirect_user_id" value="<?php echo $redirect_user_id; ?>" />
    <input type="hidden" name="redirect_report_id" value="<?php echo $redirect_report_id; ?>" />
    <input type="hidden" name="redirect_version_id" value="<?php echo $redirect_version_id; ?>" />
    
    <div id="loginContainer">       
        <?php if ($hasError): ?>
        <div class="loginError">
            <div class="errorText">Either your username or your password is incorrect.</div>
        </div>
        <?php endif; ?>
        
        <p>
            <label>Username:<br />
                <input type="text" name="username" id="username" value=""  />
            </label>
            <label>Password:<br />
                <input id="password" type="password" value="" name="password">
            </label>
        </p>
        <p>
            <button id="submitButton" data-theme="a" data-mini="true" type="submit">Login</button>
        </p>
        <p id="visitorLogin">No account?  <a style="cursor:pointer;" id="visitorLoginLink">Login as a Visitor</a></p>
    </div>
</form>
</div>
<?php include './views/common_footer.php'; ?>
<script type="text/javascript">
    $('body').css('background-color', '#F1F1F1');

    $('#visitorLoginLink').click(function() {
        $('#loginContainer').toggle("fast", function() {
        $('#username').attr('value','visitor');
        $('#password').attr('value','visitor');
        $('#submitButton').click();
    });


    });
</script>