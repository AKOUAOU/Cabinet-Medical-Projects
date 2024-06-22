<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/signup.css">
    <title>Complete Creation Account</title>
    <style>
        .container {
            animation: transitionIn-X 0.5s;
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if ($_SESSION["usertype"] != "p") {
        echo "<script>alert('You do not have access to this page');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
        exit();
    }

    $error = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_SESSION["user"];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $nic = $_POST['nic'];
        $dob = $_POST['dob'];
        $tele = $_POST['tele'];

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'db'); // Adjust connection details
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $conn->autocommit(FALSE); // Turn off auto-commit

        try {
            // Insert into PATIENT table
            $stmt = $conn->prepare("INSERT INTO PATIENT (PEMAIL, PNAME, PADDRESS, PNIC, PDOB, PTEL) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $email, $name, $address, $nic, $dob, $tele);

            if (!$stmt->execute()) {
                throw new Exception($stmt->error);
            }

            $conn->commit(); // Commit the transaction
            echo "<script>alert('Patient registration successful');</script>";
            header("Location: Login.php");
            // Redirect to a success or next step page if necessary

        } catch (Exception $e) {
            $conn->rollback(); // Rollback the transaction on error
            $error = "Error: " . $e->getMessage();
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <center>
        <div class="container">
            <table border="0" style="width: 69%;">
                <tr>
                    <td colspan="2">
                        <p class="header-text">Let's Get Started</p>
                        <p class="sub-text">It's Okay, Now Create Patient Account.</p>
                    </td>
                </tr>
                <tr>
                    <form action="" method="POST">
                        <td class="label-td" colspan="2">
                            <label for="name" class="form-label">Full Name: </label>
                        </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="name" class="input-text" placeholder="Full Name" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="address" class="form-label">Address: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="address" class="input-text" placeholder="Address" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="nic" class="form-label">CIN: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="nic" class="input-text" placeholder="NIC" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="dob" class="form-label">Date of Birth: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="date" name="dob" class="input-text" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="tele" class="form-label">Mobile Number: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="tel" name="tele" class="input-text" placeholder="ex: 0712345678" pattern="[0]{1}[0-9]{9}" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <?php echo $error; ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                    </td>
                    <td>
                        <input type="submit" value="Sign Up" class="login-btn btn-primary btn">
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
