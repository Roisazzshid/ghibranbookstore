<?php
session_start();

include 'config/database.php';

$user_id =
$_SESSION['user']['id'];

$query =
mysqli_query(
$conn,
"SELECT * FROM transaksi
WHERE user_id=
'$user_id'
ORDER BY id DESC"
);
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="container py-5">

<h2 class="mb-4">
Status Pengiriman
</h2>

<div class="card shadow-sm">

<table class="table">

<thead>
<tr>
<th>ID</th>
<th>Total</th>
<th>Status</th>
<th>Tanggal</th>
</tr>
</thead>

<tbody>

<?php while($row =
mysqli_fetch_assoc($query)) : ?>

<tr>

<td>
#<?= $row['id'] ?>
</td>

<td>
Rp <?= number_format(
$row['total']
) ?>
</td>

<td>

<span class="badge bg-primary">
<?= $row['status'] ?>
</span>

</td>

<td>
<?= $row['created_at'] ?>
</td>

</tr>

<?php endwhile; ?>

</tbody>

</table>

</div>

</div>

<?php include 'includes/footer.php'; ?>