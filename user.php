<?php
// الاتصال بقاعدة البيانات
$conn = mysqli_connect("127.0.0.1", "root", "", "eapt");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// معالجة إدخال البيانات عند إرسال النموذج
$message = "";
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $password = password_hash($_POST['user_password'], PASSWORD_DEFAULT); // تشفير كلمة المرور

    // التحقق مما إذا كان البريد الإلكتروني موجودًا بالفعل
    $check_email = "SELECT * FROM users WHERE user_email = '$email'";
    $result = mysqli_query($conn, $check_email);

    if (mysqli_num_rows($result) > 0) {
        $message = "This email is already registered!";
    } else {
        // إضافة المستخدم الجديد
        $sql = "INSERT INTO users (user_name, user_email, user_password) 
                VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            cursor: pointer;
        }
        .message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Register</h2>
    <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>
    <form method="POST">
        <div class="form-group">
            <label for="user_name">Name:</label>
            <input type="text" id="user_name" name="user_name" required>
        </div>
        <div class="form-group">
            <label for="user_email">Email:</label>
            <input type="email" id="user_email" name="user_email" required>
        </div>
        <div class="form-group">
            <label for="user_password">Password:</label>
            <input type="password" id="user_password" name="user_password" required>
        </div>
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>

<?php mysqli_close($conn); ?>