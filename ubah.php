<?php
include 'db.php'; // Ensure db.php is properly configured

// Get student ID from URL
if (!isset($_GET['id'])) {
    echo "<script>alert('No ID provided!');window.location.href='index.php';</script>";
    exit();
}
$id = $_GET['id'];

// Fetch existing data
$sql = "SELECT * FROM students WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<script>alert('No data found!');window.location.href='index.php';</script>";
    exit();
}

$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $absent_number = $_POST['absent_number'];

    // Check if a new photo is uploaded
    if ($_FILES['photo']['name']) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            // Delete old photo if exists
            if (!empty($row['photo']) && file_exists($row['photo'])) {
                unlink($row['photo']);
            }
            $photo_sql = ", photo='$target_file'";
        } else {
            echo "<script>alert('Error uploading file.');window.location.href='ubah.php?id=$id';</script>";
            exit();
        }
    } else {
        $photo_sql = "";
    }

    // Update data in database
    $sql = "UPDATE students SET name='$name', class='$class', absent_number='$absent_number' $photo_sql WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully');window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
</head>
<body>
    <h2>Edit Student</h2>
    <form action="ubah.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" name="name" value="<?= $row['name'] ?>" required><br>

        <label for="class">Class:</label><br>
        <input type="text" name="class" value="<?= $row['class'] ?>" required><br>

        <label for="absent_number">Absent Number:</label><br>
        <input type="number" name="absent_number" value="<?= $row['absent_number'] ?>" required><br>

        <label for="photo">Photo:</label><br>
        <input type="file" name="photo"><br>
        <small>Leave blank if not changing</small><br><br>

        <input type="submit" value="Update">
    </form>
</body>
</html>
