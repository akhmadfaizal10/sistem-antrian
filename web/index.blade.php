<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Terbaru Antrian</title>
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=8ru1Fbxp"></script>
    <style>
        /* Style umum */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        /* Style tabel */
        #data-table {
            width: 80%;
            max-width: 600px;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        #data-table th, #data-table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        #data-table th {
            background-color: #4CAF50;
            color: white;
        }

        #data-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        #data-table tr:hover {
            background-color: #f1f1f1;
        }

        /* Style tombol */
        .butt {
            padding: 10px 20px;
            margin-top: 20px;
            font-size: 16px;
            font-weight: bold;
            color: #ffffff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .butt:hover {
            background-color: #45a049;
        }

        /* Responsive styling */
        @media (max-width: 600px) {
            #data-table {
                width: 100%;
            }

            .butt {
                width: 100%;
                padding: 12px;
            }
        }
    </style>
</head>
<body>

<h2>Data Terbaru</h2>
<table border="1" id="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Pesan</th>
            <th>Timestamp</th>
        </tr>
    </thead>
    <tbody>
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
        $latestMessage = "";

        if ($result->num_rows > 0) {
            // Ambil baris pertama
            $row = $result->fetch_assoc();
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td id='latestMessage'>" . $row["message"] . "</td>";
            echo "<td>" . $row["created_at"] . "</td>";
            echo "</tr>";
            $latestMessage = $row["message"];
        } else {
            echo "<tr><td colspan='3'>Tidak ada data</td></tr>";
        }

        // Menutup koneksi database
        $conn->close();
        ?>
    </tbody>
</table>

<!-- Button untuk memutar pesan terbaru -->
<button 
  class="butt js--triggerAnimation" 
  onclick="speakLatestMessage()" 
  type="button">Play Latest Message</button> 

<script>
    // Fungsi untuk memutar suara pesan terbaru menggunakan ResponsiveVoice
    function speakLatestMessage() {
        const latestMessage = document.getElementById('latestMessage').innerText; // Ambil pesan terbaru dari tabel
        if (latestMessage) {
            responsiveVoice.speak(latestMessage, "Indonesian Female"); // Memanggil ResponsiveVoice
        } else {
            console.warn("Tidak ada pesan untuk diputar.");
        }
    }

    // Set interval untuk memeriksa data terbaru setiap 5 detik
    setInterval(async function() {
        try {
            // Kirim request untuk mendapatkan pesan terbaru
            const response = await fetch('latest_message.php'); // Endpoint untuk mendapatkan pesan terbaru
            const data = await response.json();

            // Jika pesan baru berbeda dari yang sekarang
            const latestMessageElement = document.getElementById('latestMessage');
            if (data.message !== latestMessageElement.innerText) {
                // Perbarui tabel dengan data terbaru
                const tbody = document.getElementById('data-table').getElementsByTagName('tbody')[0];
                tbody.innerHTML = `
                    <tr>
                        <td>${data.id}</td>
                        <td id="latestMessage">${data.message}</td>
                        <td>${data.created_at}</td>
                    </tr>
                `;
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }, 5000); // Setiap 5 detik
</script>

</body>
</html>
