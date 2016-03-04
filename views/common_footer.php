<?php

?>
<script type="text/javascript">
var metadataCount = <?php echo $session->getMetadataCount()?>;
if(metadataCount > 0) {
	$('#metadataDiv').text(metadataCount);
	$('#metadataListItem div a').animate({
		left: '200px',
		color: '#FF0000'
	}, 3000, 'linear');
} else {
	$('#metadataListItem').remove();
}

</script>
  
    </body>
</html>