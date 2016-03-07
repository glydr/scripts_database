<?php

$users = $request->getObject('users');
$userCount = 0;

?>

<?php include 'common_header.php'; ?>

<div class="panel panel-info searchBox">
    <div class="panel-heading"><h3>All Users</h3></div>
    <div class="panel-body">
    <div style="padding-bottom:15px;"><input id="searchInput" class="form-control" placeholder="Filter..." type="text" /></div>
    <table id="allUsers">
        <thead>
        <tr class="tHead">
            <td>Cerner Username</td>
            <td>Display Name</td>
            <td>Active Ind</td>
            <td>Requests Pending Email Address</td>
        </tr>
        <thead>
        <tbody id="fbody">
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user->getCerner_username(); ?></td>
            <td style="width:250px;"><a href="index.php?type=user_view&user_id=<?php echo $user->getId(); ?>">
                <?php echo $user->getDisplay_name(); ?></a></td>
            <td class="active"><?php echo $user->getActive_ind(); ?></td>
            <td class="count"><?php echo $pending[$user->getId()]; ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    
    <a href="index.php?type=new_user">Add New User</a>
	<br><br>
	<a href="ExtractMonitor.php">Manually Run Extract Script</a>
    </div>
</div>



<?php include 'common_footer.php'; ?> 

<script type="text/javascript">

$("#searchInput").keyup(function () {
    //split the current value of searchInput
    var data = this.value.toUpperCase().split(" ");
    //create a jquery object of the rows
    var jo = $("#fbody").find("tr");
    if (this.value == "") {
        jo.show();
        return;
    }
    //hide all the rows
    jo.hide();

    //Recusively filter the jquery object to get results.
    jo.filter(function (i, v) {
        var $t = $(this);
        for (var d = 0; d < data.length; ++d) {
            if ($t.text().toUpperCase().indexOf(data[d]) > -1) {
                return true;
            }
        }
        return false;
    })
    //show the rows that match.
    .show();
}).focus(function () {
    this.value = "";
    $(this).css({
        "color": "black"
    });
    $(this).unbind('focus');
}).css({
    "color": "#C0C0C0"
});

</script>