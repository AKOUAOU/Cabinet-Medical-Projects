<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocFinder</title>
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/iindex.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
       body {
    background-image: url(./img/bg01.jpg);
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: cover;
    height: 100%;
}

html, body {
    height: 100%;
    margin: 0;
}

.full-height {
    background: rgba(26, 26, 26, 0.548);
    background-attachment: fixed;
    min-height: 100vh; /* Adjust this to ensure the page takes up at least 100% of the viewport height */
    height: auto;
    padding-bottom: 20px; /* Add padding to avoid content being cut off */
}

table {
    width: 100%;
    padding-top: 5px;
}

.heading-text {
    color: white;
    font-size: 42px;
    font-weight: 700;
    line-height: 63px;
    margin-top: 15%;
    text-align: center;
    margin-bottom: 0;
}

.sub-text2 {
    color: rgba(255, 255, 255, 0.5);
    font-size: 17px;
    line-height: 27px;
    font-weight: 400;
    text-align: center;
    margin-top: 0;
}

.register-btn {
    background-color: rgba(240, 248, 255, 0.589);
    color: #345cc4;
}

.edoc-logo {
    color: white;
    font-weight: bolder;
    font-size: 20px;
    padding-left: 20px;
    animation: transitionIn-Y-over 0.5s;
}

.edoc-logo-sub {
    color: rgba(255, 255, 255, 0.733);
    font-size: 12px;
}

.nav-item {
    color: rgba(255, 255, 255, 0.671);
    text-align: center;
    font-size: 15px;
    font-weight: 500;
    animation: transitionIn-Y-over 0.5s;
}

.nav-item:hover {
    color: #f0f0f0;
}

.footer-hashen {
    font-size: 13px;
    animation: transitionIn-Y-over 0.5s;
    text-align: center;
    padding-top: 20px;
}

    </style>
</head>
<body>
    <div class="full-height">
        <center>
            <table border="0">
                <tr>
                    <td width="80%">
                        <span class="edoc-logo">DocFinder.</span>
                        <span class="edoc-logo-sub">| Your Health, Our Priority</span>
                    </td>
                    <td width="10%">
                        <a href="login.php" class="non-style-link">
                            <p class="nav-item">LOGIN</p>
                        </a>
                    </td>
                    <td width="10%">
                        <a href="signup.php" class="non-style-link">
                            <p class="nav-item" style="padding-right: 10px;">REGISTER</p>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p class="heading-text">Find Your Doctor Quickly and Easily.</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p class="sub-text2">Feeling unwell? Need to see a specialist?<br>
                            Don't worry. With DocFinder, you can find and book your doctor appointments online.<br>
                            Access a wide range of medical specialists and health services at your convenience.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="search-section">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-6 col-md-8 col-sm-10">
                                    <form action="search.php" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Search for doctors..." name="query">
                                        </div>
                                        <div class="form-group mb-3">
                                            <select class="form-control" name="specialty">
                                                <option value="">Select Specialty</option>
                                                <?php
                                                // Database connection
                                                $database = new mysqli("localhost", "root", "", "db");
                                                if ($database->connect_error) {
                                                    die("Connection failed: " . $database->connect_error);
                                                }
                                                $result = $database->query("SELECT * FROM SPECIALTIES");
                                                if ($result) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['ID'] . "'>" . $row['SNAME'] . "</option>";
                                                    }
                                                    $result->free();
                                                } else {
                                                    echo "Error: " . $database->error;
                                                }
                                                $database->close();
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group mb-3">
                                            <select class="form-control" name="city">
                                                <option value="">Select City</option>
                                                <?php
                                                $database = new mysqli("localhost", "root", "", "db");
                                                if ($database->connect_error) {
                                                    die("Connection failed: " . $database->connect_error);
                                                }
                                                $result = $database->query("SELECT * FROM CITIES");
                                                if ($result) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<option value='" . $row['ID'] . "'>" . $row['NAME'] . "</option>";
                                                    }
                                                    $result->free();
                                                } else {
                                                    echo "Error: " . $database->error;
                                                }
                                                $database->close();
                                                ?>
                                            </select>
                                        </div>
                                        <button class="btn btn-primary btn-block" type="submit">Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <p class="sub-text2 footer-hashen">A Web Solution by Akouaou Mostafa.</p>
        </center>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
