<?php
session_start();
include 'config/database.php';

if(!isset($_GET['id'])){
    header("Location: books.php");
}

$id = $_GET['id'];

$query = mysqli_query(
    $conn,
    "SELECT buku.*,
    kategori.nama_kategori
    FROM buku
    LEFT JOIN kategori
    ON buku.kategori_id=
    kategori.id
    WHERE buku.id='$id'"
);

$book = mysqli_fetch_assoc($query);
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

<div class="row">

<div class="col-md-4">

<img
src="https://placehold.co/400x500"
class="img-fluid rounded shadow">

</div>

<div class="col-md-8">

<span class="badge bg-primary mb-3">
<?= $book['nama_kategori']; ?>
</span>

<h2 class="fw-bold">
<?= $book['judul']; ?>
</h2>

<p class="text-muted">
Penulis:
<?= $book['penulis']; ?>
</p>

<h3 class="text-primary fw-bold mb-4">
Rp <?= number_format(
$book['harga']
); ?>
</h3>

<p>
<?= $book['deskripsi']; ?>
</p>

<?php if(isset($_SESSION['user'])) : ?>

<a
href="cart.php?id=<?= $book['id']; ?>"
class="btn btn-success">

+ Add To Cart

</a>

<?php else : ?>

<a
href="login.php"
class="btn btn-primary">

Login untuk beli

</a>

<?php endif; ?>

</div>

</div>

</div>

<?php include 'includes/footer.php'; ?>