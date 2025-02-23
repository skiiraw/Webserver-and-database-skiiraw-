<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $class = $_POST['class'];
    $absent_number = $_POST['absent_number'];
    $photo = $_FILES['photo'];

    // Validation
    if (empty($name) || empty($class) || empty($absent_number) || $photo['error'] !== 0) {
        echo "All fields are required, and a valid image must be uploaded.";
        exit();
    }

    // Upload Foto
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($photo["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Pastikan hanya file gambar yang bisa diupload
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "Only JPG, JPEG, PNG & GIF files are allowed.";
        exit();
    }

    // Pindahkan file ke folder uploads/
    if (move_uploaded_file($photo["tmp_name"], $target_file)) {
        echo "The file ". basename($photo["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
        exit();
    }

    // Save to Database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rds"; // Pastikan sesuai dengan database di PHPMyAdmin

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Perbaiki query ke tabel yang benar (profil)
    $sql = "INSERT INTO profil (nama, kelas, nomor_absen, foto) 
            VALUES ('$name', '$class', '$absent_number', '$target_file')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        echo "<script>alert('New record created successfully');location.href='index.php'</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
}
?>
