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

    // Check if the user is logged in and if the user type is 'd' (Doctor)
    if (!isset($_SESSION["usertype"]) || $_SESSION["usertype"] != "d") {
        echo "<script>alert('You do not have access to this page');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
        exit();
    }

    $error = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $nic = $_POST['nic'];
        $tele = $_POST['tele'];
        $specialties = $_POST['specialties'];
        $description = $_POST['description'];
        $experience = $_POST['experience'];
        $city = $_POST['city'];
        $email = $_SESSION['user'];

        // Handle file upload
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);

        if($check !== false && move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image_path = $target_file;
        } else {
            $error = "File is not an image or failed to upload.";
        }

        // Database connection
        $conn = new mysqli('localhost', 'root', '', 'db'); // Adjust connection details
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Insert into DOCTOR table
        $stmt = $conn->prepare("INSERT INTO DOCTOR (DOCEMAIL, DOCNAME, DOCNIC, DOCTEL, SPECIALTIES, DESCRIPTION, EXPERIENCE, CITY, IMAGE_PATH) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssissis", $email, $name, $nic, $tele, $specialties, $description, $experience, $city, $image_path);

        if ($stmt->execute()) {
            echo "<script>alert('Doctor account created successfully!');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        } else {
            $error = "Error: " . $stmt->error;
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
                        <p class="sub-text">It's Okay, Now Create Doctor Account.</p>
                    </td>
                </tr>
                <tr>
                    <form action="" method="POST" enctype="multipart/form-data">
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
                        <label for="nic" class="form-label">CNI: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="text" name="nic" class="input-text" placeholder="NIC" required>
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
                    <td class="label-td" colspan="2">
                        <label for="specialties" class="form-label">Specialties: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <select name="specialties" class="input-text" required>
                            <option value="" disabled selected>Select your specialty</option>
                            <?php
                            // Fetch specialties from the database
                            $conn = new mysqli('localhost', 'root', '', 'db'); // Adjust connection details
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }

                            $result = $conn->query("SELECT ID, SNAME FROM SPECIALTIES");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['ID'] . "'>" . $row['SNAME'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="description" class="form-label">Description: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <textarea name="description" class="input-text" placeholder="Description" required></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="experience" class="form-label">Experience (years): </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="number" name="experience" class="input-text" placeholder="Experience" required>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="city" class="form-label">City: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <select name="city" class="input-text" required>
                            <option value="" disabled selected>Select your city</option>
                            <?php
                            // Fetch cities from the database
                            $result = $conn->query("SELECT ID, NAME FROM CITIES");
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='" . $row['ID'] . "'>" . $row['NAME'] . "</option>";
                                }
                            }
                            $conn->close();
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <label for="image" class="form-label">Profile Image: </label>
                    </td>
                </tr>
                <tr>
                    <td class="label-td" colspan="2">
                        <input type="file" name="image" class="input-text" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <span style="color: red;"><?php echo $error; ?></span>
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
