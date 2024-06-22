<?php
session_start();
$database = new mysqli("localhost", "root", "", "db");

if ($database->connect_error) {
    die("Connection failed: " . $database->connect_error);
}

$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
$specialty = isset($_GET['specialty']) ? trim($_GET['specialty']) : '';
$city = isset($_GET['city']) ? trim($_GET['city']) : '';

$query = "SELECT DOCTOR.DOCID, DOCTOR.DOCNAME, DOCTOR.DOCTEL, DOCTOR.DESCRIPTION, SPECIALTIES.SNAME, CITIES.NAME as CITY_NAME, DOCTOR.EXPERIENCE, DOCTOR.IMAGE_PATH 
          FROM DOCTOR 
          LEFT JOIN SPECIALTIES ON DOCTOR.SPECIALTIES = SPECIALTIES.ID 
          LEFT JOIN CITIES ON DOCTOR.CITY = CITIES.ID 
          WHERE 1=1 ";

$params = [];
$types = '';

if (!empty($searchQuery)) {
    $query .= "AND (DOCTOR.DOCNAME LIKE ? OR SPECIALTIES.SNAME LIKE ?) ";
    $searchParam = "%" . $searchQuery . "%";
    $params[] = $searchParam;
    $params[] = $searchParam;
    $types .= 'ss';
}

if (!empty($specialty)) {
    $query .= "AND DOCTOR.SPECIALTIES = ? ";
    $params[] = $specialty;
    $types .= 'i';
}

if (!empty($city)) {
    $query .= "AND DOCTOR.CITY = ? ";
    $params[] = $city;
    $types .= 'i';
}

$stmt = $database->prepare($query);

if ($params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
    <title>Search Results</title>
    <style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .card {
            margin: 20px;
            width: 300px;
            border: none;
        }
        .card img {
            width: 100%;
            height: auto;
        }
        .card-body {
            text-align: center;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mt-5">
        <h1 class="text-center mb-4 text-3xl font-bold">Search Results</h1>
        <div class="card-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="card shadow-lg rounded-lg overflow-hidden">
                        <img src="<?php  echo htmlspecialchars($row['IMAGE_PATH']); ?>" alt="Doctor Image" class="w-full h-64 object-cover">
                        <div class="card-body p-4">
                            <h5 class="card-title font-bold text-xl mb-2"><?php echo htmlspecialchars($row['DOCNAME']); ?></h5>
                            <p class="card-text text-gray-700 mb-2"><?php echo htmlspecialchars($row['SNAME']); ?></p>
                            <p class="card-text text-gray-700 mb-2">Experience: <?php echo htmlspecialchars($row['EXPERIENCE']); ?> years</p>
                            <p class="card-text text-gray-700 mb-2"><?php echo htmlspecialchars($row['DESCRIPTION']); ?></p> <!-- Added description -->
                            <p class="card-text text-gray-700 mb-4">City: <?php echo htmlspecialchars($row['CITY_NAME']); ?></p>
                            <a href="tel:<?php echo htmlspecialchars($row['DOCTEL']); ?>" class="btn btn-primary btn-custom mb-2">Call Now</a>
                            <a href="https://api.whatsapp.com/send?phone=<?php echo htmlspecialchars($row['DOCTEL']); ?>&text=I%20would%20like%20to%20book%20an%20appointment" class="btn btn-success btn-custom mb-2" target="_blank">WhatsApp</a>
<a href="signup.php" class="btn btn-primary btn-custom">Book Now</a>

                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p class="text-center text-gray-700">No results found.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$database->close();
?>
