<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "test";



$link = mysqli_connect($host, $username, $password, $database);

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

if (isset($_POST['submit'])) {
    echo"<h1>working</h1>";
    $username = mysqli_real_escape_string($link, $_POST['username']);
    $password = $_POST['password'];

    $select = "SELECT * FROM userdata WHERE username = '$username'";

    $result = mysqli_query($link, $select);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            // Check if the password is correct
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_name'] = $row['name'];
                header('location: home_page.php');
                exit;
            } else {
                $error = 'Incorrect password!';
            }
        } else {
            $error = 'Username not found.';
        }
    } else {
        $error = 'Error executing query: ' . mysqli_error($link);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login_page.css">
</head>

<body>
    <div class="loginbox">
        <form action="" method="post">

            <h2>Login</h2>

            <div class="container">
                <?php if (isset($error)) : ?>
                    <p style="color: red;"><?php echo $error; ?></p>
                <?php endif; ?>

                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <a href="forgot_password.php" style="font-size: 14px;">Forgot password</a>
                <br>

                <div class="loginbtn">
                    <button type="submit" class="loginbtn" name="submit">Login</button>
                </div>
                <a href="signup_page.php" style="font-size: 14px;">Sign up</a>
                <label for=""></label>
            </div>
        </form>
    </div>
</body>

</html>
