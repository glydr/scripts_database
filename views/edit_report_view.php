<?php

/* @var $session Session */
$report = $request->getObject('report');
$version = $request->getObject('version');
$user = $request->getObject('user');
$ministry = $request->getObject('ministry');
$audiences = $request->getObject('audiences');
$selected_audiences = $request->getObject('selected_audiences');
$executed_froms = $request->getObject('executed_froms');
$selected_executed_froms = $request->getObject('selected_executed_from');
        

?>
<?php include 'common_header.php'; ?>

<form class="marginize" name="edit_report" action="index.php" method="POST">

    <input type="hidden" name="type" value="update_report" />
    <input type="hidden" name="script_id" value="<?php echo $report->getId(); ?>" />
    <input type="hidden" name="version_id" value="<?php echo $version->getId(); ?>" />

    <div id="reportInfo" class="panel panel-default" style="margin-bottom: 20px;">
        <div class="panel-heading"><h3>Report Information</h3></div>
        <div class="panel-body">
        <div style="display:block;padding-bottom:50px;"><span class="required">&nbsp;*&nbsp;</span> = Required</div>

        <div class="reportRow">
            <div class="tlabel">Object Name:</div>
            <div class="data"><?php echo $report->getObject_name(); ?></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Title:<span class="required">&nbsp;*&nbsp;</span></div>
            <div class="data"><input type="text" class="form-control text" name="title" 
                                     value="<?php echo $report->getTitle(); ?>"/></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Target Audience:<span class="required">&nbsp;*&nbsp;</span></div>
            <div class="data">
                <ul>
                <?php foreach ($audiences as $audience): ?>
                    <?php $checked = $report->getAudiences()->containsObject($audience); ?>
                    <li><input type="checkbox" name="target[]" 
                               value="<?php echo $audience->getId(); ?>" 
                               <?php if ($checked) echo ' checked'; ?>
                               /><?php echo $audience->getDescription(); ?></li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Executed From:<span class="required">&nbsp;*&nbsp;</span></div>
            <div class="data">
                <ul>
                <?php foreach ($executed_froms as $executing): ?>
                    <?php $checked = in_array($executing->getid(), $selected_executed_froms); ?>
                    <li><input type="checkbox" name="execution[]" 
                               value="<?php echo $executing->getId(); ?>"
                               <?php if ($checked) echo ' checked'; ?> 
                               /><?php echo $executing->getDescription(); ?></li>
                <?php endforeach; ?>
                </ul>                    
            </div>
        </div>

        <div class="reportRow">
            <div class="tlabel">SN Task #:</div>
            <div class="data"><input type="text" class="form-control text" name="sn_num" 
                                     value="<?php echo $report->getSn_task_num(); ?>"/></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Ministry:</div>
            <div class="data"><?php echo $ministry->getName(); ?></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Description:<span class="required">&nbsp;*&nbsp;</span></div>
            <div class="data">
                <textarea class="form-control" name="description"><?php echo $report->getDescription(); ?></textarea>
            </div>
        </div>
    </div>
    </div>

    
    <div id="versionInfo" class="panel panel-default" style="margin-bottom:20px; padding-bottom: 20px;">
        <div class="panel-heading"><h3>Version Information</h3></div>
        <div class="panel-body">
        <div class="reportRow">
            <div class="tlabel">Version Number:</div>
            <div class="data"><?php echo $version->getSeq(); ?></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Source Location:<span class="required">&nbsp;*&nbsp;</span></div>
            <div class="data"><input class="form-control text" type="text" name="source_path"
                value="<?php echo $version->getSource_name(); ?>"
                /></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Begin Effective Date:</div>
            <div class="data"><?php echo $version->getBeg_eff_dt_tm(); ?></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">User:</div>
            <div class="data"><?php echo $user->getDisplay_name(); ?></div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Description:<span class="required">&nbsp;*&nbsp;</span></div>
            <div class="data">
                <textarea class="form-control" name="version_description"><?php echo $version->getVersion_info(); ?></textarea>
            </div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Tables used:</div>
            <div class="data">
                <ul>
                    <?php foreach ($version->getTables() as $table): ?>
                    <li><?php echo $table->getName(); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="reportRow">
            <div class="tlabel">Source Code:</div>
            <div class="data">
                <a href="index.php?type=view_source&version_id=<?php echo $report->getLastVersion()->getId(); ?>"
                   target="_blank">Click here to view source code for this version</a>
            </div>
        </div>
    </div>
    <div id="buttonRow">
        <p></p>
        <input type="submit" name="submit" value="Submit" />    
    </div>
    </div>

    

</form>

<?php include 'common_footer.php'; ?> 