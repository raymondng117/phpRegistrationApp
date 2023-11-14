<?php
session_start();
include('Functions.php');

if (isset($_SESSION['loggedIn'])) {
    header('Location:Logout.php');
    exit();
}

// data persistence 
if (isset($_POST['submit'])) {
    //studentId
    $studentId = $_POST['studentId'];
    $studentIdError = ValidateStudentId($studentId);
    $_SESSION['studentId'] = $studentId;

    //password 
    $password = $_POST['password'];
    $passwordError = ValidatePasswordForLogin($password);
    $_SESSION['password'] = $password;

    if (!$studentIdError && !$passwordError) {
        try {
            $studentLoggedIn = getStudentByIdAndPassword($studentId, $password);
            if ($studentLoggedIn) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['studentLoggedIn'] = $studentLoggedIn;
            } else {
                $loggedInError = 'Incorrect student ID and/or password';
            }
        } catch (Exception $ex) {
            die("The system is currently not available, try again later");
        }
    }
} elseif (isset($_POST['clear'])) {
    $_SESSION['studentId'] = '';
    $_SESSION['password'] = '';
}
?>

<?php include("./common/header.php");
?>

<?PHP
//The colon (:) in PHP is an alternative syntax for control structures like if, else, elseif, while, for, and foreach when used in conjunction with the endif, endelse, endforeach, endwhile, endfor, and endswitch keywords. It's particularly useful when embedding PHP within HTML.
//So, in the example you provided:
//if (!isset($_SESSION['loggedIn'])) :
//    // Code for when the condition is true
//else :
//    // Code for when the condition is false
//endif;

if (!isset($_SESSION['loggedIn'])) :
    ?>
    <form class="container my-1" id="loginInfo" method="post" action="./Login.php">


        <div class="row align-content-center justify-content-center my-2">
            <div class="display-6 fw-bolder text-center">
                Log in
            </div>
        </div>

        <div class="row mt-3 align-content-center text-center">
        <p>You need to <a href="NewUser.php" class="d-inline mx-1 fw-bold text-decoration-none">sign up</a>if you are a new student.</p>
    </div>
        
        <!--data for studentId-->
        <div class="row align-content-center justify-content-center mt-4">
            <div class="col-4 text-end ">
                <label for="studentId" class="text-xl fw-bold">StudentId:</label>
            </div>

            <div class="col-4 text-start">
                <input type="text" name="studentId" class="form-control col-4"                     
                <?php
                if (isset($_SESSION['studentId'])) {
                    echo 'value="' . $_SESSION['studentId'] . '"';
                }
                ?>>
            </div>

            <div class="col-4 text-danger fw-bolder error">
                <?php
                global $studentIdError;
                if ($studentIdError) {
                    echo $studentIdError;
                }
                ?>
            </div>
        </div>

        <!--Data for password-->
        <div class="row align-content-center justify-content-center mt-4">
            <div class="col-4 text-end ">
                <label for="password" class="text-xl fw-bold">Password:</label>
            </div>

            <div class="col-4 text-start">
                <input type="password" name="password" class="form-control col-4"                     
                <?php
                if (isset($_SESSION['password'])) {
                    echo 'value="' . $_SESSION['password'] . '"';
                }
                ?>>
            </div>

            <div class="col-4 text-danger fw-bolder error">
                <?php
                global $passwordError;
                if ($passwordError) {
                    echo $passwordError;
                }
                ?>
            </div>
        </div>

        <!--buttons-->
        <div class="row mt-3">
            <div class="col-4"></div>
            <div class="col-4">
                <input type='submit' name='submit' class="btn btn-primary btn-rounded m-2" value='Submit' >
                <input type='submit' name='clear' class="btn btn-warning btn-rounded m-2" value='Clear' >
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12 text-danger fw-bolder error text-center">
                <?php
                global $loggedInError;
                if ($loggedInError) {
                    print $loggedInError;
                }
                ?>
            </div>
        </div>
    </form>
<?php else : ?>
    <div class="container my-1">
        <p>Successfully logged in!</p>
    </div>
<?php endif; ?>

<?php include('./common/footer.php'); ?>