<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<?php if ($pending && $pending->count() > 0): ?>
	<div id="reportInfo" class="editReportSection">
		<h2>Pending Report Notifications</h2>
		<p>This user has the following report notifications pending entry of an email address
		for this user.</p>

		<div class="reportRow">
			<div class="tlabel">Object Name</div>
			<div class="data"></div>
		</div>
		<div class="reportRow">
			<ul class="pendingItems">
			<?php foreach ($pending as $item): ?>
				<li><a href="index.php?type=edit_report&id=<?php echo $item->getReport_id(); ?>&version=<?php echo $item->getVersion_seq(); ?>">
					<?php echo $item->getObject_name(); ?></a></li>
			<?php endforeach; ?>
			</ul>
		</div>
		
	</div>
<?php endif; ?>