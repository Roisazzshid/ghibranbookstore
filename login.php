<?php
session_start();
include 'config/database.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string(
        $conn,
        $_POST['email']
    );

    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users
        WHERE email='$email'"
    );

    if (mysqli_num_rows($query) > 0) {

        $user = mysqli_fetch_assoc($query);

        if (password_verify(
            $password,
            $user['password']
        )) {

            $_SESSION['user'] = [
                'id' => $user['id'],
                'fullname' => $user['fullname'],
                'email' => $user['email']
            ];

            header("Location: index.php");
            exit;
        } else {

            $error = "Password salah!";
        }
    } else {

        $error = "Email tidak ditemukan!";
    }
}
?>

<?php include 'includes/header.php'; ?>

<div class="container py-5">

    <div class="col-md-5 mx-auto">

        <div class="card shadow p-4">

            <h2 class="text-center mb-4">
                Login
            </h2>

            <?php if ($error != '') : ?>

                <div class="alert alert-danger">
                    <?= $error ?>
                </div>

            <?php endif; ?>

            <form method="POST">

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

                    Login

                </button>

            </form>

        </div>
    </div>
</div>