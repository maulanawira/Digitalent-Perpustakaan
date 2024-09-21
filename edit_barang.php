<?php
$conn = new mysqli("localhost", "root", "", "perpustakaan");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_barang = $_GET['id_barang'];
$sql = "SELECT * FROM barang WHERE id_barang='$id_barang'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = $_POST["nama_barang"];
    $kondisi = $_POST["kondisi"];
    $jumlah = $_POST["jumlah"];

    $update_sql = "UPDATE barang SET namabarang='$nama_barang', kondisi='$kondisi', jumlah='$jumlah' WHERE id_barang='$id_barang'";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: databarang.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang - Inventaris Perusahaan XYZ</title>
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
                    <a class="nav-link" href="tambahdata.php" style="color: #000000;">Tambah Data Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="databarang.php" style="color: #000000;">Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tambahbarang.php" style="color: #000000;">Tambah Data Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php" style="color: #000000;">Logout</a>
                </li>
            </ul>
        </div>
        <div class="col-md-10 content">
            <h2 class="text-center py-3">Edit Barang</h2>
            <form method="post" class="mx-auto" style="max-width: 600px;">
                <div class="form-group">
                    <label for="nama_barang">Nama Barang:</label>
                    <input type="text" class="form-control" id="nama_barang" name="nama_barang" value="<?php echo $row['namabarang']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="kondisi">Kondisi:</label>
                    <select class="form-control" id="kondisi" name="kondisi" required>
                        <option value="Rusak" <?php if($row['kondisi'] == 'Rusak') echo 'selected'; ?>>Rusak</option>
                        <option value="Kurang Baik" <?php if($row['kondisi'] == 'Kurang Baik') echo 'selected'; ?>>Kurang Baik</option>
                        <option value="Baik" <?php if($row['kondisi'] == 'Baik') echo 'selected'; ?>>Baik</option>
                        <option value="Sangat Baik" <?php if($row['kondisi'] == 'Sangat Baik') echo 'selected'; ?>>Sangat Baik</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo $row['jumlah']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Barang</button>
                <a href="databarang.php" class="btn btn-secondary btn-block">Kembali ke Data Barang</a>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>