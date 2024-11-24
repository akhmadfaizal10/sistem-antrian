<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "antrian";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pastikan menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari POST dan validasi
    $data = $_POST['data'] ?? '';

    if (!empty($data)) {
        // Siapkan statement untuk menghindari SQL Injection
        $stmt = $conn->prepare("INSERT INTO messages (message) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $data); // "s" menunjukkan bahwa parameter adalah string

            if ($stmt->execute()) {
                echo "Data berhasil dimasukkan";
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Data tidak boleh kosong";
    }
} else {
    echo "Metode permintaan tidak valid.";
}

$conn->close();
?>
