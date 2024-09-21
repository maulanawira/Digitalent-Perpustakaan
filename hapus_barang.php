<?php
$conn = new mysqli("localhost", "root", "", "perpustakaan");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_barang = $_GET['id_barang'];

$sql_delete = "DELETE FROM barang WHERE id_barang='$id_barang'";

if ($conn->query($sql_delete) === TRUE) {
    $sql_reorder = "SELECT * FROM barang ORDER BY id_barang ASC";
    $result = $conn->query($sql_reorder);

    if ($result->num_rows > 0) {
        $new_id = 1;
        while($row = $result->fetch_assoc()) {
            $new_id_barang = str_pad($new_id, 4, "0", STR_PAD_LEFT);

            $sql_update = "UPDATE barang SET id_barang='$new_id_barang' WHERE id_barang='" . $row['id_barang'] . "'";
            $conn->query($sql_update);

            $new_id++;
        }
    }

    header("Location: databarang.php");
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
