<?php

session_start();
include 'config/database.php';

if(isset($_POST['send'])){

    $nama = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['pesan']);

    mysqli_query(
        $conn,
        "INSERT INTO contact_admin(
        nama,email,pesan
        ) VALUES(
        '$nama',
        '$email',
        '$pesan'
        )"
    );

    $success =
    "Pesan berhasil dikirim";
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

<div class="col-md-7 mx-auto">

<div class="card shadow p-4">

<h2 class="mb-4">
Hubungi Admin
</h2>

<?php
if(isset($success)){
echo "<div class='alert alert-success'>$success</div>";
}
?>

<form method="POST">

<input
type="text"
name="nama"
class="form-control mb-3"
placeholder="Nama"
required>

<input
type="email"
name="email"
class="form-control mb-3"
placeholder="Email"
required>

<textarea
name="pesan"
class="form-control mb-3"
rows="5"
placeholder="Pesan"
required></textarea>

<button
name="send"
class="btn btn-primary">

Kirim Pesan

</button>

</form>

</div>
</div>
</div>

<?php include 'includes/footer.php'; ?>