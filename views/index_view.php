<?php include 'common_header.php'; ?>
<div id="meat">
<div id="metaDataAlert" class="text-center hidden alert alert-info alert-dismissible fade in" role="alert">
    <button id="dismiss_button" type="button" class="close" data-dismiss="alert" aria-label="Dismiss"><span aria-hidden="true">&times;</span></button>
    <strong>Heads up!  You have reports missing metadata.  Please use the list below to update your reports as appropriate.</strong>
</div>
<?php include 'search_view.php'; ?>  
<div id="filterMenuContainer">  
    <a href="#tableBox" id="tableLink">Browse by Table</a>    
    <a href="#targetBox" id="targetLink">Browse by Target Audience</a>    
    <a href="#metaBox" id="metadataLink">Please Add Metadata</a>
</div>
<div style="display:none;">
<div class="filterBox" id="tableBox" style="">
    <ul>
    <?php foreach ($tableCollection as $table): ?>
        <li><a href="index.php?type=search&filter=table&searchFor=<?php echo $table->getName(); ?>"><?php echo $table->getName(); ?></a></li>
    <?php endforeach; ?>
    </ul>
</div>
<div class="filterBox" id="targetBox">
    <ul>
    <?php foreach ($targetCollection as $target): ?>
        <li>
            <a href="index.php?type=search&filter=target&searchFor=<?php echo $target->getDescription(); ?>">
            <?php echo $target->getDescription() . ' (' . $target->getCount() . ')'; ?>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>
</div>
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
<span class="stretch"></span>
</div> <!--#meat-->
<?php include 'common_footer.php'; ?>  

<script type="text/javascript">
    $(document).ready(function() {
        if($("#metaBox.filterBox ul li").length && Cookies.get('meta_alert') != 1) {
            $("#metaDataAlert").fadeIn(1500);
            $("#metaDataAlert").removeClass("hidden");
        }
        $("#tableLink").colorbox({inline:true, width:"50%", opacity:1});
        $("#targetLink").colorbox({inline:true, width:"50%"});
        $("#metadataLink").colorbox({inline:true, width:"50%"});
    });

    $("#dismiss_button").click(function() {
        Cookies.set('meta_alert','1', {expires:1,path:'/'});
    })
</script>