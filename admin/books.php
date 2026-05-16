<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

include '../config/database.php';

/* CREATE */
if(isset($_POST['add'])){

    $judul = mysqli_real_escape_string($conn,$_POST['judul']);
    $penulis = mysqli_real_escape_string($conn,$_POST['penulis']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $deskripsi = mysqli_real_escape_string($conn,$_POST['deskripsi']);

    mysqli_query(
        $conn,
        "INSERT INTO buku(
            kategori_id,
            judul,
            penulis,
            harga,
            stok,
            deskripsi
        ) VALUES(
            '$kategori',
            '$judul',
            '$penulis',
            '$harga',
            '$stok',
            '$deskripsi'
        )"
    );

    header("Location: books.php");
    exit;
}

/* DELETE */
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM buku
        WHERE id='$id'"
    );

    header("Location: books.php");
    exit;
}

/* UPDATE */
if(isset($_POST['update'])){

    $id = $_POST['id'];

    $judul = mysqli_real_escape_string($conn,$_POST['judul']);
    $penulis = mysqli_real_escape_string($conn,$_POST['penulis']);
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = mysqli_real_escape_string($conn,$_POST['deskripsi']);

    mysqli_query(
        $conn,
        "UPDATE buku SET
        kategori_id='$kategori',
        judul='$judul',
        penulis='$penulis',
        harga='$harga',
        stok='$stok',
        deskripsi='$deskripsi'
        WHERE id='$id'"
    );

    header("Location: books.php");
    exit;
}

/* DATA BUKU */
$query = mysqli_query(
    $conn,
    "SELECT buku.*, kategori.nama_kategori
    FROM buku
    LEFT JOIN kategori
    ON buku.kategori_id = kategori.id
    ORDER BY buku.id DESC"
);

/* DATA KATEGORI */
$kategoriQuery = mysqli_query(
    $conn,
    "SELECT * FROM kategori"
);

$kategoriData = [];
while($kat = mysqli_fetch_assoc($kategoriQuery)){
    $kategoriData[] = $kat;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Buku</title>

    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            Data Buku
        </h2>

        <div>

            <a href="index.php"
            class="btn btn-secondary">
                Dashboard
            </a>

            <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#bookModal">

                + Tambah Buku

            </button>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Penulis</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                <?php while($book = mysqli_fetch_assoc($query)) : ?>

                <tr>

                    <td><?= $book['id'] ?></td>
                    <td><?= $book['judul'] ?></td>
                    <td><?= $book['penulis'] ?></td>
                    <td><?= $book['nama_kategori'] ?></td>
                    <td>Rp <?= number_format($book['harga']) ?></td>
                    <td><?= $book['stok'] ?></td>

                    <td>

                        <button
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#edit<?= $book['id'] ?>">

                            Edit

                        </button>

                        <a
                        href="books.php?delete=<?= $book['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin hapus buku?')">

                            Delete

                        </a>

                    </td>

                </tr>

                <!-- Modal Edit -->
                <div class="modal fade"
                id="edit<?= $book['id'] ?>">

                    <div class="modal-dialog modal-lg">

                        <div class="modal-content">

                            <form method="POST">

                                <div class="modal-header">
                                    <h5>Edit Buku</h5>

                                    <button
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                    </button>
                                </div>

                                <div class="modal-body">

                                    <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $book['id'] ?>">

                                    <div class="row">

                                        <div class="col-md-6 mb-3">
                                            <label>Judul</label>

                                            <input
                                            type="text"
                                            name="judul"
                                            class="form-control"
                                            value="<?= $book['judul'] ?>"
                                            required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Penulis</label>

                                            <input
                                            type="text"
                                            name="penulis"
                                            class="form-control"
                                            value="<?= $book['penulis'] ?>"
                                            required>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label>Kategori</label>

                                            <select
                                            name="kategori"
                                            class="form-control"
                                            required>

                                                <?php foreach($kategoriData as $kat) : ?>

                                                <option
                                                value="<?= $kat['id'] ?>"
                                                <?= $kat['id'] == $book['kategori_id']
                                                ? 'selected' : '' ?>>

                                                    <?= $kat['nama_kategori'] ?>

                                                </option>

                                                <?php endforeach; ?>

                                            </select>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Harga</label>

                                            <input
                                            type="number"
                                            name="harga"
                                            class="form-control"
                                            value="<?= $book['harga'] ?>"
                                            required>
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label>Stok</label>

                                            <input
                                            type="number"
                                            name="stok"
                                            class="form-control"
                                            value="<?= $book['stok'] ?>"
                                            required>
                                        </div>

                                        <div class="col-12">
                                            <label>Deskripsi</label>

                                            <textarea
                                            name="deskripsi"
                                            class="form-control"
                                            rows="4"><?= $book['deskripsi'] ?></textarea>
                                        </div>

                                    </div>

                                </div>

                                <div class="modal-footer">

                                    <button
                                    type="submit"
                                    name="update"
                                    class="btn btn-primary">

                                        Update Buku

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

                <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- Modal Tambah Buku -->
<div class="modal fade" id="bookModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <form method="POST">

                <div class="modal-header">
                    <h5>Tambah Buku</h5>

                    <button
                    class="btn-close"
                    data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label>Judul</label>

                            <input
                            type="text"
                            name="judul"
                            class="form-control"
                            required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Penulis</label>

                            <input
                            type="text"
                            name="penulis"
                            class="form-control"
                            required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Kategori</label>

                            <select
                            name="kategori"
                            class="form-control"
                            required>

                                <option value="">
                                    Pilih Kategori
                                </option>

                                <?php foreach($kategoriData as $kat) : ?>

                                <option
                                value="<?= $kat['id'] ?>">

                                    <?= $kat['nama_kategori'] ?>

                                </option>

                                <?php endforeach; ?>

                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Harga</label>

                            <input
                            type="number"
                            name="harga"
                            class="form-control"
                            required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label>Stok</label>

                            <input
                            type="number"
                            name="stok"
                            class="form-control"
                            required>
                        </div>

                        <div class="col-12">
                            <label>Deskripsi</label>

                            <textarea
                            name="deskripsi"
                            rows="4"
                            class="form-control"></textarea>
                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                    type="submit"
                    name="add"
                    class="btn btn-primary">

                        Simpan Buku

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>