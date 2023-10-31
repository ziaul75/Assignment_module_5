<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    $userEmail = filter_var($_POST['userEmail'], FILTER_SANITIZE_EMAIL);
    $userPassword =$_POST['userPassword'];

    $userDataPath = "user_data.txt";
    $json_data = file_get_contents($userDataPath);
    $users = explode(PHP_EOL, $json_data);
    $isLoggedIn = false;

    foreach ($users as $user) {
        $data = json_decode($user, true);
        if ($data && $data['userEmail'] === $userEmail && password_verify($userPassword, $data['userPassword'])) {
            $_SESSION['userEmail'] = $userEmail;
            $_SESSION['role'] = $data['role'];
            $isLoggedIn = true;
            break;
        }
    }

    if ($isLoggedIn) {
        if ($_SESSION['role'] === 'admin') {
            header("location: ruleManagment.php");
            exit;
        } elseif ($_SESSION['role'] === 'manager') {
            header("location: managment.php");
            exit;
        } else {
            header("location: user_home.php");
            exit;
        }
    } else {
        echo "Invalid credentials. Please try again.";
        // header("location:ruleManagment.php");
    }
    // session_unset();
    // session_destroy();
}
?>
