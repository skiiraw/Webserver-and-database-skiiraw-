<html>
<style>
table, th, td {
  border:1px solid black;
}
</style>    
<body>
        <h1> DATA PROFIL SISWA</h1>
        <a href="add.php">Tambah Data</a>
        <table style="width:100%">
            <tr>
              <th>Nomor</th>  
              <th>Nama</th>
              <th>Kelas</th>
              <th>Nomor Absen</th>
              <th>Foto</th>
              <th>Aksi</th>
            </tr>
            <?php
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "rds"; // Pastikan database ini benar sesuai di PHPMyAdmin
            
            // Buat koneksi
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Perbaiki query sesuai tabel `profil`
            $sql = "SELECT id, nama, kelas, nomor_absen, foto FROM profil";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["id"] . "</td>";
                    echo "<td>" . $row["nama"] . "</td>";
                    echo "<td>" . $row["kelas"] . "</td>";
                    echo "<td>" . $row["nomor_absen"] . "</td>";
                    echo "<td>" . "<img src='". $row["foto"] . "' height='50' width='50'>" . "</td>";
                    echo "<td><a href='ubah.php?id=".$row["id"]."'>Ubah</a> | <a href='hapus.php?id=".$row["id"]."'>Hapus</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Tidak ada data</td></tr>";
            }
            $conn->close();
            ?>
          </table>
    </body>
</html>
