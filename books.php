<?php
session_start();
include 'config/database.php';

$search = '';

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$query = mysqli_query(
    $conn,
    "SELECT buku.*,
    kategori.nama_kategori
    FROM buku
    LEFT JOIN kategori
    ON buku.kategori_id =
    kategori.id
    WHERE buku.judul LIKE '%$search%'"
);
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">
            Daftar Buku
        </h2>
    </div>

    <!-- Search -->
    <form method="GET" class="mb-4">

        <div class="input-group shadow-sm">

            <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Cari buku..."
            value="<?= $search ?>">

            <button
            class="btn btn-primary">

                Cari

            </button>

        </div>

    </form>

    <!-- Card Buku -->
    <div class="row g-4">

        <?php while($book = mysqli_fetch_assoc($query)) : ?>

        <div class="col-lg-3 col-md-4 col-sm-6">

            <div class="card shadow-sm h-100 border-0">

                <img
                src="https://placehold.co/300x400"
                class="card-img-top"
                style="height: 320px; object-fit: cover;">

                <div class="card-body d-flex flex-column">

                    <span class="badge bg-primary mb-2">
                        <?= $book['nama_kategori']; ?>
                    </span>
                    
                    <h5 class="fw-bold">
                        <?= $book['judul']; ?>
                    </h5>

                    <p class="text-muted mb-2">
                        <?= $book['penulis']; ?>
                    </p>

                    <h6 class="fw-bold text-primary mb-3">
                        Rp <?= number_format($book['harga']); ?>
                    </h6>

                    <a
                    href="detail-book.php?id=<?= $book['id']; ?>"
                    class="btn btn-primary mt-auto w-100">

                        Lihat Detail

                    </a>

                </div>

            </div>

        </div>

        <?php endwhile; ?>

    </div>

</div>

<?php include 'includes/footer.php'; ?>