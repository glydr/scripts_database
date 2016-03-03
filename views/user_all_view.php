<?php

$users = $request->getObject('users');
$userCount = 0;

?>

<?php include 'common_header.php'; ?>

<div class="searchBox">
    <h2>All Users</h2>
    <table id="allUsers">
        <tr class="tHead">
            <td>Cerner Username</td>
            <td>Display Name</td>
            <td>Active Ind</td>
            <td>Requests Pending Email Address</td>
        </tr>
        
        <?php foreach ($users as $user): ?>
        <tr <?php if($userCount % 2 == 0) {echo " style='background-color:#e5ffff;'";} $userCount++; ?>>
            <td><?php echo $user->getCerner_username(); ?></td>
            <td style="width:250px;"><a href="index.php?type=user_view&user_id=<?php echo $user->getId(); ?>">
                <?php echo $user->getDisplay_name(); ?></a></td>
            <td class="active"><?php echo $user->getActive_ind(); ?></td>
            <td class="count"><?php echo $pending[$user->getId()]; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <a href="index.php?type=new_user">Add New User</a>
	<br><br>
	<a href="ExtractMonitor.php">Manually Run Extract Script</a>
    
</div>



<?php include 'common_footer.php'; ?> 