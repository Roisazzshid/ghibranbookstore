<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}

include 'config/database.php';

$user_id = $_SESSION['user']['id'];

// ambil cart
$queryCart = mysqli_query(
    $conn,
    "SELECT cart.*, buku.harga
    FROM cart
    JOIN buku
    ON cart.buku_id = buku.id
    WHERE cart.user_id = '$user_id'"
);

$total = 0;

while($row = mysqli_fetch_assoc($queryCart)){

    $subtotal =
    $row['harga']
    *
    $row['qty'];

    $total += $subtotal;
}

if(isset($_POST['checkout'])){

    $alamat = mysqli_real_escape_string(
        $conn,
        $_POST['alamat']
    );

    // insert transaksi utama
    $saveTransaction = mysqli_query(
        $conn,
        "INSERT INTO transaksi(
            user_id,
            total,
            alamat,
            status
        ) VALUES(
            '$user_id',
            '$total',
            '$alamat',
            'Diproses'
        )"
    );

    if($saveTransaction){

        // ambil id transaksi terakhir
        $transaksi_id =
        mysqli_insert_id($conn);

        // ambil isi cart user
        $cartQuery = mysqli_query(
            $conn,
            "SELECT cart.*, buku.harga
            FROM cart
            JOIN buku
            ON cart.buku_id = buku.id
            WHERE cart.user_id = '$user_id'"
        );

        while($item =
        mysqli_fetch_assoc($cartQuery)){

            $buku_id =
            $item['buku_id'];

            $qty =
            $item['qty'];

            $harga =
            $item['harga'];

            // simpan detail transaksi
            mysqli_query(
                $conn,
                "INSERT INTO detail_transaksi(
                    transaksi_id,
                    buku_id,
                    qty,
                    harga
                ) VALUES(
                    '$transaksi_id',
                    '$buku_id',
                    '$qty',
                    '$harga'
                )"
            );
        }

        // hapus cart setelah sukses
        mysqli_query(
            $conn,
            "DELETE FROM cart
            WHERE user_id='$user_id'"
        );

        header("Location: status.php");
        exit;
    }
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

<div class="col-md-7 mx-auto">

<div class="card shadow p-4">

<h2 class="mb-4">
Payment at Delivery
</h2>

<h4 class="mb-4">
Total:
<span class="text-primary">
Rp <?= number_format($total) ?>
</span>
</h4>

<form method="POST">

<label class="mb-2">
Alamat Pengiriman
</label>

<textarea
name="alamat"
rows="5"
class="form-control mb-4"
required></textarea>

<button
name="checkout"
class="btn btn-success w-100">

Pesan Sekarang

</button>

</form>

</div>
</div>
</div>

<?php include 'includes/footer.php'; ?>