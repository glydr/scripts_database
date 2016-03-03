<div class="searchBox">
	<form name="search" action="index.php" method="GET">
    <div class="input-group">
      <input type="hidden" name="type" value="search" />
      <input type="text" name="searchFor" class="form-control" placeholder="Search for...">
      <span class="input-group-btn">
        <input type="submit" name="search" value="Search" class="btn btn-default" />
      </span>
    </div>
    <div id="advancedSearchMenu">
    	<div id="advancedSearchMenuLink" style="cursor:pointer;">
    		<span id="advancedArrow" class="glyphicon glyphicon-menu-right btn-xs" aria-hidden="true"></span>
    		Advanced
    	</div>
    	<div id="advancedSearchMenuContent" style="display:none;">
    	Search only...
    	<ul>
    		<li><input type='checkbox' name='advancedSearchList' value='table' />Table</li>
    		<li><input type='checkbox' name='advancedSearchList' value='reportdesc' />Report Description</li>
    		<li><input type='checkbox' name='advancedSearchList' value='tabledesc' />Table Description</li>
    	</ul>
    	</div>
    </div>
    </form>
</div>

<script type="text/javascript">
    $("#advancedSearchMenuLink").click(function() {
    	$("#advancedArrow").toggleClass("glyphicon-menu-right");
    	$("#advancedArrow").toggleClass("glyphicon-menu-down");
    	$("#advancedSearchMenuContent").toggle("fast");
    })
</script>