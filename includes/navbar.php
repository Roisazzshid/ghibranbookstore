<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg bg-white shadow-sm">
    <div class="container">

        <a class="navbar-brand fw-bold text-primary"
        href="index.php">
            GhibranBookStore
        </a>

        <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse"
        id="navbarNav">

            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link"
                    href="index.php">
                    Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                    href="about.php">
                    About
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                    href="contact.php">
                    Contact
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link"
                    href="books.php">
                    Buku
                    </a>
                </li>

                <?php if(isset($_SESSION['user'])) : ?>

                    <li class="nav-item">
                        <span class="nav-link">
                            Hi,
                            <?= $_SESSION['user']['fullname']; ?>
                        </span>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-danger ms-2"
                        href="logout.php">
                            Logout
                        </a>
                    </li>

                <?php else : ?>

                    <li class="nav-item">
                        <a class="btn btn-outline-primary ms-2"
                        href="register.php">
                            Register
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-primary ms-2"
                        href="login.php">
                            Login
                        </a>
                    </li>

                <?php endif; ?>

            </ul>

        </div>
    </div>
</nav>