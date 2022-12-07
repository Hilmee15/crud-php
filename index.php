<!-- PHP Code -->
<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "datasiswa";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) {
    die("Disconnected to the Database");
}

$nis = "";
$nama = "";
$alamat = "";
$kelas = "";
$error = "";
$sukses = "";

// To edit the data
if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id = $_GET['id'];
    $sql1 = "delete from siswa where id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil menghapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}


if ($op == 'edit') {
    $id = $_GET['id'];
    $crud1 = "select * from siswa where id = '$id'";
    $c1 = mysqli_query($koneksi, $crud1);
    $r1 = mysqli_fetch_array($c1);
    $nis = $r1['nis'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $kelas = $r1['kelas'];

    if ($nis == "") {
        $error = "Data tidak ditemukan!";
    }
}

// To create the data
if (isset($_POST['simpan'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kelas = $_POST['kelas'];

    // To check is the database successfully insert the data
    if ($nis && $nama && $alamat && $kelas) {
        if ($op == 'edit') {
            $crud1 = "Update siswa set nis='$nis', nama='$nama', alamat='$alamat', kelas='$kelas' where id = '$id'";
            $cr1 = mysqli_query($koneksi, $crud1);
            if ($cr1) {
                $sukses = "Data Berhasil di Update";
            } else {
                $error = "Data gagal di Update";
            }
        } else {
            $crud1 = "insert into siswa(nis, nama, alamat, kelas) value ('$nis', '$nama', '$alamat', '$kelas')";
            $c1 = mysqli_query($koneksi, $crud1);
            if ($c1) {
                $sukses = "Berhasil memasukkan data";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan Masukkan Semua Data";
    }
}

?>
<!-- PHP Code -->

<!-- HTML Code -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<!-- The additional style -->
<style>
    * {
        scroll-behavior: smooth;
    }

    .mx-auto {
        width: 1100px;
    }

    .card {
        margin-top: 20px;
    }

    .btn {
        transition: all .2s ease-in-out;
    }

    .btn:hover {
        background-color: #6c757d;
        font-size: 1.2rem;
        color: white;
        transform: scale(1.1);
    }

    h1 {
        margin-top: 25px;
        font-size: 2.5rem;
        color: #000;
        font-weight: bold;
        text-align: center;
    }
</style>
<!-- The additional style -->

<body>
    <div class="title">
        <h1>Data Siswa</h1>   
    </div>
    <div class="mx-auto">

        <!-- To create the Data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Create / Edit
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
                <?php
                    header("refresh:3;url = index.php");
                }
                ?>

                <?php
                if ($sukses) {
                ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $sukses ?>
                </div>
                <?php
                    header("refresh:3;url = index.php");
                }
                ?>
                <form action="" method="post">
                    <!-- NIS Textbox -->
                    <div class="mb-3 row">
                        <label for="nis" class="col-sm-2 col-form-label">NIS</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nis" name="nis" value="<?php echo $nis ?>">
                        </div>
                    </div>
                    <!-- NIS Textbox -->

                    <!-- Nama Textbox -->
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <!-- Nama Textbox -->

                    <!-- Alamat Textbox -->
                    <div class="mb-3 row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat"
                                value="<?php echo $alamat ?>">
                        </div>
                    </div>
                    <!-- Alamat Textbox -->

                    <!-- Kelas Box -->
                    <div class="mb-3 row">
                        <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kelas" name="kelas">
                                <option value="">--- Choose your Class ---</option>
                                <option value="Kelas X" <?php if ($kelas=="Kelas X") echo "Selected" ?>>Kelas X</option>
                                <option value="Kelas XI" <?php if ($kelas=="Kelas XI") echo "Selected" ?>>Kelas XI
                                </option>
                                <option value="Kelas XII" <?php if ($kelas=="Kelas XII") echo "Selected" ?>>Kelas XII
                                </option>
                            </select>
                        </div>
                    </div>
                    <!-- Kelas Box -->

                    <!-- Save Data Button -->
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-gray" style="border-color: #6c757d; border-radius: 5px; border-width: medium;">
                    </div>
                    <!-- Save Data Button -->

                </form>
            </div>
        </div>

        <!-- To read the Data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Siswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">NO.</th>
                            <th scope="col">NIS</th>
                            <th scope="col">NIS</th>
                            <th scope="col">ALAMAT</th>
                            <th scope="col">KELAS</th>
                            <th scope="col">AKSI</th>
                        </tr>
                    <Tbody>
                        <?php
                        $crud2 = "select * from siswa order by id desc";
                        $c2 = mysqli_query($koneksi, $crud2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($c2)) {
                            $id = $r2['id'];
                            $nis = $r2['nis'];
                            $nama = $r2['nama'];
                            $alamat = $r2['alamat'];
                            $kelas = $r2['kelas'];
                        ?>
                        <tr>
                            <th scope="row">
                                <?php echo $urut++ ?>
                            </th>
                            <td scope="row">
                                <?php echo $nis ?>
                            </td>
                            <td scope="row">
                                <?php echo $nama ?>
                            </td>
                            <td scope="row">
                                <?php echo $alamat ?>
                            </td>
                            <td scope="row">
                                <?php echo $kelas ?>
                            </td>
                            <td scope="row">
                                <!-- Edit Button -->
                                <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button"
                                        class="btn btn-warning">Edit</button></a>
                                <!-- Edit Button -->

                                <!-- Delete Button -->
                                <a href="index.php?op=delete&id=<?php echo $id ?>"
                                    onclick="return confirm('Are you sure want to Delete?')"><button type="button"
                                        class="btn btn-danger">Delete</button></a>
                                <!-- Delete Button -->
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </Tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>

</html>