<?php
include 'db.php'; // Ensure db.php is correctly configured

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $absent_number = $_POST['absent_number'];
    $photo = $_FILES['photo'];

    // Validation: Ensure fields are not empty
    if (empty($name) || empty($class) || empty($absent_number) || empty($photo['name'])) {
        echo "<script>alert('All fields are required!');window.location.href='add.php';</script>";
        exit();
    }

    // Upload photo
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $target_file = $target_dir . basename($photo["name"]);
    if (move_uploaded_file($photo["tmp_name"], $target_file)) {
        echo "The file " . basename($photo["name"]) . " has been uploaded.";
    } else {
        echo "<script>alert('Error uploading file.');window.location.href='add.php';</script>";
        exit();
    }

    // Insert data into database
    $sql = "INSERT INTO students (name, class, absent_number, photo) 
            VALUES ('$name', '$class', '$absent_number', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New record created successfully');window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
</head>
<body>
    <h2>Add New Student</h2>
    <form action="add.php" method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label><br>
        <input type="text" name="name" required><br>

        <label for="class">Class:</label><br>
        <input type="text" name="class" required><br>

        <label for="absent_number">Absent Number:</label><br>
        <input type="number" name="absent_number" required><br>

        <label for="photo">Photo:</label><br>
        <input type="file" name="photo" required><br><br>

        <input type="submit" value="Submit">
    </form>
</body>
</html>
