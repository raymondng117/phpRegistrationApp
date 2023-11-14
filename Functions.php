<?php

include('EntityClassLib.php');

function ValidateStudentID($studentID) {
    if (!isset($studentID) || empty(trim($studentID))) {
        return "StudentID cannot be blank";
    }
}

function ValidateName($name) {
    if (!isset($name) || empty(trim($name))) {
        return "Name cannot be blank";
    }
}

function ValidatePhone($phone) {
    $pattern = '/^[2-9]\d{2}-[2-9]\d{2}-\d{4}$/';

    if (!isset($phone) || empty(trim($phone))) {
        return "Phone number cannot be blank";
    } elseif (!preg_match($pattern, $phone)) {
        return "Incorrect phone number";
    }
}

function ValidatePassword($password) {

    if (!isset($password) || empty(trim($password))) {
        return "Password cannot be blank";
    } else if (
            strlen($password) < 6 ||
            !preg_match('/[A-Z]/', $password) ||
            !preg_match('/[a-z]/', $password) ||
            !preg_match('/[0-9]/', $password)
    ) {
        return "Password should be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one digit.";
    }
}

function ValidatePasswordForLogin($password) {

    if (!isset($password) || empty(trim($password))) {
        return "Password cannot be blank";
    }
}

function ValidatePasswordRetyped($password, $passwordRetype) {

    if (!isset($passwordRetype) || empty(trim($passwordRetype))) {
        return "Password cannot be blank";
    } else if ($password !== $passwordRetype) {
        return "Passwords are not consistent";
    }
}

function getPDO() {
    // catch the database associative array from config.ini
    $dbConnection = parse_ini_file("config.ini");
// extract corresponding values 
    extract($dbConnection);
// pass the setting values to the PDO constructor to establish database connection
    return new PDO($dsn, $user, $password);
}

function addNewStudent($studentId, $name, $phoneNum, $password) {
    $pdo = getPDO();
    $sql = "INSERT INTO Student (StudentId, Name, Phone, Password) VALUES ('$studentId', '$name', '$phoneNum', '$password')";
    $pdoStmt = $pdo->query($sql);
}

function getStudentRecordById($studentId) {
    $pdo = getPDO();
    $sql = "SELECT StudentId, Name, Phone FROM Student WHERE StudentId = '$studentId'";
    $resultSet = $pdo->query($sql);
    if ($resultSet) {
        $row = $resultSet->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new student($row['StudentId'], $row['Name'], $row['Phone']);
        } 
    }
}

function getStudentByIdAndPassword($studentId, $password) {
    $pdo = getPDO();
    $sql = "SELECT StudentId, Name, Phone FROM Student WHERE StudentId = '$studentId' AND Password = '$password'";

    $resultSet = $pdo->query($sql);
    if ($resultSet) {
        $row = $resultSet->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return new student($row['StudentId'], $row['Name'], $row['Phone']);
        } else {
            return null;
        }
    } else {
        throw new Exception("Query failed! SQL statement: $sql");
    }
}

?>
