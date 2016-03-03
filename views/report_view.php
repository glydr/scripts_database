<?php

?>

<?php include 'common_header.php'; ?>

    <div id="reportInfo" class="editReportSection marginize">
        <h2>Report Information</h2>

        <div class="reportRow">
            <div class="label">Object Name:</div>
            <div class="data"><?php echo $report->getObject_name(); ?></div>
        </div>
        
        <div class="reportRow">
            <div class="label">Title:</div>
            <div class="data"><?php echo $report->getTitle(); ?></div>
        </div>

        <div class="reportRow">
            <div class="label">Target Audience:</div>
            <div class="data">
                <ul>
                <?php foreach ($audiences as $audience): ?>
                    <?php if ($audience): ?>
                    <li><?php echo $audience->getDescription(); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="reportRow">
            <div class="label">Executed From:</div>
            <div class="data">
                <ul>
                <?php foreach ($executed_froms as $executing): ?>
                    <?php if ($executing): ?>
                    <li><?php echo $executing->getDescription(); ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>                    
            </div>
        </div>

        <div class="reportRow">
            <div class="label">SN Task #:</div>
            <div class="data"><?php echo $report->getSn_task_num(); ?></div>
        </div>

        <div class="reportRow">
            <div class="label">Ministry:</div>
            <div class="data"><?php echo $ministry->getName(); ?></div>
        </div>

        <div class="reportRow">
            <div class="label">Description:</div>
            <div class="data">
                <p><?php echo $report->getDescription(); ?></p>
            </div>
        </div>

        <div class="reportRow">
            <div class="label">Latest Version:</div>
            <div class="data">
                    Version <?php echo $report->getLastVersion()->getSeq(); ?>
            </div>
        </div>

    </div>

    <!-- Latest Version Section -->
    <?php include 'version_view_inner.php'; ?>

    <!-- All Version Section -->
    <div id="reportInfo" class="editReportSection">
        <h2>All Versions</h2>

        <table class="allversions">

            <tr class="headRow">
                <td>Seq</td>
                <td>Beg Eff Date</td>
                <td>User</td>
                <td>Description</td>
                <td>Source</td>
            </tr>

            <?php foreach ($report->getVersions() as $version): ?>
            <?php   
                $user = $userMapper->find($version->getUser_id());
                $user_display = '';
                if ($user) {
                    $user_display = $user->getDisplay_name();
                }
                $short_desc = substr($version->getVersion_info(), 0, 50);
            ?>
                <tr>
                    <td><?php echo $version->getSeq(); ?></td>
                    <td>
                    <a title="Click to see version info" 
                       href="index.php?type=version_view&version_id=<?php echo $version->getId(); ?>">
                            <?php echo $version->getBeg_eff_dt_tm(); ?>
                        </a>
                    </td>
                    <td><?php echo $user->getDisplay_name(); ?></td>
                    <td><?php echo $short_desc; ?></td>
                    <td><a href="index.php?type=view_source&version_id=<?php echo $version->getId(); ?>">Click to see source</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
        
<?php include 'common_footer.php'; ?>    

