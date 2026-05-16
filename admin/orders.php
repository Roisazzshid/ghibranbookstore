<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

include '../config/database.php';

$query = mysqli_query(
    $conn,
    "SELECT transaksi.*,
    users.fullname
    FROM transaksi
    LEFT JOIN users
    ON transaksi.user_id =
    users.id
    ORDER BY transaksi.id DESC"
);

if (isset($_POST['update_status'])) {

    $id = $_POST['id'];
    $status = $_POST['status'];

    mysqli_query(
        $conn,
        "UPDATE transaksi
        SET status='$status'
        WHERE id='$id'"
    );

    header("Location: orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>List Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <h2>List Pesanan</h2>

        <a href="index.php"
            class="btn btn-secondary mb-3">
            Kembali
        </a>

        <table class="table table-bordered bg-white">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>

            </thead>

            <tbody>

                <?php while ($order =
                    mysqli_fetch_assoc($query)
                ) : ?>

                    <tr>

                        <td><?= $order['id'] ?></td>

                        <td><?= $order['fullname'] ?></td>

                        <td>
                            Rp <?= number_format(
                                    $order['total']
                                ) ?>
                        </td>

                        <td>

                            <form method="POST">

                                <input
                                    type="hidden"
                                    name="id"
                                    value="<?= $order['id'] ?>">

                                <select
                                    name="status"
                                    class="form-select">

                                    <option
                                        <?= $order['status']
                                            == 'Diproses'
                                            ? 'selected' : '' ?>>

                                        Diproses

                                    </option>

                                    <option
                                        <?= $order['status']
                                            == 'Dikemas'
                                            ? 'selected' : '' ?>>

                                        Dikemas

                                    </option>

                                    <option
                                        <?= $order['status']
                                            == 'Dikirim'
                                            ? 'selected' : '' ?>>

                                        Dikirim

                                    </option>

                                    <option
                                        <?= $order['status']
                                            == 'Selesai'
                                            ? 'selected' : '' ?>>

                                        Selesai

                                    </option>

                                </select>

                                <button
                                    name="update_status"
                                    class="btn btn-sm btn-primary mt-2">

                                    Update

                                </button>

                            </form>

                        </td>

                        <td><?= $order['created_at'] ?></td>

                        <td>

                            <a
                                href="order-detail.php?id=<?= $order['id'] ?>"
                                class="btn btn-sm btn-primary">

                                Detail

                            </a>

                        </td>

                    </tr>

                <?php endwhile; ?>

            </tbody>

        </table>

    </div>
</body>

</html>