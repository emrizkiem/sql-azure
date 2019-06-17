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
    $koneksi = mysqli_connect('localhost', 'root', '', 'buku') or die(mysqli_error($link));

    function tambah_data($koneksi)
    {
        if (isset($_POST['simpan'])) { 
            $id = time();
            $iNamaBuku = $_POST['iNamaBuku'];
            $iPenulis = $_POST['iPenulis'];
            $iPenerbit = $_POST['iPenerbit'];
            $iTahunTerbit = $_POST['iTahunTerbit'];

            if(!empty($iNamaBuku) && !empty($iPenulis) && !empty($iPenerbit) && !empty($iTahunTerbit)) {
                $sql = "INSERT INTO buku (id_buku, judul, penulis, penerbit, tahun_terbit) VALUES(".$id.",'".$iNamaBuku."','".$iPenulis."','".$iPenerbit."','".$iTahunTerbit."')";
            
                $save = mysqli_query($koneksi, $sql);

                // var_dump($koneksi);

                if($save && isset($_GET['aksi'])) {
                    if($_GET['aksi'] == 'create') {
                        header('location: index.php');
                    }
                } 
            } else {
                $pesan = "Tidak bisa menyimpan, data masih ada yang kosong!";
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
                </label><br>
                <p style="font-size: 14px; font-style: bold|italic; color: red;"><?php echo isset($pesan) ? $pesan : "" ?></p>
            </form>
        <?php
    }

    function tampil_data($koneksi) {
        $sql = "SELECT * FROM buku";
        $query = mysqli_query($koneksi, $sql);

        echo'
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
                while($row = mysqli_fetch_array($query)) {
                    echo'
                        <tr>
                            <td align="center">'.$no.'</td>
                            <td align="center">'.$row['judul'].'</td>
                            <td align="center">'.$row['penulis'].'</td>
                            <td align="center">'.$row['penerbit'].'</td>
                            <td align="center">'.$row['tahun_terbit'].'</td>
                        </tr>';
                        $no++;
                }
        echo'
                </tbody>
            </table>';    
    }

    if(isset($_GET['aksi'])) {
        switch($_GET['aksi']) {
            case "create":
                echo '<a href="index.php"> &laquo; Home</a>';
                tambah_data($koneksi);
                break;
            case "read":
                tampil_data($koneksi);
                break;
            default:
                // echo "<h3>Aksi <i>".$_GET['aksi']."</i> tidaka ada!</h3>";
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