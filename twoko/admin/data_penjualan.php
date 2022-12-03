<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/dataProduk.css">
    <link rel="stylesheet" href="./css/navbar.css">

    <!-- Kit Font Awesome -->
    <script src="https://kit.fontawesome.com/1a01d4b743.js" crossorigin="anonymous"></script>

</head>
<body>
    <?php
        include "navbar.php";
    ?>
    <div class="container my-3">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center mt-2 mb-3">Data Pelanggan<h3>
                <form action="data_produk.php" method="post">
                    <input type="text" name="cari" class="form-control mb-3" placeholder="Masukkan keyword pencarian">
                </form>
            </div>
            <div class='card-body'>
                <table class="table table-bordered fs-5 fw-light text-center">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nama Pelanggan</th>
                        <th scope="col">Foto Produk</th>
                        <th scope="col">Tanggal Beli</th>
                        <th scope="col">Tanggal Datang</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Hapus</th>
                        <th scope="col" width="100px">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    include "../connection.php";
                    global $conn;
                    if (isset($_POST["cari"])) {
                        // jika ada keyword pencarian
                        $cari=$_POST['cari'];
                        $query_transaksi= mysqli_query($conn,"SELECT * from transaksi where id_transaksi like '%$cari%' or id_register like '%$cari%' or tgl_transaksi like '%$cari%'");
                    }else{
                        //jika tidak ada keyword pencarian
                        $query_transaksi= mysqli_query($conn,"SELECT * from transaksi join register on register.id_register= register.id_register ORDER BY id_transaksi DESC;") or die (mysqli_error($conn));
                    }
                        $no=0;
                        // echo mysqli_num_rows($query_transaksi);
                        while($data_transaksi=mysqli_fetch_array($query_transaksi)){
                            $no++;
                            $query_detail = mysqli_query($conn, "SELECT * FROM detail_transaksi d JOIN produk p ON p.id_produk = d.id_produk WHERE id_transaksi = '".$data_transaksi['id_transaksi']."' group by nama_produk");
                            // echo mysqli_num_rows($query_detail);
                        ?>
                        <tr>
                            <td><?=$no?></td>
                            <td><?php echo $data_transaksi["nama"]; ?></td>
                            <td>
                                <?php
                                while($data_detail = mysqli_fetch_array($query_detail)){
                                ?>
                                    <img src="../admin/img/<?=$data_detail['foto_produk']?>" class="img-fluid rounded-start" width="150px" height="150px" alt="">
                                <?php
                                }
                                ?>
                            </td>
                            <td><?php echo $data_transaksi["tgl_transaksi"]; ?></td>
                            <td><?php echo $data_transaksi["tgl_datang"]; ?></td>
                            <td><?= $data_transaksi["alamat"]; ?></td>
                            <td><a href="hapus_Penjualan.php?id_transaksi=<?=$data_transaksi ['id_transaksi']?>" onclick="return confirm('Are you sure want to delete this order?')"><i class="fa-solid fa-trash text-red"></i></a>
                            </td>      
                            <?php
                            if ($data_transaksi['status'] == "New"):
                                ?>
                                    <td><a href="acc.php?id_transaksi=<?=$data_transaksi ['id_transaksi']?>" class="btn btn-outline-danger">
                                        <?= $data_transaksi['status'] ?></a>
                                    </td><?php
                            elseif ($data_transaksi['status'] == "Confirm"):
                                ?>
                                    <td><a href="acc.php?id_transaksi=<?=$data_transaksi ['id_transaksi']?>" class="btn btn-outline-danger">
                                        <?= $data_transaksi['status'] ?></a>
                                    </td>
                                    <?php
                            elseif ($data_transaksi['status'] == "Process"):
                                ?>
                                    <td><a href="acc.php?id_transaksi=<?=$data_transaksi ['id_transaksi']?>" class="btn btn-outline-danger">
                                        <?= $data_transaksi['status'] ?></a>
                                    </td>
                                    <?php
                            elseif ($data_transaksi['status'] == "Done"):
                                ?>
                                    <td><a href="acc.php?id_transaksi=<?=$data_transaksi ['id_transaksi']?>" class="btn btn-outline-danger">
                                        <?= $data_transaksi['status'] ?></a>
                                    </td><?php
                            elseif ($data_transaksi['status'] == "Receive"):
                                ?>
                                <td><div class="alert alert-success" role="alert"><?= $data_transaksi['status'] ?></div>
                            <?php endif; ?>
                                <?php
                                include "../connection.php";
                                ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
    </html