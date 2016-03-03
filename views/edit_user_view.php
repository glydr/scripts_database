<?php
/* @var $user User */
$action = $request->getObject('action');
$user = $request->getObject('user');
$is_admin = ($user->getIs_admin() == 1);
$is_ccl_writer = ($user->getIs_ccl_writer() == 1);
$error = $request->getObject('error');
$pending = $request->getObject('pending');
?>
<?php include 'common_header.php'; ?>

<form name="user_edit" action="index.php" method="POST">
    <input type="hidden" name="type" value="<?php echo $action; ?>" />
    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>" />
    
    <span class="required">&nbsp;*&nbsp;</span> = Required
            
        <div id="reportInfo" class="editReportSection">
            <h2>User Information</h2>

            <div class="reportRow">
                <div class="label">&nbsp;</div>
                <div class="data">
                    <?php if (isset($error)) echo $error; ?>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="label">Display Name:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="text" class="text" name="display_name"
                           value="<?php echo $user->getDisplay_name(); ?>"/>
                </div>
            </div>

            <div class="reportRow">
                <div class="label">LDAP UserName:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="text" class="text" name="ldap_username"
                           value="<?php echo $user->getLdap_username(); ?>"/>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="label">Cerner UserName:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="text" class="text" name="cerner_username"
                           value="<?php echo $user->getCerner_username(); ?>"/>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="label">Email Address:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="text" class="text" name="email"
                           value="<?php echo $user->getEmail(); ?>"/>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="label">Administrator:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="checkbox" class="checkbox" name="is_admin"
                           <?php if ($is_admin) echo ' checked'; ?>/>
                    Allows user the ability to edit and add users to the system.
                </div>
            </div>
            
            <div class="reportRow">
                <div class="label">CCL Writer:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="checkbox" class="checkbox" name="is_ccl_writer"
                           <?php if ($is_ccl_writer) echo ' checked'; ?>/>
                    Allows user to edit report information.
                </div>
            </div>
            
        </div>
    <div id="buttonRow">
        <p></p>
        <input type="submit" name="submit" value="Submit" />    
    </div>
    
</form>

<?php include 'pending_items_view.php'; ?>

<?php include 'common_footer.php'; ?> 