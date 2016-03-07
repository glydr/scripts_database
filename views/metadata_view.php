<?php include 'common_header.php';
?>
<div style="width:50%;margin:auto;" class="panel panel-default">
<div class="panel-heading"><h3>Reports Needing Review</h3></div>

<div class="panel-body">
<div class="filterBox" id="metaBox">
    <ul>
        <?php 
        if($metaDataCollection != "") {
            foreach ($metaDataCollection as $metaItem): ?>
                <li><a href="index.php?type=edit_report&id=<?php echo $metaItem->getId();?>&version=<?php echo $metaItem->getVersion_id();?>">
                <?php echo $metaItem->getName();?>
                </a>
            </li>
        <?php endforeach; } ?>
    </ul>
</div>
</div>
</div>
<?php include 'common_footer.php'; ?>