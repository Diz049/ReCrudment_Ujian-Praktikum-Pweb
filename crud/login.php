<?php
include 'connection.php';
session_start();

// Handle Login
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role']; // <- ambil role dari database

        if ($row['role'] === 'admin') {
            header("Location: ../admin_page.php");
        } else {
            header("Location: ../index.php");
        }
        exit;
    } else {
        $error = "Invalid username or password!";
    }
}


// Handle Register
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm  = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = "Passwords do not match!";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Username already exists!";
        } else {
            $insert = "INSERT INTO users (username, password) VALUES ('$username','$password')";
            if (mysqli_query($conn, $insert)) {
                $success = "Account created! Please login.";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login & Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 400px;
            margin-top: 80px;
        }

        #registerForm {
            display: none;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container bg-white p-4 rounded shadow">
        <h3 class="text-center mb-4" id="formTitle">Login</h3>

        <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

        <!-- Login Form -->
        <form method="POST" id="loginForm">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            <p class="mt-3 text-center">
                Don’t have an account? <a href="#" onclick="toggleForms()">Register</a>
            </p>
        </form>

        <!-- Register Form -->
        <form method="POST" id="registerForm">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" name="register" class="btn btn-success w-100">Register</button>
            <p class="mt-3 text-center">
                Already have an account? <a href="#" onclick="toggleForms()">Login</a>
            </p>
        </form>

    </div>

    <script>
        function toggleForms() {
            const loginForm = document.getElementById("loginForm");
            const registerForm = document.getElementById("registerForm");
            const title = document.getElementById("formTitle");

            if (loginForm.style.display === "none") {
                loginForm.style.display = "block";
                registerForm.style.display = "none";
                title.textContent = "Login";
            } else {
                loginForm.style.display = "none";
                registerForm.style.display = "block";
                title.textContent = "Register";
            }
        }
    </script>

</body>
</html>
