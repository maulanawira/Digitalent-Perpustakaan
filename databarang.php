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
$order = isset($_GET['order']) ? $_GET['order'] : 'id_barang';
$direction = isset($_GET['direction']) ? $_GET['direction'] : 'ASC';

$allowed_orders = ['id_barang', 'namabarang', 'kondisi', 'jumlah'];
if (!in_array($order, $allowed_orders)) {
    $order = 'id_barang';
}
$direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';

$sql = "SELECT * FROM barang WHERE 
        id_barang LIKE '%$search%' OR 
        namabarang LIKE '%$search%' OR 
        kondisi LIKE '%$search%' OR 
        jumlah LIKE '%$search%'
        ORDER BY $order $direction";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventaris Barang Perpustakaan Ceria</title>
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
                    <a class="nav-link" href="dashboard.php" style="color: #000000;">Data Buku</a>
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
            <div id="clock" class="text-center mt-3" style="color: #000000;"></div> 
        </div>
        <div class="col-md-10 content">
            <div class="dashboard-header">
                <h2 class="dashboard-title">Inventaris Barang Perpustakaan Ceria</h2>
                <form method="GET" action="" class="search-bar">
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Cari barang..." value="<?php echo htmlspecialchars($search); ?>">
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
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=id_barang&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Id Barang <span class="sort-icon"><?php echo $order === 'id_barang' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=namabarang&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Nama Barang <span class="sort-icon"><?php echo $order === 'namabarang' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=kondisi&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Kondisi <span class="sort-icon"><?php echo $order === 'kondisi' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th><a href="?search=<?php echo urlencode($search); ?>&order=jumlah&direction=<?php echo $direction === 'ASC' ? 'DESC' : 'ASC'; ?>">Jumlah <span class="sort-icon"><?php echo $order === 'jumlah' ? ($direction === 'ASC' ? '▲' : '▼') : ''; ?></span></a></th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id_barang"] . "</td>";
                            echo "<td>" . $row["namabarang"] . "</td>";
                            echo "<td>" . $row["kondisi"] . "</td>";
                            echo "<td>" . $row["jumlah"] . "</td>";
                            echo "<td>";
                            echo "<a href='edit_barang.php?id_barang=" . $row["id_barang"] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                            echo "<a href='hapus_barang.php?id_barang=" . $row["id_barang"] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus barang ini?\")'>Hapus</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' class='text-center'>No data found</td></tr>";
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