<?php
// Konfigurasi koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "antrian";

// Membuat koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mendapatkan satu data terbaru dari tabel messages
$sql = "SELECT id, message, created_at FROM messages ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

$response = array();

if ($result->num_rows > 0) {
    // Ambil baris pertama
    $row = $result->fetch_assoc();
    $response = array(
        'id' => $row["id"],
        'message' => $row["message"],
        'created_at' => $row["created_at"]
    );
} else {
    $response = array('message' => 'Tidak ada data');
}

// Menutup koneksi database
$conn->close();

// Kembalikan data dalam format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
