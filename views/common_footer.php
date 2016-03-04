<?php

?>
<script type="text/javascript">
try {
	var metadataCount = <?php echo $_SESSION['metadataCount'];?>;
} catch(err) {
	$('#metadataListItem').remove();
}
if(metadataCount > 0) {
	$('#metadataDiv').text(metadataCount);
} else {
	$('#metadataListItem').remove();
}

</script>
  
    </body>
</html>