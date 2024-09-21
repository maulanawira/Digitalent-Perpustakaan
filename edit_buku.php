<?php
$conn = new mysqli("localhost", "root", "", "perpustakaan");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_buku = $_GET['id_buku'];
$sql = "SELECT * FROM buku WHERE id_buku='$id_buku'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

function getKodeKategori($kategori) {
    return strtoupper(substr($kategori, 0, 1));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul_buku = $_POST["judul_buku"];
    $pengarang = $_POST["pengarang"];
    $penerbit = $_POST["penerbit"];
    $kategori = $_POST["kategori"];
    $tahun = $_POST["tahun"];
    $jumlah = $_POST["jumlah"];

    $kode_kategori = getKodeKategori($kategori);

    $result = $conn->query("SELECT COUNT(*) as total FROM buku WHERE kategori = '$kategori'");
    $row_count = $result->fetch_assoc();
    $total_buku = $row_count['total'] + 1;

    $id_buku_baru = $kode_kategori . str_pad($total_buku, 3, '0', STR_PAD_LEFT);

    $update_sql = "UPDATE buku SET id_buku='$id_buku_baru', judul_buku='$judul_buku', pengarang='$pengarang', penerbit='$penerbit', kategori='$kategori', tahun='$tahun', jumlah='$jumlah' WHERE id_buku='$id_buku'";

    if ($conn->query($update_sql) === TRUE) {
        header("Location: dashboard.php");
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
    <title>Edit Buku - Inventaris Perpustakaan Ceria</title>
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
                    <a class="nav-link active" href="dashboard.php" style="color: #000000;">Data Buku</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tambahdata.php" style="color: #000000;">Tambah Data Buku</a>
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
        </div>
        <div class="col-md-10 content">
            <h2 class="text-center py-3">Edit Buku</h2>
            <form method="post" class="mx-auto" style="max-width: 600px;">
                <div class="form-group">
                    <label for="judul_buku">Judul Buku:</label>
                    <input type="text" class="form-control" id="judul_buku" name="judul_buku" value="<?php echo $row['judul_buku']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="pengarang">Pengarang:</label>
                    <input type="text" class="form-control" id="pengarang" name="pengarang" value="<?php echo $row['pengarang']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="penerbit">Penerbit:</label>
                    <input type="text" class="form-control" id="penerbit" name="penerbit" value="<?php echo $row['penerbit']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Kategori:</label>
                    <select class="form-control" id="kategori" name="kategori" required>
                        <option value="Agama" <?php if($row['kategori'] == 'Agama') echo 'selected'; ?>>Agama</option>
                        <option value="Teknologi" <?php if($row['kategori'] == 'Teknologi') echo 'selected'; ?>>Teknologi</option>
                        <option value="Sejarah" <?php if($row['kategori'] == 'Sejarah') echo 'selected'; ?>>Sejarah</option>
                        <option value="Pendidikan" <?php if($row['kategori'] == 'Pendidikan') echo 'selected'; ?>>Pendidikan</option>
                        <option value="Cerpen" <?php if($row['kategori'] == 'Cerpen') echo 'selected'; ?>>Cerpen</option>
                        <option value="Novel" <?php if($row['kategori'] == 'Novel') echo 'selected'; ?>>Novel</option>
                        <option value="Budidaya" <?php if($row['kategori'] == 'Budidaya') echo 'selected'; ?>>Budidaya</option>
                        <option value="Komik" <?php if($row['kategori'] == 'Komik') echo 'selected'; ?>>Komik</option>
                        <option value="Ensiklopedia" <?php if($row['kategori'] == 'Ensiklopedia') echo 'selected'; ?>>Ensiklopedia</option>
                        <option value="Majalah" <?php if($row['kategori'] == 'Majalah') echo 'selected'; ?>>Majalah</option>
                        <option value="Lain-Lain" <?php if($row['kategori'] == 'Lain-Lain') echo 'selected'; ?>>Lain-Lain</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tahun">Tahun:</label>
                    <input type="number" class="form-control" id="tahun" name="tahun" value="<?php echo $row['tahun']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo $row['jumlah']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Update Buku</button>
                <a href="dashboard.php" class="btn btn-secondary btn-block">Kembali ke Dashboard</a>
            </form>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>