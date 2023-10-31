<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = filter_var($_POST['userName'], FILTER_SANITIZE_STRING);
    $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
    $userPassword = $_POST['userPassword'];

    $userData = array(
        'userName' => $userName,
        'userEmail' => $userEmail,
        'userPassword' => $userPassword,
        'role' => 'admin'
    );

    $json_data = json_encode($userData);

    $userDataPath = "user_data.txt";
    if (file_put_contents($userDataPath, $json_data . PHP_EOL, FILE_APPEND | LOCK_EX) !== false) {
        echo "User registered successfully.";
        header("location: role_management.php");
    } else {
        echo "Failed to register the user.";
    }
}
?>
