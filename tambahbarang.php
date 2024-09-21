<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "perpustakaan";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fungsi untuk mendapatkan ID barang baru
function getNewIdBarang($conn) {
    $result = $conn->query("SELECT MAX(id_barang) as max_id FROM barang");
    $row = $result->fetch_assoc();
    $max_id = $row['max_id'];
    
    $new_id = str_pad((int)$max_id + 1, 4, '0', STR_PAD_LEFT);
    return $new_id;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST['nama_barang'];
    $kondisi = $_POST['kondisi'];
    $jumlah = $_POST['jumlah'];

    // Mendapatkan ID barang baru
    $id_barang = getNewIdBarang($conn);

    // Menambahkan data barang baru ke dalam database
    $sql = "INSERT INTO barang (id_barang, namabarang, kondisi, jumlah)
            VALUES ('$id_barang', '$nama_barang', '$kondisi', '$jumlah')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='databarang.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Barang - Inventaris Perpustakaan Ceria</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styledashboard.css">
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <h3 class="text-black text-center py-3">Perpustakaan Ceria</h3>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php" style="color: #000000;">Data Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tambahdata.php" style="color: #000000;">Tambah Data Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="databarang.php" style="color: #000000;">Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="tambahbarang.php" style="color: #000000;">Tambah Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="color: #000000;">Logout</a>
                </li>
            </ul>
            <div id="clock" class="text-center mt-3" style="color: #000000;"></div> 
        </div>
        <div class="col-md-10 content">
            <h2 class="text-center py-3">Tambah Data Barang</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
                </div>
                <div class="form-group">
                    <label for="kondisi">Kondisi</label>
                    <select class="form-control" id="kondisi" name="kondisi" required>
                        <option value="Rusak">Rusak</option>
                        <option value="Kurang Baik">Kurang Baik</option>
                        <option value="Baik">Baik</option>
                        <option value="Sangat Baik">Sangat Baik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Barang</button>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<script>
function updateClock() {
    var now = new Date();
    var hours = now.getHours().toString().padStart(2, '0');
    var minutes = now.getMinutes().toString().padStart(2, '0');
    var seconds = now.getSeconds().toString().padStart(2, '0');
    var timeString = hours + ':' + minutes + ':' + seconds;
    
    document.getElementById('clock').textContent = timeString;
}

setInterval(updateClock, 1000);

updateClock();
</script>

</body>
</html>
