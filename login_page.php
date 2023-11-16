<?php
// Replace these values with your actual database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user input from the login form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Protect against SQL injection
    $username = mysqli_real_escape_string($conn, $username);

    // Query to get the hashed password from the database
    $sql = "SELECT id, username, password FROM user WHERE username = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_username);

        // Set parameters
        $param_username = $username;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Store the result
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                // Bind the result variables
                $stmt->bind_result($id, $username, $hashed_password);

                if ($stmt->fetch()) {
                    // Verify the entered password with the stored hashed password
                    if ($password === $hashed_password) {
                        // Password is correct, login successful
                        session_start();
                        $_SESSION["id"] = $id;
                        $_SESSION["username"] = $username;
                        header('Location: home_page.php');
                        exit();
                    } else {
                        // Invalid password
                        echo "Invalid password";
                    }
                }
            } else {
                // User does not exist
                echo "Invalid username";
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the database connection
$conn->close();
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
        <h2>Login</h2>
        <div class="container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="username">Username:</label>
                <input type="text" name="username" required><br>

                <label for="password">Password:</label>
                <input type="password" name="password" required><br>
                <div class="loginbtn">
                    <input type="submit" value="Login" class="loginbtn" style=" background-color: #04AA6D;
    color: white;
    padding: 14px 20px;
    border: none;
    cursor: pointer;
    width: 30%;
    align-items: center;
    border-radius: 15px;">
                </div>
        </div>
        <a href="signup_page.php">Create a new Account</a>
        </form>
    </div>
</body>

</html>
