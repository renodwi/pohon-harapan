<?php
// Nama file database SQLite
$dbname = 'database.db';

// Membuat koneksi ke SQLite
$conn = new SQLite3($dbname);

// Mengecek koneksi
if (!$conn) {
    die("Koneksi gagal: " . $conn->lastErrorMsg());
}

// Contoh query yang akan dijalankan
$sql = 'CREATE TABLE IF NOT EXISTS pohon_harapan (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    gugus TEXT NOT NULL,
    nama TEXT NOT NULL,
    harapan TEXT NOT NULL
)';

// Menjalankan query
$result = $conn->exec($sql);

if (!$result) {
    die("Query gagal: " . $conn->lastErrorMsg());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kotak & Pohon Harapan</title>
    <link href="./output.css" rel="stylesheet">
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>
    <link rel="shortcut icon" href="./pohon.jpg" type="image/x-icon">
</head>
<body class="">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gray-100 md:hidden">
        <form class="bg-white p-6 rounded shadow-md w-full max-w-lg mt-5" action="index.php" method="post">
            <div class="flex justify-center mb-5">
                <img src="./pohon.jpg" class="w-1/3">
            </div>
            <div class="flex justify-center mb-5">
                <h2 class="text-2xl font-bold mb-6 text-gray-700">Kotak & Pohon Harapan</h2>
            </div>
            <div class="mb-4">
                <label for="gugus" class="block text-gray-700 font-bold mb-2">Gugus</label>
                <select id="gugus" name="gugus" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="" selected disabled>Belum Dipilih</option>
                    <option value="Gugus 1">Gugus 1</option>
                    <option value="Gugus 2">Gugus 2</option>
                    <option value="Gugus 3">Gugus 3</option>
                    <option value="Gugus 4">Gugus 4</option>
                    <option value="Gugus 5">Gugus 5</option>
                    <option value="Gugus 6">Gugus 6</option>
                    <option value="Gugus 7">Gugus 7</option>
                    <option value="Gugus 8">Gugus 8</option>
                    <option value="Gugus 9">Gugus 9</option>
                    <option value="Gugus 10">Gugus 10</option>
                    <option value="Gugus 11">Gugus 11</option>
                    <option value="Gugus 12">Gugus 12</option>
                </select>
            </div>
            <div class="mb-5">
                <label for="nama" class="block text-gray-700 font-bold mb-2">Nama</label>
                <input type="text" id="nama" name="nama" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Muhammad Sebastian Verstappen" required>
                <p class="text-gray-400">Masukkan nama kamu disini sesuai dengan contoh.</p>
            </div>
            <div class="mb-5">
                <label for="harapan" class="block text-gray-700 font-bold mb-2">Harapan semasa bersekolah di SMA Negeri 1 Demak</label>
                <textarea id="harapan" name="harapan" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500" required></textarea>
                <p class="text-gray-400">Masukkan harapan kamu selama sekolah di SMA Negeri 1 Demak ini.</p>
            </div>
            <div class="mb-5">
                <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Kirim
                </button>
            </div>
        </form>

        <div id="harapanList" class="mt-5">
            <h1 class="font-semibold">10 siswa terbaru yang telah mengisi.</h1>
        </div>

        <?php 
            $sql = "SELECT * FROM pohon_harapan ORDER BY id DESC LIMIT 10";
            $result = $conn->query($sql);
            // Periksa jika ada data yang ditemukan
            if ($result) {
                $rows_found = false;
                while ($rows = $result->fetchArray(SQLITE3_ASSOC)) {
                    $rows_found = true;
                    echo '<div class="w-full max-w-lg mt-5">
                        <div class="bg-white p-6 rounded-xl shadow-xl ml-5 mr-5">
                            <div class="flex">
                                <div class="p-2 bg-red-500 flex rounded-full mr-2"></div>  
                                <div class="p-2 bg-orange-500 flex rounded-full mr-2"></div> 
                                <div class="p-2 bg-green-500 flex rounded-full mr-2"></div> 
                            </div>
                            <div class="flex justify-center mb-5">
                                <h1 class="text-lg font-semibold">'.$rows['gugus'].' | '.$rows['nama'].'</h1>
                            </div>
                            <div>
                                <p>'.$rows['harapan'].'</p>
                            </div>
                        </div>
                    </div>';; // Ganti ini dengan pemrosesan data yang sesuai
                }
                if (!$rows_found) {
                    echo "Tidak ada data yang ditemukan.";
                }
            } else {
                echo "Query gagal: " . $conn->lastErrorMsg();
            }
        ?>

        <footer class="mt-10 mb-10">
            <h1 class="text-gray-500 text-center"><?php $sql = "SELECT COUNT(*) AS jumlah_pohon_harapan FROM pohon_harapan"; $result = $conn->query($sql); if ($result) { $row = $result->fetchArray(SQLITE3_ASSOC); if ($row) { echo $row["jumlah_pohon_harapan"]; } else { echo "0"; } }?> siswa telah mengisi ini</h1>
            <h1 class="text-gray-500 text-center">&copy; MPLS SMANSADE 2024. All rights reserved</h1>
        </footer>
    </div>
    <div class="hidden md:block">
        <h1 class="text-4xl font-extrabold">
            Mohon maaf, tampilan website hanya dibuat untuk tampilan mobile phone saja 
        </h1>
    </div>
</body>
</html>

<?php 
if ($_SERVER["REQUEST_METHOD"] === "POST")
{
    $gugus = $_POST['gugus'];
    $nama = $_POST['nama'];
    $harapan = $_POST['harapan'];

    // Nama file database SQLite
    $dbname = 'database.db';

    // Mengecek koneksi
    if (!$conn) {
        die("Koneksi gagal: " . $conn->lastErrorMsg());
    }

    // Menyiapkan pernyataan SQL untuk insert
    $sql = "INSERT INTO pohon_harapan (gugus, nama, harapan) VALUES (:gugus, :nama, :harapan)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Mengikat parameter ke pernyataan SQL
        $stmt->bindValue(':gugus', $gugus, SQLITE3_TEXT);
        $stmt->bindValue(':nama', $nama, SQLITE3_TEXT);
        $stmt->bindValue(':harapan', $harapan, SQLITE3_TEXT);

        // Mengeksekusi pernyataan
        if (!$stmt->execute()) {
            echo "Error: " . $conn->lastErrorMsg();
        } else {
            echo 
            '
            <script>
                Swal.fire({
                    title: "Sukses",
                    icon: "success",
                    text: "Harapan anda telah dikirim, semoga harapan anda dapat menjadi kenyataan."
                }).then((result) => {
                    if(result.isConfirmed) {
                        window.location.href = "./back.php";
                    }
                });
            </script>
            ';
        }

        // Menutup pernyataan
        $stmt->close();
    } else {
        echo "Error: " . $conn->lastErrorMsg();
    }

    // Menutup koneksi
    $conn->close();
}
?>
