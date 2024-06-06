<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include_once 'classes/Database.php';
include_once 'classes/Item.php';

$database = new Database();
$db = $database->getConnection();

$item = new Item($db);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item->tanggal = $_POST['tanggal'];
    $item->nama_barang = $_POST['nama_barang'];
    $item->batch = $_POST['batch'];
    $item->total = $_POST['total'];
    $item->status_payment = $_POST['status_payment'];
    $item->status_barang = $_POST['status_barang'];
    $item->foto_arrived_wh_kr = $_FILES['foto_arrived_wh_kr'];

    if ($item->create()) {
        header("Location: index.php");
        exit;
    } else {
        $error = "An error occurred. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Item</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="form-container">
        <form action="create.php" method="post">
            <h2>Create Item</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" required>
            </div>
            <div class="form-group">
                <label for="batch">Batch:</label>
                <input type="text" id="batch" name="batch" required>
            </div>
            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" id="total" name="total" required>
            </div>
            <div class="form-group">
                <label for="status_payment">Status Payment:</label>
                <input type="text" id="status_payment" name="status_payment" required>
            </div>
            <div class="form-group">
                <label for="status_barang">Status Barang:</label>
                <input type="text" id="status_barang" name="status_barang" required>
            </div>
            <div class="form-group">
                <label for="foto_arrived_wh_kr">Foto Arrived WH KR:</label>
                <input type="file" id="foto_arrived_wh_kr" name="foto_arrived_wh_kr" required>
            </div>
            <button type="submit" class="button">Create</button>
        </form>
    </div>
</body>
</html>
