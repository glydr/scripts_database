<?php

$title = $request->getObject('title');
$report_id = $request->getObject('report_id');
$version = $request->getobject('version');
$user = $request->getObject('user'); 
$user_display = '';
if ($user) {
    $user_display = $user->getDisplay_name();
}
?>
<div id="reportInfo" class="editReportSection">
    <h2><?php echo $title; ?></h2>

    <div class="reportRow">
        <div class="label">Version Number:</div>
        <div class="data"><?php echo $version->getSeq(); ?></div>
    </div>

    <div class="reportRow">
        <div class="label">Source Location:</div>
        <div class="data"><?php echo $version->getSource_name(); ?></div>
    </div>

    <div class="reportRow">
        <div class="label">Begin Effective Date:</div>
        <div class="data"><?php echo $version->getBeg_eff_dt_tm(); ?></div>
    </div>

    <div class="reportRow">
        <div class="label">User:</div>
        <div class="data"><?php echo $user_display; ?></div>
    </div>

    <div class="reportRow">
        <div class="label">Description:</div>
        <div class="data">
            <p><?php echo $version->getVersion_info(); ?></p>
        </div>
    </div>

    <div class="reportRow">
        <div class="label">Tables used:</div>
        <div class="data">
            <ul>
                <?php foreach ($version->getTables() as $table): ?>
                <li><?php echo $table->getName(); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <div class="reportRow">
        <div class="label">Source Code:</div>
        <div class="data">
            <a href="index.php?type=view_source&version_id=<?php echo $version->getId(); ?>">Click here to view source code for this version</a>
        </div>
    </div>

    <?php if ($session->getIs_ccl_writer()): ?>
    <div class="reportRow">
        <div class="label">Edit Info:</div>
        <div class="data">
            <a href="index.php?type=edit_report&id=<?php echo $report_id; ?>&version=<?php echo $version->getSeq(); ?>">Edit</a>
        </div>
    </div>
    <?php endif; ?>

</div>
