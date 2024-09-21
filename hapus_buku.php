<?php
$conn = new mysqli("localhost", "root", "", "perpustakaan");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_buku = $_GET['id_buku'];

$sql_delete = "DELETE FROM buku WHERE id_buku='$id_buku'";

if ($conn->query($sql_delete) === TRUE) {
    $kode_kategori = substr($id_buku, 0, 1);

    $sql_reorder = "SELECT * FROM buku WHERE LEFT(id_buku, 1) = '$kode_kategori' ORDER BY id_buku ASC";
    $result = $conn->query($sql_reorder);

    if ($result->num_rows > 0) {
        $new_id = 1;
        while($row = $result->fetch_assoc()) {
            $new_id_buku = $kode_kategori . str_pad($new_id, 3, "0", STR_PAD_LEFT);

            $sql_update = "UPDATE buku SET id_buku='$new_id_buku' WHERE id_buku='" . $row['id_buku'] . "'";
            $conn->query($sql_update);

            $new_id++;
        }
    }

    header("Location: dashboard.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>