<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Microsoft Azure | Dicoding</title>
    <style>
        body {
            font-family: Source Code Pro, monospace;
        }

        table {
            border-collapse: collapse;
        }

        th,
        td {
            font-size: 16px;
            border: 1px solid #DEDEDE;
            padding: 3px 5px;
            color: #303030;
        }

        th {
            background: #cccccc;
            font-size: 16px;
            border-color: #b0b0b0;
        }
    </style>
</head>

<body>
    <?php
    $host = "nasyserver.database.windows.net";
    $user = "naysadmin";
    $pass = "emrizkiem1997_";
    $db = "nasydatabase";

    try {
        $koneksi = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
        $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $sth) {
        echo "Failed: " . $sth;
    }

    // $koneksi = mysqli_connect('localhost', 'root', '', 'buku') or die(mysqli_error($link));

    function tambah_data($koneksi)
    {
        if (isset($_POST['simpan'])) {
            try {
                $id = time();
                $iNamaBuku = $_POST['iNamaBuku'];
                $iPenulis = $_POST['iPenulis'];
                $iPenerbit = $_POST['iPenerbit'];
                $iTahunTerbit = $_POST['iTahunTerbit'];

                if (!empty($iNamaBuku) && !empty($iPenulis) && !empty($iPenerbit) && !empty($iTahunTerbit)) {
                    $query = "INSERT INTO buku (id_buku, judul, penulis, penerbit, tahun_terbit) VALUES(?,?,?,?,?)";

                    $stmt = $koneksi->prepare($query);
                    $stmt->bindValue(1, $id);
                    $stmt->bindValue(2, $iNamaBuku);
                    $stmt->bindValue(3, $iPenulis);
                    $stmt->bindValue(4, $iPenerbit);
                    $stmt->bindValue(5, $iTahunTerbit);
                    $stmt->execute();

                    // var_dump($koneksi);

                    if ($query && isset($_GET['aksi'])) {
                        if ($_GET['aksi'] == 'create') {
                            header('location: index.php');
                        }
                    }
                } else {
                    $pesan = "Tidak bisa menyimpan, data masih ada yang kosong!";
                }
            } catch (Exception $sth) {
                echo "Failed: " . $sth;
            }
        }

        ?>

        <h2 style="font-style: bold">Data Buku!</h2>
        <form action="" method="POST">
            <label>Judul Buku <input type="text" name="iNamaBuku" style="font-family: Source Code Pro, monospace; font-size: 16px;"></label><br><br>
            <label>Penulis <input type="text" name="iPenulis" style="font-family: Source Code Pro, monospace; font-size: 16px;"></label><br><br>
            <label>Penerbit <input type="text" name="iPenerbit" style="font-family: Source Code Pro, monospace; font-size: 16px;"></label><br><br>
            <label>Tahun Terbit <input type="text" name="iTahunTerbit" style="font-family: Source Code Pro, monospace; font-size: 16px;"></label><br><br>
            <label>
                <input type="submit" name="simpan" value="Simpan" style="font-family: Source Code Pro, monospace; font-size: 16px;" />
                <input type="reset" name="reset" value="Bersihkan" style="font-family: Source Code Pro, monospace; font-size: 16px;" />
                <input type="button" value="Upload Foto Buku" onclick="window.location='blob.php';" style="font-family: Source Code Pro, monospace; font-size: 16px;" />
                <input type="button" value="Analisis Foto" onclick="window.location='vision.html';" style="font-family: Source Code Pro, monospace; font-size: 16px;" />
            </label><br>
            <p style="font-size: 14px; font-style: bold|italic; color: red;"><?php echo isset($pesan) ? $pesan : "" ?></p>
        </form>
    <?php
}

function tampil_data($koneksi)
{
    try {
        $query = "SELECT * FROM buku";
        $stmt = $koneksi->query($query);
        $databuku = $stmt->fetchAll();
        if (count($databuku) > 0) {
            echo '
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Tahun Terbit</th>
                    </tr>
                </thead>
                <tbody>';
            $no = 1;
            foreach ($databuku as $buku) {
                echo '
                    <tr>
                        <td align="center">' . $no . '</td>
                        <td align="center">' . $buku['judul'] . '</td>
                        <td align="center">' . $buku['penulis'] . '</td>
                        <td align="center">' . $buku['penerbit'] . '</td>
                        <td align="center">' . $buku['tahun_terbit'] . '</td>
                    </tr>';
                $no++;
            }
            echo '
                </tbody>
            </table>';
        }
    } catch (Exception $sth) {
        echo "Failed: " . $sth;
    }
}

if (isset($_GET['aksi'])) {
    switch ($_GET['aksi']) {
        case "create":
            echo '<a href="index.php"> &laquo; Home</a>';
            tambah_data($koneksi);
            break;
        case "read":
            tampil_data($koneksi);
            break;
        default:
            tambah_data($koneksi);
            tampil_data($koneksi);
    }
} else {
    tambah_data($koneksi);
    tampil_data($koneksi);
}
?>

</body>

</html>
