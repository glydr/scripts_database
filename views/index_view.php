<?php include 'common_header.php'; ?>
<div id="meat">

<?php include 'search_view.php'; ?>  
<p style="font-style: italic; width:100px;margin:auto;padding-bottom: 20px;font-size: 22px;">or...</p>
<div id="filterMenuContainer">
    <ul class="nav nav-pills nav-justified">
        <li class="active"><a data-toggle='pill' href="#tableBox">Browse by Table</a></li>
        <li><a data-toggle='pill' href="#targetBox">Browse by Target Audience</a></li> 
    </ul>
</div>
<div class="tab-content">
    <div style="width:45%;margin:auto;padding-bottom: 10px;"><input class="form-control" placeholder="Filter..." type="text" onkeyup="filter(this)" /></div>
    <div class="filterBox tab-pane fade in active" id="tableBox">
        <ul class="list">
        <?php foreach ($tableCollection as $table): ?>
            <li><a href="index.php?type=search&filter=table&searchFor=<?php echo $table->getName(); ?>"><?php echo $table->getName(); ?></a></li>
        <?php endforeach; ?>
        </ul>
    </div>
    <div class="filterBox tab-pane fade" id="targetBox">
        <ul class="list">
        <?php foreach ($targetCollection as $target): ?>
            <li>
                <a href="index.php?type=search&filter=target&searchFor=<?php echo $target->getDescription(); ?>">
                <?php echo $target->getDescription() . ' (' . $target->getCount() . ')'; ?>
                </a>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>
</div> <!--#meat-->
<?php include 'common_footer.php'; ?>  

<script type="text/javascript">
    $(document).ready(function() {
    });

    function filter(element) {
        var value = $(element).val().toUpperCase();

        $(".list > li").each(function() {
            if ($(this).text().toUpperCase().search(value) > -1) {
                $(this).show();
            }
            else {
                $(this).hide();
            }
        });
    }

</script>