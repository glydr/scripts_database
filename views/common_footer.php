<?php

?>
<script type="text/javascript">
var metadataCount = <?php if(isset($_SESSION['metadataCount'])) {echo json_encode($_SESSION['metadataCount']);} else{echo 0;} ?>;
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