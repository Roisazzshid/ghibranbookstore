<?php
session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit;
}

include '../config/database.php';

$query = mysqli_query(
    $conn,
    "SELECT * FROM users
    ORDER BY id DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
<title>Data User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<h2 class="mb-4">
Data User
</h2>

<a href="index.php"
class="btn btn-secondary mb-3">
Kembali
</a>

<div class="card shadow-sm">

<div class="table-responsive">

<table class="table table-bordered mb-0">

<thead class="table-dark">
<tr>
<th>No</th>
<th>Nama</th>
<th>Email</th>
<th>Tanggal</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;
while($user =
mysqli_fetch_assoc($query)) :
?>

<tr>
<td><?= $no++ ?></td>
<td><?= $user['fullname'] ?></td>
<td><?= $user['email'] ?></td>
<td><?= $user['created_at'] ?></td>
</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>
</div>

</div>
</body>
</html>