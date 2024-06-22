<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include("connection.php");

    $doctor_id = $_POST['doctor_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $appointment_date = $_POST['appointment_date'];
    $message = $_POST['message'];

    $stmt = $database->prepare("INSERT INTO APPOINTMENTS (DOCTOR_ID, NAME, EMAIL, PHONE, APPOINTMENT_DATE, MESSAGE) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $doctor_id, $name, $email, $phone, $appointment_date, $message);

    if ($stmt->execute()) {
        $success = "Appointment booked successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment as Guest</title>
</head>
<body>
    <h1>Book Appointment</h1>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php elseif (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form action="appointment.php" method="post">
        <input type="hidden" name="doctor_id" value="<?php echo htmlspecialchars($_GET['doctor_id']); ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" required><br>
        <label for="appointment_date">Appointment Date:</label>
        <input type="date" id="appointment_date" name="appointment_date" required><br>
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea><br>
        <input type="submit" value="Book Appointment">
    </form>
</body>
</html>
