<?php
if(isset($metaDataCollection) && $metaDataCollection != "") {
    foreach ($metaDataCollection as $metaItem): 
        $session->setMetadataCount($session->getMetadataCount() + 1);
    endforeach; 
} 
?>
<script type="text/javascript">
var metadataCount = <?php echo json_encode($session->getMetadataCount());?>;
if(metadataCount > 0) {
	$('#metadataDiv').text(metadataCount);
} else {
	$('#metadataListItem').remove();
}

</script>
<div style="padding-bottom: 30px;""
    </body>
</html>