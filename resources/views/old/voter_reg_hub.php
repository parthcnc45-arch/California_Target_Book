<?php require('includes/config.php');

//if not logged in redirect to login page
User::authenticate();

//define page title
$title = 'Voter Registration';
$page = $title;

$user = User::findById($_SESSION['memberID']);
$user->track($page);

//include header template
require('layout/header.php');
?>

<div class="container">

    <?php include('includes/loggedin_bar.php'); ?>

    <?php include('includes/navbar.php'); ?>


</div>

<?php
//include header template
require('layout/footer.php');
?>
