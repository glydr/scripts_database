<?php
            if(isset($metaDataCollection) && $metaDataCollection != "") {
                foreach ($metaDataCollection as $metaItem): 
                    $session->setMetadataCount($session->getMetadataCount() + 1);
                endforeach; } 
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ascension Knowledge Repository</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="./css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="./css/bootstrap-theme.css" />
        <link rel="stylesheet" type="text/css" href="./css/edit_report.css" />
        <link rel="stylesheet" type="text/css" href="./css/main.css" />
        <link href="http://10.8.46.131/favicon.ico" type="image/x-icon" rel="icon" />
        <script language="JavaScript" type="text/JavaScript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script language="JavaScript" type="text/JavaScript" src="./js/js.cookie.js"></script>
        <script language="JavaScript" type="text/JavaScript" src="./js/jquery.validate.js"></script>
        <script language="JavaScript" type="text/JavaScript" src="./js/edit_report.js"></script>
        <script language="JavaScript" type="text/JavaScript" src="./js/edit_user.js"></script>
        <script language="JavaScript" type="text/JavaScript" src="./js/bootstrap.js"></script>
        
    </head>
    <body class="wrapper">
        
        <div id="pageHeader">
            <a href="http://northwestregion.ascensionhealth.org/scripts_database/beta/"><img src="./images/logo.png" /></a>
            <h1>Ascension Knowledge Repository</h1>
            <div id="menuContainer">
                <ul>
                        <?php
                            if (isset($_SESSION['my_person_id'])) {?>
                                <li>
                                    <div class="menuItem">
                                        <?php echo "Welcome, " . $_SESSION['my_name'];     ?>                   
                                    </div>
                                </li>
                            <?php } ?>

                        <?php if (isset($_SESSION['my_person_id']) && $session->getIs_admin() == 1) { ?>
                            <li>
                                <div class="menuItem"><a href="index.php?type=user_view_all">Admin</a></div>
                            </li>
                        <?php } ?>
                            <li id="metadataListItem">
                                <div class="menuItem"><a href="index.php?type=metadata">Add Metadata</a> <span id="metadataOuter">[<span id="metadataDiv"></span>]</span></div>
                            </li>
                            <li><div class="menuItem" id="loginOutLink">
                        <?php
                            if (isset($_SESSION['my_person_id'])) {
                                echo('<a href="logout.php">Logout</a>');
                            }
                            else {
                                echo('<a href="login.php">Login</a>');
                            }
                        ?>
                        </div>
                    </li>
                </ul>
            </div>
        </div>