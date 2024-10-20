<?php
include 'db.php';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $institution = $_POST['institution'];
    $country = $_POST['country'];
    $address = $_POST['address'];

    $checkEmail = $conn->prepare("SELECT * FROM registration WHERE email = ? AND is_deleted = 0");
    $checkEmail->bind_param("s", $email);
    $checkEmail->execute();
    $result = $checkEmail->get_result();

    if ($result->num_rows > 0) {
        $message = "Email already exists!";
    } else {
        $stmt = $conn->prepare("INSERT INTO registration (email, name, institution, country, address) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $name, $institution, $country, $address);

        if ($stmt->execute()) {
            $message = "Registration successful!";
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    }
    $checkEmail->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seminar Registration</title>
</head>
<body>
    <h2>Seminar Registration</h2>
    <form method="POST" action="">
        Email: <input type="email" name="email" required><br>
        Name: <input type="text" name="name" required><br>
        Institution: <input type="text" name="institution" required><br>
        Country: <input type="text" name="country" required><br>
        Address: <textarea name="address" required></textarea><br>
        <button type="submit">Register</button>
    </form>

    <p><?php echo $message; ?></p>
</body>
</html>
