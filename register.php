<?php
session_start();
include 'config/database.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = mysqli_real_escape_string(
        $conn,
        $_POST['fullname']
    );

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $password = $_POST['password'];

    // cek email
    $checkEmail = mysqli_query(
        $conn,
        "SELECT * FROM users
        WHERE email='$email'"
    );

    if (mysqli_num_rows($checkEmail) > 0) {

        $error = "Email sudah terdaftar!";
    } else {

        $hashPassword = password_hash(
            $password,
            PASSWORD_DEFAULT
        );

        $insert = mysqli_query(
            $conn,
            "INSERT INTO users(
                fullname,
                email,
                password
            ) VALUES (
                '$fullname',
                '$email',
                '$hashPassword'
            )"
        );

        if ($insert) {

            header("Location: login.php");
            exit;
        } else {

            $error = "Registrasi gagal!";
        }
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container py-5">
    <div class="col-md-5 mx-auto">

        <div class="card shadow p-4">

            <h2 class="text-center mb-4">
                Register
            </h2>

            <?php if ($error != '') : ?>
                <div class="alert alert-danger">
                    <?= $error ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <input
                    type="text"
                    name="fullname"
                    class="form-control mb-3"
                    placeholder="Full Name"
                    required>

                <input
                    type="email"
                    name="email"
                    class="form-control mb-3"
                    placeholder="Email"
                    required>

                <input
                    type="password"
                    name="password"
                    class="form-control mb-3"
                    placeholder="Password"
                    required>

                <button
                    type="submit"
                    class="btn btn-primary w-100">

                    Register

                </button>

            </form>

            <div class="text-center mt-3">
                Sudah punya akun?
                <a href="login.php">
                    Login
                </a>
            </div>

        </div>
    </div>
</div>