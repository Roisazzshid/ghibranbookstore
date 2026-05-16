<?php
session_start();
include '../config/database.php';

$error = '';

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM admin
        WHERE username='$username'"
    );

    if(mysqli_num_rows($query) > 0){

        $admin = mysqli_fetch_assoc($query);

        if($password == $admin['password']){

            $_SESSION['admin'] = $admin;

            header("Location: index.php");
            exit;

        } else {

            $error = "Password salah!";
        }

    } else {

        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
</head>

<body class="bg-light">

<div class="container py-5">

<div class="col-md-4 mx-auto">

<div class="card shadow p-4">

<h2 class="text-center mb-4">
Admin Login
</h2>

<?php if($error != '') : ?>

<div class="alert alert-danger">
<?= $error ?>
</div>

<?php endif; ?>

<form method="POST">

<input
type="text"
name="username"
class="form-control mb-3"
placeholder="Username"
required>

<input
type="password"
name="password"
class="form-control mb-3"
placeholder="Password"
required>

<button
name="login"
class="btn btn-primary w-100">

Login

</button>

</form>

</div>
</div>
</div>

</body>
</html>