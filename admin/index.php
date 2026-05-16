<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

include '../config/database.php';

$totalUser = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM users")
);

$totalBook = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM buku")
);

$totalOrder = mysqli_num_rows(
    mysqli_query($conn,
    "SELECT * FROM transaksi")
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard Admin</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<div class="d-flex justify-content-between mb-4">

<h2>Dashboard Admin</h2>

<a href="logout.php"
class="btn btn-danger">
Logout
</a>

</div>

<div class="row">

<div class="col-md-4">

<div class="card shadow-sm p-4">

<h5>Total User</h5>
<h1><?= $totalUser ?></h1>

</div>
</div>

<div class="col-md-4">

<div class="card shadow-sm p-4">

<h5>Total Buku</h5>
<h1><?= $totalBook ?></h1>

</div>
</div>

<div class="col-md-4">

<div class="card shadow-sm p-4">

<h5>Total Pesanan</h5>
<h1><?= $totalOrder ?></h1>

</div>
</div>

</div>

<hr class="my-5">

<div class="d-flex gap-3">

<a href="users.php"
class="btn btn-primary">
Data User
</a>

<a href="categories.php"
class="btn btn-success">
Kategori Buku
</a>

<a href="books.php"
class="btn btn-warning">
Data Buku
</a>

<a href="orders.php"
class="btn btn-dark">
List Pesanan
</a>

</div>

</div>

</body>
</html>