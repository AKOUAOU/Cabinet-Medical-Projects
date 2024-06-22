<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>Sign Up</title>
</head>
<body>
<?php
session_start();
$_SESSION["user"] = "";
$_SESSION["usertype"] = "";
$_SESSION["username"] = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $usertype = $_POST['usertype'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'db'); // Adjust connection details
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO WEBUSER (USERNAME, EMAIL, PASSWORD, USERTYPE) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $email, $password, $usertype);

    if ($stmt->execute()) {
        $_SESSION["username"] = $username;
        $_SESSION["usertype"] = $usertype;
        $_SESSION["user"] = $email;

        // Redirect based on usertype
        if ($usertype == 'p') {
            header("Location: patientregister.php");
        } elseif ($usertype == 'd') {
            header("Location: doctorregister.php");
        } elseif ($usertype == 'a') {
            header("Location: admin/index.php");
        }
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<center>
    <div class="container">
        <table border="0">
            <tr>
                <td colspan="2">
                    <p class="header-text">Let's Get Started</p>
                    <p class="sub-text">Add Your Personal Details to Continue</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST">
                <td class="label-td" colspan="2">
                    <label for="username" class="form-label">Username: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="username" class="input-text" placeholder="Username" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="email" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="email" class="input-text" placeholder="Email" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="password" class="form-label">Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="password" class="input-text" placeholder="Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="usertype" class="form-label">User Type: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <select name="usertype" class="input-text" required>
                        <option value="p">Patient</option>
                        <option value="d">Doctor</option>
                        <option value="a">Admin</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                </td>
                <td>
                    <input type="submit" value="Next" class="login-btn btn-primary btn">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <br>
                    <label for="" class="sub-text" style="font-weight: 280;">Already have an account&#63; </label>
                    <a href="login.php" class="hover-link1 non-style-link">Login</a>
                    <br><br><br>
                </td>
            </tr>
                </form>
            </tr>
        </table>
    </div>
</center>
</body>
</html>
