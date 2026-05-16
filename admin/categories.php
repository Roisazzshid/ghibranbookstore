<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

include '../config/database.php';

/* CREATE */
if(isset($_POST['add'])){

    $kategori = mysqli_real_escape_string(
        $conn,
        $_POST['kategori']
    );

    mysqli_query(
        $conn,
        "INSERT INTO kategori(
            nama_kategori
        ) VALUES(
            '$kategori'
        )"
    );

    header("Location: categories.php");
    exit;
}

/* DELETE */
if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM kategori
        WHERE id='$id'"
    );

    header("Location: categories.php");
    exit;
}

/* UPDATE */
if(isset($_POST['update'])){

    $id = $_POST['id'];

    $kategori =
    mysqli_real_escape_string(
        $conn,
        $_POST['kategori']
    );

    mysqli_query(
        $conn,
        "UPDATE kategori
        SET nama_kategori='$kategori'
        WHERE id='$id'"
    );

    header("Location: categories.php");
    exit;
}

/* DATA */
$query = mysqli_query(
    $conn,
    "SELECT *
    FROM kategori
    ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>

<title>Kategori Buku</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2 class="fw-bold">
            Kategori Buku
        </h2>

        <div>

            <a
            href="index.php"
            class="btn btn-secondary">

                Dashboard

            </a>

            <button
            class="btn btn-primary"
            data-bs-toggle="modal"
            data-bs-target="#addModal">

                + Tambah Kategori

            </button>

        </div>

    </div>

    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-dark">

                    <tr>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th width="180">
                            Aksi
                        </th>
                    </tr>

                </thead>

                <tbody>

                <?php while($row = mysqli_fetch_assoc($query)) : ?>

                <tr>

                    <td>
                        <?= $row['id'] ?>
                    </td>

                    <td>
                        <?= $row['nama_kategori'] ?>
                    </td>

                    <td>

                        <button
                        class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#edit<?= $row['id'] ?>">

                            Edit

                        </button>

                        <a
                        href="categories.php?delete=<?= $row['id'] ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Yakin hapus kategori?')">

                            Hapus

                        </a>

                    </td>

                </tr>

                <!-- Modal Edit -->
                <div
                class="modal fade"
                id="edit<?= $row['id'] ?>">

                    <div class="modal-dialog">

                        <div class="modal-content">

                            <form method="POST">

                                <div class="modal-header">

                                    <h5>
                                        Edit Kategori
                                    </h5>

                                    <button
                                    type="button"
                                    class="btn-close"
                                    data-bs-dismiss="modal">
                                    </button>

                                </div>

                                <div class="modal-body">

                                    <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $row['id'] ?>">

                                    <label class="mb-2">
                                        Nama Kategori
                                    </label>

                                    <input
                                    type="text"
                                    name="kategori"
                                    class="form-control"
                                    value="<?= $row['nama_kategori'] ?>"
                                    required>

                                </div>

                                <div class="modal-footer">

                                    <button
                                    type="button"
                                    class="btn btn-secondary"
                                    data-bs-dismiss="modal">

                                        Batal

                                    </button>

                                    <button
                                    type="submit"
                                    name="update"
                                    class="btn btn-primary">

                                        Update

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

<!-- Modal Tambah -->
<div
class="modal fade"
id="addModal">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="POST">

                <div class="modal-header">

                    <h5>
                        Tambah Kategori
                    </h5>

                    <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <label class="mb-2">
                        Nama Kategori
                    </label>

                    <input
                    type="text"
                    name="kategori"
                    class="form-control"
                    required>

                </div>

                <div class="modal-footer">

                    <button
                    type="button"
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                    type="submit"
                    name="add"
                    class="btn btn-primary">

                        Simpan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>