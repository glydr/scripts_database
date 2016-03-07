<?php

?>

<?php include 'common_header.php'; ?>

    <div id="reportInfo" class="panel panel-default" style="margin-bottom: 20px;">
        <div class="panel-heading"><h3>Report Information</h2></div>
        <div class="panel-body">
        <div class="reportRow">
            <div class="tlabel">Object Name:</div>
            <div class="data"><?php echo $report->getObject_name(); ?></div>
        </div>
        
        <div class="reportRow">
            <div class="tlabel">Title:</div>
            <div class="data"><?php echo $report->getTitle(); ?></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Target Audience:</div>
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
            <div class="tlabel">Executed From:</div>
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
            <div class="tlabel">SN Task #:</div>
            <div class="data"><?php echo $report->getSn_task_num(); ?></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Ministry:</div>
            <div class="data"><?php echo $ministry->getName(); ?></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Description:</div>
            <div class="data">
                <p><?php echo $report->getDescription(); ?></p>
            </div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Latest Version:</div>
            <div class="data">
                    Version <?php echo $report->getLastVersion()->getSeq(); ?>
            </div>
        </div>
    </div>
    </div>

    <!-- Latest Version Section -->
    <?php include 'version_view_inner.php'; ?>

    <!-- All Version Section -->
    <div id="reportInfo" class="panel panel-info">
        <div class="panel-heading"><h3>All Versions</h3></div>
        <div class="panel-body">
        <table class="allversions">

            <tr class="headRow">
                <td>Seq</td>
                <td>Beg Eff Date</td>
                <td>User</td>
                <td style="width:250px;">Description</td>
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
                            <?php echo substr($version->getBeg_eff_dt_tm(),0,10); ?>
                        </a>
                    </td>
                    <td><?php echo $user->getDisplay_name(); ?></td>
                    <td><?php echo $short_desc; ?></td>
                    <td><a href="index.php?type=view_source&version_id=<?php echo $version->getId(); ?>">View</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    </div>
        
<?php include 'common_footer.php'; ?>    

