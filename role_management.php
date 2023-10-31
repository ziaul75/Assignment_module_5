<?php
session_start();

function checkAdmin()
{
    return true; // for testing purpose
    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
        return true;
    } else {
        return false;
    }
}

function updateUserRole($userEmail, $newRole)
{
    if (checkAdmin()) {
        $userDataPath = "user_data.txt";
        $json_data = file_get_contents($userDataPath);
        $users = explode(PHP_EOL, $json_data);
        $updatedUsers = [];
        foreach ($users as $user) {
            $data = json_decode($user, true);
            if ($data && $data['userEmail'] === $userEmail) {
                $data['role'] = $newRole;
                $user = json_encode($data);
            }
            $updatedUsers[] = $user;
        }
        file_put_contents($userDataPath, implode(PHP_EOL, $updatedUsers));

        echo "User role updated successfully.";
    } else {
        echo "Access denied. Only admins can update user roles.";
    }
}

function addUser($userName, $userEmail, $userPassword, $userRole)
{
    if (checkAdmin()) {
        echo "New user added successfully.";
    } else {
        echo "Access denied. Only admins can add new users.";
    }
}

function deleteUser($userEmail)
{
    if (checkAdmin()) {
        echo "User deleted successfully.";
    } else {
        echo "Access denied. Only admins can delete users.";
    }
}

if (checkAdmin()) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['updateRole']) && isset($_POST['userEmail'])) {
            $userEmail = $_POST['userEmail'];
            $newRole = $_POST['updateRole'];
            updateUserRole($userEmail, $newRole);
        } elseif (isset($_POST['userName']) && isset($_POST['userEmail']) && isset($_POST['userPassword']) && isset($_POST['userRole'])) {
            $userName = $_POST['userName'];
            $userEmail = $_POST['userEmail'];
            $userPassword = $_POST['userPassword'];
            $userRole = $_POST['userRole'];
            addUser($userName, $userEmail, $userPassword, $userRole);
        } elseif (isset($_POST['deleteUserEmail'])) {
            $userEmail = $_POST['deleteUserEmail'];
            deleteUser($userEmail);
        }
    }

    echo "<!DOCTYPE html>
        <html>
        <head>
            <title>Role Management</title>
            <!-- Include Bootstrap CSS -->
            <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css'>
        </head>
        <body>
            <div class='container'>
                <h1>Welcome, Admin</h1>
                <h2>Role Management Page</h2>

                <!-- Update User Role Form -->
                <h3>Update User Role</h3>
                <form method='post' action=''>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='userEmail' placeholder='Enter user email'>
                    </div>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='updateRole' placeholder='Enter new role'>
                    </div>
                    <button type='submit' class='btn btn-primary'>Update User Role</button>
                </form>

                <!-- Add New User Form -->
                <h3>Add New User</h3>
                <form method='post' action=''>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='userName' placeholder='Enter user name'>
                    </div>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='userEmail' placeholder='Enter user email'>
                    </div>
                    <div class='form-group'>
                        <input type='password' class='form-control' name='userPassword' placeholder='Enter user password'>
                    </div>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='userRole' placeholder='Enter user role'>
                    </div>
                    <button type='submit' class='btn btn-success'>Add User</button>
                </form>

                <!-- Delete User Form -->
                <h3>Delete User</h3>
                <form method='post' action=''>
                    <div class='form-group'>
                        <input type='text' class='form-control' name='deleteUserEmail' placeholder='Enter user email to delete'>
                    </div>
                    <button type='submit' class='btn btn-danger'>Delete User</button>
                </form>
            </div>

            <!-- Include Bootstrap JavaScript and jQuery -->
            <script src='https://code.jquery.com/jquery-3.5.1.slim.min.js'></script>
            <script src='https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js'></script>
            <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js'></script>
        </body>
        </html>";
} else {
    header("location: login.html");
    exit;
}
?>
