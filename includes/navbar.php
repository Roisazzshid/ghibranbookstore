<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">

    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold text-primary"
        href="index.php">

            📚 GhibranBookStore

        </a>

        <!-- Toggle Mobile -->
        <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>

        </button>

        <!-- Menu -->
        <div
        class="collapse navbar-collapse"
        id="navbarNav">

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                <li class="nav-item">
                    <a class="nav-link"
                    href="index.php">

                        Home

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                    href="books.php">

                        Buku

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                    href="about.php">

                        About Us

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                    href="contact.php">

                        Contact

                    </a>
                </li>

                <?php if(isset($_SESSION['user'])) : ?>

                <li class="nav-item">
                    <a class="nav-link"
                    href="cart.php">

                        🛒 Keranjang

                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                    href="status.php">

                        Status Pesanan

                    </a>
                </li>

                <li class="nav-item">
                    <span class="nav-link fw-semibold text-primary">

                        Hi,
                        <?= $_SESSION['user']['fullname']; ?>

                    </span>
                </li>

                <li class="nav-item">

                    <a
                    class="btn btn-danger"
                    href="logout.php">

                        Logout

                    </a>

                </li>

                <?php else : ?>

                <li class="nav-item">

                    <a
                    class="btn btn-outline-primary"
                    href="register.php">

                        Register

                    </a>

                </li>

                <li class="nav-item">

                    <a
                    class="btn btn-primary"
                    href="login.php">

                        Login

                    </a>

                </li>

                <?php endif; ?>

            </ul>

        </div>

    </div>

</nav>