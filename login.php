<?php
// Include the file for your database connection
include 'db_conn.php';

// Initialize variables
$email = $password = "";
$emailErr = $passwordErr = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate email
    if (empty($_POST['email'])) {
        $emailErr = "Email is required";
    } else {
        $email = $_POST['email'];
    }

    // Validate password
    if (empty($_POST['password'])) {
        $passwordErr = "Password is required";
    } else {
        $password = $_POST['password'];
    }

    // If both email and password are provided
    if (!empty($email) && !empty($password)) {
        // Query to fetch user data
        $sql = "SELECT * FROM admin WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Fetch the user data
            $row = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Check if the user is an admin
                if ($row['accountType'] == 'admin') {
                    // User is an admin, redirect to admin.php
                    header("Location: admin.php");
                    exit(); // Stop further execution
                } else {
                    // User is not an admin, redirect to index.php
                    header("Location: index.php");
                    exit(); // Stop further execution
                }
            } else {
                // Incorrect password
                $passwordErr = "Incorrect password";
            }
        } else {
            // User not found
            $emailErr = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Styling for the login page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        body {
            background-color: #00FFDC;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h2 {
            color: #0066cc;
        }

        label {
            color: #0066cc;
            font-weight: bold;
        }

        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #0066cc;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056a0;
        }

        .error {
            color: red;
        }
        
        /* Styling for the back arrow */
        .back-arrow-container {
            position: absolute;
            top: 20px;
            left: 20px;
            display: flex;
            align-items: center;
            z-index: 999; /* Ensuring it's above other elements */
        }

        .back-arrow img {
            width: 30px;
            height: 30px;
            cursor: pointer;
            margin-right: 5px;
        }

        .back-arrow-text {
            color: #0066cc;
            font-size: 16px;
        }
    </style>
</head>

<body>
    <div class="back-arrow-container">
        <!-- Back arrow -->
        <div class="back-arrow">
            <a href="index.php"><img src="images/back-arrow.png" alt="Back to BookStore"></a>
        </div>
        <div class="back-arrow-text">Back to BookStore</div>
    </div>
    <div class="container">
        <!-- Login form -->
        <h2>Login</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Email input -->
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email"><br>
            <span class="error"><?php echo $emailErr; ?></span>
            <br>
            <!-- Password input -->
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <span class="error"><?php echo $passwordErr; ?></span>
            <br>
            <!-- Submit button -->
            <input type="submit" value="Login">
        </form>
    </div>
</body>

</html>
