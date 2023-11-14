<?php
include('EntityClassLib.php');
// have to include the class defintion before session start
session_start();

if (!isset($_SESSION['loggedIn'])) {
    header("Location: Login.php");
    exit();
} else {
    if (isset($_SESSION['studentLoggedIn'])) {
        // Recreate the object after including the class definition
        $studentLoggedIn = $_SESSION['studentLoggedIn'];
        $studentName = $studentLoggedIn->getName();
    }
}
?>

<?php include("./common/header.php"); ?>

<div class="mt-2 display-6">
    <?php 
        global $studentName;
        echo "Hi $studentName!";
    ?>
</div>

<?php include('./common/footer.php'); ?>