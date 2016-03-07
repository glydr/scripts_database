<?php

?>
<script type="text/javascript">
var metadataCount = <?php if(isset($_SESSION['metadataCount'])) {echo json_encode($_SESSION['metadataCount']);} else{echo 0;} ?>;
if(metadataCount > 0) {
	$('#metadataDiv').text(metadataCount);
} else {
	$('#metadataListItem').remove();
}

</script>
<div style="padding-bottom: 30px;""
    </body>
</html>