<?php
// $LoginFilePath = "../php/_adminLogin.php";

// if (file_exists($LoginFilePath)) {
//     include($LoginFilePath);
// } else {
//     echo "<p class='error'>Error: Unable to include file <strong>$LoginFilePath</strong> - File does not exist.</p>";
//     return;
// }
$CommonFilePath = "../php/_common.php";

if (file_exists($CommonFilePath)) {
    include($CommonFilePath);
} else {
    echo "<p class='error'>Error: Unable to include file <strong>$CommonFilePath</strong> - File does not exist.</p>";
    return;
}
loginAdmin($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .register-link {
            margin-top: 15px;
            text-align: center;
        }

        .register-link a {
            color: #007BFF;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }

        .form-group input[type="checkbox"] {
            width: auto;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Admin Login</h1>
        <form action="AdminLogin.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <input type="checkbox" id="showPassword"> Show Password
            </div>
            <div class="form-group">
                <button type="submit">Login</button>
            </div>
        </form>
        <div class="register-link">
            <p>Don't have an account? <a href="AdminRegister.php">Register here</a></p>
        </div>
    </div>
    <script>
        document.getElementById('showPassword').addEventListener('change', function() {
            var passwordInput = document.getElementById('password');
            if (this.checked) {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        });
    </script>
</body>

</html>