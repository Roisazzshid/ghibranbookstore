<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

include 'config/database.php';

$user_id =
$_SESSION['user']['id'];

if(isset($_GET['id'])){

    $book_id = $_GET['id'];

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

    header("Location: cart.php");
    exit;
}

$query = mysqli_query(
    $conn,
    "SELECT cart.*,
    buku.judul,
    buku.harga
    FROM cart
    JOIN buku
    ON cart.buku_id =
    buku.id
    WHERE cart.user_id=
    '$user_id'"
);

$total = 0;
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

<h2 class="mb-4">
Keranjang Saya
</h2>

<div class="card shadow-sm">

<table class="table">

<thead>
<tr>
<th>Buku</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>
</thead>

<tbody>

<?php while($cart =
mysqli_fetch_assoc($query)) :

$subtotal =
$cart['harga']
*
$cart['qty'];

$total += $subtotal;
?>

<tr>

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

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

<div class="text-end mt-4">

<h3>
Total:
Rp <?= number_format(
$total
); ?>
</h3>

<a
href="checkout.php?total=<?= $total ?>"
class="btn btn-success">

Checkout

</a>

</div>

</div>

<?php include 'includes/footer.php'; ?>