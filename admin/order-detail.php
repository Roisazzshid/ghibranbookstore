<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../config/database.php';

if (!isset($_GET['id'])) {
    header("Location: orders.php");
    exit;
}

$id = intval($_GET['id']);

$query = mysqli_query(
    $conn,
    "SELECT
        detail_transaksi.*,
        buku.judul
    FROM detail_transaksi
    INNER JOIN buku
    ON detail_transaksi.buku_id = buku.id
    WHERE detail_transaksi.transaksi_id = '$id'"
);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Detail Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="d-flex justify-content-between mb-4">

            <h2>Detail Pesanan #<?= $id ?></h2>

            <a href="orders.php"
                class="btn btn-secondary">
                Kembali
            </a>

        </div>

        <div class="card shadow-sm border-0">

            <div class="table-responsive">

                <table class="table table-hover mb-0">

                    <thead class="table-dark">
                        <tr>
                            <th>Judul Buku</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $total = 0;

                        if (mysqli_num_rows($query) > 0) :

                            while ($item =
                                mysqli_fetch_assoc($query)
                            ) :

                                $subtotal =
                                    $item['harga']
                                    *
                                    $item['qty'];

                                $total += $subtotal;
                        ?>

                                <tr>

                                    <td>
                                        <?= $item['judul']; ?>
                                    </td>

                                    <td>
                                        <?= $item['qty']; ?>
                                    </td>

                                    <td>
                                        Rp <?= number_format(
                                                $item['harga']
                                            ); ?>
                                    </td>

                                    <td>
                                        Rp <?= number_format(
                                                $subtotal
                                            ); ?>
                                    </td>

                                </tr>

                            <?php endwhile; ?>

                            <tr class="table-light fw-bold">

                                <td colspan="3"
                                    class="text-end">

                                    Total

                                </td>

                                <td>
                                    Rp <?= number_format(
                                            $total
                                        ); ?>
                                </td>

                            </tr>

                        <?php else : ?>

                            <tr>
                                <td colspan="4"
                                    class="text-center text-danger py-4">

                                    Belum ada detail pesanan

                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>
        </div>

    </div>

</body>

</html>