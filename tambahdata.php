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

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function getKodeKategori($kategori) {
    return strtoupper(substr($kategori, 0, 1));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul_buku = $_POST['judul_buku'];
    $pengarang = $_POST['pengarang'];
    $penerbit = $_POST['penerbit'];
    $kategori = $_POST['kategori'];
    $tahun = $_POST['tahun'];
    $jumlah = $_POST['jumlah'];

    $kode_kategori = getKodeKategori($kategori);

    $result = $conn->query("SELECT COUNT(*) as total FROM buku WHERE kategori = '$kategori'");
    $row = $result->fetch_assoc();
    $total_buku = $row['total'] + 1;

    $id_buku = $kode_kategori . str_pad($total_buku, 3, '0', STR_PAD_LEFT);

    $sql = "INSERT INTO buku (id_buku, judul_buku, pengarang, penerbit, kategori, tahun, jumlah)
            VALUES ('$id_buku', '$judul_buku', '$pengarang', '$penerbit', '$kategori', '$tahun', '$jumlah')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data berhasil ditambahkan!'); window.location.href='dashboard.php';</script>";
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
    <title>Tambah Data Buku - Inventaris Perpustakaan Ceria</title>
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
                    <a class="nav-link " href="dashboard.php" style="color: #000000;">Data Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="tambahdata.php" style="color: #000000;">Tambah Data Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="databarang.php" style="color: #000000;">Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tambahbarang.php" style="color: #000000;">Tambah Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="color: #000000;">Logout</a>
                </li>
            </ul>
            <div id="clock" class="text-center mt-3" style="color: #000000;"></div> 
        </div>
        <div class="col-md-10 content">
            <h2 class="text-center py-3">Tambah Data Buku</h2>
            <form method="post" action="">
                <div class="form-group">
                    <label for="judul_buku">Judul Buku</label>
                    <input type="text" class="form-control" id="judul_buku" name="judul_buku" required>
                </div>
                <div class="form-group">
                    <label for="pengarang">Pengarang</label>
                    <input type="text" class="form-control" id="pengarang" name="pengarang" required>
                </div>
                <div class="form-group">
                    <label for="penerbit">Penerbit</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <select class="form-control" id="kategori" name="kategori" required>
                        <option value="Agama">Agama</option>
                        <option value="Teknologi">Teknologi</option>
                        <option value="Sejarah">Sejarah</option>
                        <option value="Pendidikan">Pendidikan</option>
                        <option value="Cerpen">Cerpen</option>
                        <option value="Novel">Novel</option>
                        <option value="Budidaya">Budidaya</option>
                        <option value="Komik">Komik</option>
                        <option value="Ensiklopedia">Ensiklopedia</option>
                        <option value="Majalah">Majalah</option>
                        <option value="Lain-Lain">Lain-Lain</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun</label>
                    <input type="number" class="form-control" id="tahun" name="tahun" required>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Buku</button>
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