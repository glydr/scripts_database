<?php
/* @var $user User */
$user = $request->getObject('user');
$is_admin = ($user->getIs_admin() == 1);
$is_ccl_writer = ($user->getIs_ccl_writer() == 1);
$pending = $request->getObject('pending');
?>
<?php include 'common_header.php'; ?>

<form name="user_edit" action="index.php" method="POST">
    <input type="hidden" name="type" value="user_edit" />
    <input type="hidden" name="user_id" value="<?php echo $user->getId(); ?>" />
    
        <div id="reportInfo" class="panel panel-info" style="padding-bottom: 20px;">
            <div class="panel-heading"><h3>User Information</h3></div>
            <div class="panel-body">
            <div class="reportRow">
                <div class="tlabel">Display Name:</div>
                <div class="data"><?php echo $user->getDisplay_name(); ?></div>
            </div>

            <div class="reportRow">
                <div class="tlabel">LDAP UserName:</div>
                <div class="data"><?php echo $user->getLdap_username(); ?></div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">Cerner UserName:</div>
                <div class="data"><?php echo $user->getCerner_username(); ?></div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">Email Address:</div>
                <div class="data"><?php echo $user->getEmail(); ?></div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">Administrator:</div>
                <div class="data">
                    <?php   if ($is_admin) {
                                echo 'Yes';
                            } else {
                                echo 'No';
                            }
                    ?>
                    -- Allows user the ability to edit and add users to the system.
                </div>
            </div>
            
            <div class="reportRow">
                <div class="tlabel">CCL Writer:</div>
                <div class="data">
                    <?php   if ($is_ccl_writer) {
                                echo 'Yes';
                            } else {
                                echo 'No';
                            }
                    ?>
                    -- Allows user to edit report information.
                </div>
            </div>
            
        </div>
    <div id="buttonRow">
        <input type="submit" name="edit" value="Edit" />    
    </div>
    </div>
    
</form>

<?php include 'pending_items_view.php'; ?>

<?php include 'common_footer.php'; ?> 