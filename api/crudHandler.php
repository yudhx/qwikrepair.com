<?php
// This file is used to handle CRUD requests on the Database.

/*
Functions to include
- deleteProfile
- updateProfile
-  */

header("Access-Control-Allow-Origin: http://localhost");
header("Access-Control-Allow-Credentials: true");

include_once "./dbConnection.php";
include_once "./errorHandler.php";

session_start();

if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['request-type'] == 'signup')
    signup($conn);

if ($_SERVER['REQUEST_METHOD'] == "POST" && !isset($_POST['request-type']))
    logout($conn);

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['request-type'] == "login")
    login($conn);



function signup($conn){
    // Get the data from the request
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];
    $repeatPwd = $_POST['repeatPwd'];
    $role = $_POST['role'];

    // Check if there are any empty fields
    if (empty($email) || empty($pwd) || empty($repeatPwd) || empty($role)){
        errorHandler(400, "Please fill in all fields.");
    }
    
    // Check if the passwords match
    if ($pwd != $repeatPwd){
        errorHandler(400, "Passwords do not match");
    }
    else {
        // Hash the password
        $pwd = password_hash($pwd, PASSWORD_DEFAULT);
    }
    
    //Check if the email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        errorHandler(400, "Invalid email address provided");
    }

    // Check if the email is already in use
    $sql = "SELECT * FROM user WHERE emailAddress = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0){
        errorHandler(400, "Email address already in use");
    }
    
    // Insert the user into the user database
    $sql_userDB = "INSERT INTO user (role, emailAddress, password) 
            VALUES (?,?,?)";

    $stmt_userDB = $conn -> stmt_init();

    if (!$stmt_userDB -> prepare($sql_userDB)) {
        errorHandler(500, "Internal server error");
    } else {
        $stmt_userDB -> bind_param('sss', $role, $email, $pwd);
        $stmt_userDB -> execute();
    }
  
    if ($stmt_userDB -> affected_rows > 0){
        http_response_code(200);
        echo "Successfully registered";
    exit();
    }
    else {
        errorHandler(500, "Internal server error");
    }
}

function login($conn){
    // Get the data from the request
    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    // Check if there are any empty fields
    if(empty($email) || empty($pwd)){
        errorHandler(400, "Please fill in all fields");
    }

    //Check if email address exists in the database
    $sql = "SELECT * FROM user WHERE emailAddress = '$email'";
    
    // Get value of password from database using email
    $sql = "SELECT password FROM user WHERE emailAddress = ?;";
    $stmt = $conn -> stmt_init();
    if (!$stmt -> prepare($sql)) {
        errorHandler(500, "Internal server error");
    } else {
        $stmt -> bind_param('s', $email);
        $stmt -> execute();
        $result = $stmt -> get_result();
    }
    if(mysqli_num_rows($result) == 0){
        errorHandler(400, "Email address not found");
    }
    else {
        $row = mysqli_fetch_assoc($result);
        $pwdHash = $row['password'];
    }

    // Check if the password is correct and redirect to the correct page based on the role
    $isPasswordValid = password_verify($pwd, $pwdHash);
    if ($isPasswordValid){
        $sql = "SELECT role FROM user WHERE emailAddress = '$email'";
        $result = $conn->query($sql);
        $row = mysqli_fetch_assoc($result);
        $role = $row['role'];
        $_SESSION['email'] = $email;
        switch ($role){
            case "senior":
                echo json_encode("senior/index.php");
                break;
            case "technician":
                echo json_encode("technicianHomepage.php");
                break;
            default:
                errorHandler(500, "Internal server error");
        }
    } else {
        errorHandler(400, "Incorrect password");
    }
    
    // Set the session variables
    $_SESSION['userID'] = $row['userID'];
    $_SESSION['role'] = $row['role'];
    $_SESSION['firstName'] = $row['firstName'];
    $_SESSION['lastName'] = $row['lastName'];
    $_SESSION['street'] = $row['street'];
    $_SESSION['city'] = $row['city'];
    $_SESSION['state'] = $row['state'];
    $_SESSION['postcode'] = $row['postcode'];
    $_SESSION['phoneNumber'] = $row['phoneNumber'];
    $_SESSION['emailAddress'] = $row['emailAddress'];
    $_SESSION['DOB'] = $row['DOB'];
    
    // Set the session cookie
    setcookie("userID", $row['userID'], time() + (86400 * 30), "/");
    setcookie("role", $row['role'], time() + (86400 * 30), "/");
    setcookie("firstName", $row['firstName'], time() + (86400 * 30), "/");
}

function logout($conn){
    // Unset all of the session variables
    $_SESSION = array();
    
    // Destroy the session
    session_destroy();
    
    // Delete the session cookie
    setcookie("userID", "", time() - 3600, "/");
    setcookie("role", "", time() - 3600, "/");
    setcookie("firstName", "", time() - 3600, "/");
}
?> 