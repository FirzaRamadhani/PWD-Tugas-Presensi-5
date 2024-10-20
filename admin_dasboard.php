<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db.php';

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE registration SET is_deleted = 1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

$registrations = $conn->query("SELECT * FROM registration WHERE is_deleted = 0");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Manage Registrations</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>Name</th>
            <th>Institution</th>
            <th>Country</th>
            <th>Address</th>
            <th>Action</th>
        </tr>
        <?php while($row = $registrations->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['institution']; ?></td>
            <td><?php echo $row['country']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="delete">Delete</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
    <br>
    <a href="add_registration.php">Add New Registration</a>
</body>
</html>
