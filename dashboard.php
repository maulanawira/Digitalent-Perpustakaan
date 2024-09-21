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

$search = isset($_GET['search']) ? $_GET['search'] : '';
$order = isset($_GET['order']) ? $_GET['order'] : 'id_buku';
$direction = isset($_GET['direction']) ? $_GET['direction'] : 'ASC';

$allowed_orders = ['id_buku', 'judul_buku', 'pengarang', 'penerbit', 'kategori', 'tahun', 'jumlah'];
if (!in_array($order, $allowed_orders)) {
    $order = 'id_buku';
}
$direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM buku WHERE 
        id_buku LIKE '%$search%' OR 
        judul_buku LIKE '%$search%' OR 
        pengarang LIKE '%$search%' OR 
        penerbit LIKE '%$search%' OR 
        kategori LIKE '%$search%' OR 
        tahun LIKE '%$search%' OR 
        jumlah LIKE '%$search%'
        ORDER BY $order $direction";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventaris Perpustakaan Ceria</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styledashboard.css">
    <style>
        .search-bar {
            width: 300px;
            display: inline-block;
            vertical-align: middle;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .dashboard-title {
            margin: 0;
        }

        .sort-icon {
            cursor: pointer;
            margin-left: 5px;
            color: black;
        }

        th a {
            color: black;
            text-decoration: none;
        }

        th a:hover {
            text-decoration: none;
        }
    </style>
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
            <div id="clock" class="text-center mt-3" style="color: #000000;"></div> 
        </div>
        <div class="col-md-10 content">
            <div class="dashboard-header">
                <h2 class="dashboard-title">Inventaris Buku Perpustakaan Ceria</h2>
                <form method="GET" action="" class="search-bar">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Cari buku..." value="<?php echo htmlspecialchars($search); ?>">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                    <input type="hidden" name="order" value="<?php echo htmlspecialchars($order); ?>">
                    <input type="hidden" name="direction" value="<?php echo htmlspecialchars($direction); ?>">
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>No</th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=id_buku&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Id Buku <span class="sort-icon"><?php echo $order === 'id_buku' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=judul_buku&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Judul Buku <span class="sort-icon"><?php echo $order === 'judul_buku' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=pengarang&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Pengarang <span class="sort-icon"><?php echo $order === 'pengarang' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=penerbit&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Penerbit <span class="sort-icon"><?php echo $order === 'penerbit' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=kategori&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Kategori <span class="sort-icon"><?php echo $order === 'kategori' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=tahun&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Tahun <span class="sort-icon"><?php echo $order === 'tahun' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=jumlah&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Jumlah <span class="sort-icon"><?php echo $order === 'jumlah' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no . "</td>";
                            echo "<td>" . $row["id_buku"] . "</td>";
                            echo "<td>" . $row["judul_buku"] . "</td>";
                            echo "<td>" . $row["pengarang"] . "</td>";
                            echo "<td>" . $row["penerbit"] . "</td>";
                            echo "<td>" . $row["kategori"] . "</td>";
                            echo "<td>" . $row["tahun"] . "</td>";
                            echo "<td>" . $row["jumlah"] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_buku.php?id_buku=" . $row["id_buku"] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                            echo "<a href='hapus_buku.php?id_buku=" . $row["id_buku"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus buku ini?\")'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No data found</td></tr>";
                    }
                    ?>
                </tbody>
                </table>
            </div>
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

<?php
$conn->close();
?>
