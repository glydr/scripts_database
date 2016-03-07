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
            
        <div style="padding-bottom:20px;" id="reportInfo" class="panel panel-info">
            <div class="panel-heading"><h3>User Information</h3></div>
            <div class="panel-body">
            <span class="required">&nbsp;*&nbsp;</span> = Required
            <div class="reportRow">
                <div class="tlabel">&nbsp;</div>
                <div class="data">
                    <?php if (isset($error)) echo $error; ?>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">Display Name:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="text" class="form-control text" name="display_name"
                           value="<?php echo $user->getDisplay_name(); ?>"/>
                </div>
            </div>

            <div class="reportRow">
                <div class="tlabel">LDAP UserName:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="text" class="form-control text" name="ldap_username"
                           value="<?php echo $user->getLdap_username(); ?>"/>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">Cerner UserName:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="text" class="form-control text" name="cerner_username"
                           value="<?php echo $user->getCerner_username(); ?>"/>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">Email Address:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <input type="text" class="form-control text" name="email"
                           value="<?php echo $user->getEmail(); ?>"/>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">Administrator:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <label style="font-weight: normal;">
                    <input style="float:left;padding-right: 2px !important;" type="checkbox" class="checkbox" name="is_admin"
                           <?php if ($is_admin) echo ' checked'; ?>/>
                    <span style="padding-left:10px;">Allows user the ability to edit and add users to the system.</span>
                    </label>
                </div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">CCL Writer:<span class="required">&nbsp;*&nbsp;</span></div>
                <div class="data">
                    <label style="font-weight:normal;">
                    <input style="float:left;padding-right: 2px !important;" type="checkbox" class="checkbox" name="is_ccl_writer"
                           <?php if ($is_ccl_writer) echo ' checked'; ?>/>
                    <span style="padding-left:10px;">Allows user to edit report information.</span>
                    </label>
                </div>
            </div>
            
        </div>
    <div id="buttonRow">
        <p></p>
        <input type="submit" name="submit" value="Submit" />    
    </div>
    </div>
    
</form>

<?php include 'pending_items_view.php'; ?>

<?php include 'common_footer.php'; ?> 