<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

include 'config/database.php';

$user_id =
    $_SESSION['user']['id'];

/* ADD TO CART */
if (isset($_GET['id'])) {

    $book_id = $_GET['id'];

    // cek apakah buku sudah ada di cart
    $cek = mysqli_query(
        $conn,
        "SELECT *
        FROM cart
        WHERE user_id='$user_id'
        AND buku_id='$book_id'"
    );

    if (mysqli_num_rows($cek) > 0) {

        // update qty kalau sudah ada
        mysqli_query(
            $conn,
            "UPDATE cart
            SET qty = qty + 1
            WHERE user_id='$user_id'
            AND buku_id='$book_id'"
        );
    } else {

        // insert baru
        mysqli_query(
            $conn,
            "INSERT INTO cart(
            user_id,
            buku_id,
            qty
            ) VALUES(
            '$user_id',
            '$book_id',
            1
            )"
        );
    }

    header("Location: cart.php");
    exit;
}

/* DELETE ITEM */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM cart
        WHERE id='$id'"
    );

    header("Location: cart.php");
    exit;
}

/* GET CART */
$query = mysqli_query(
    $conn,
    "SELECT
    cart.id AS cart_id,
    cart.qty,
    buku.judul,
    buku.harga,
    buku.gambar
    FROM cart
    JOIN buku
    ON cart.buku_id = buku.id
    WHERE cart.user_id='$user_id'"
);

$total = 0;
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

    <h2 class="fw-bold mb-4">
        🛒 Keranjang Saya
    </h2>

    <div class="card shadow-sm border-0">

        <div class="table-responsive">

            <table class="table align-middle mb-0">

                <thead class="table-dark">

                    <tr>
                        <th>Cover</th>
                        <th>Buku</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>

                </thead>

                <tbody>

                    <?php while ($cart =
                        mysqli_fetch_assoc($query)
                    ) :

                        $subtotal =
                            $cart['harga']
                            *
                            $cart['qty'];

                        $total += $subtotal;
                    ?>

                        <tr>

                            <td width="100">

                                <img
                                    src="<?= !empty($cart['gambar'])
                                                ? 'uploads/' .
                                                $cart['gambar']
                                                : 'https://placehold.co/80x100'; ?>"
                                    width="60"
                                    height="80"
                                    style="object-fit:cover"
                                    class="rounded shadow-sm">

                            </td>

                            <td>

                                <?= $cart['judul']; ?>

                            </td>

                            <td>

                                Rp <?= number_format(
                                        $cart['harga']
                                    ); ?>

                            </td>

                            <td>

                                <?= $cart['qty']; ?>

                            </td>

                            <td>

                                Rp <?= number_format(
                                        $subtotal
                                    ); ?>

                            </td>

                            <td>

                                <a
                                    href="cart.php?delete=<?= $cart['cart_id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus buku dari keranjang?')">

                                    Hapus

                                </a>

                            </td>

                        </tr>

                    <?php endwhile; ?>

                </tbody>

            </table>

        </div>

    </div>

    <div class="text-end mt-4">

        <h4 class="fw-bold">

            Total:
            <span class="text-primary">

                Rp <?= number_format(
                        $total
                    ); ?>

            </span>

        </h4>

        <?php if ($total > 0) : ?>

            <a
                href="checkout.php"
                class="btn btn-success px-4">

                Checkout

            </a>

        <?php endif; ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>