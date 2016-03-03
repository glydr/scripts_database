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
    
        <div id="reportInfo" class="editReportSection">
            <h2>User Information</h2>

            <div class="reportRow">
                <div class="label">Display Name:</div>
                <div class="data"><?php echo $user->getDisplay_name(); ?></div>
            </div>

            <div class="reportRow">
                <div class="label">LDAP UserName:</div>
                <div class="data"><?php echo $user->getLdap_username(); ?></div>
            </div>
            
            <div class="reportRow">
                <div class="label">Cerner UserName:</div>
                <div class="data"><?php echo $user->getCerner_username(); ?></div>
            </div>
            
            <div class="reportRow">
                <div class="label">Email Address:</div>
                <div class="data"><?php echo $user->getEmail(); ?></div>
            </div>
            
            <div class="reportRow">
                <div class="label">Administrator:</div>
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
                <div class="label">CCL Writer:</div>
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
        <p></p>
        <input type="submit" name="edit" value="Edit" />    
    </div>
    
</form>

<?php include 'pending_items_view.php'; ?>

<?php include 'common_footer.php'; ?> 