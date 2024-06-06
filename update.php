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

if (isset($_GET['id'])) {
    $item->id = $_GET['id'];
    $stmt = $db->prepare("SELECT * FROM items WHERE id = :id");
    $stmt->bindParam(':id', $item->id);
    $stmt->execute();
    $item_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$item_data) {
        header("Location: index.php");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item->id = $_POST['id'];
    $item->tanggal = $_POST['tanggal'];
    $item->nama_barang = $_POST['nama_barang'];
    $item->batch = $_POST['batch'];
    $item->total = $_POST['total'];
    $item->status_payment = $_POST['status_payment'];
    $item->status_barang = $_POST['status_barang'];
    $item->foto_arrived_wh_kr = $_POST['foto_arrived_wh_kr'];

    if ($item->update()) {
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
    <title>Update Item</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="form-container">
        <form action="update.php" method="post">
            <h2>Update Item</h2>
            <?php if (!empty($error)): ?>
                <p class="error"><?php echo $error; ?></p>
            <?php endif; ?>
            <input type="hidden" name="id" value="<?php echo $item_data['id']; ?>">
            <div class="form-group">
                <label for="tanggal">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo $item_data['tanggal']; ?>" required>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang:</label>
                <input type="text" id="nama_barang" name="nama_barang" value="<?php echo $item_data['nama_barang']; ?>" required>
            </div>
            <div class="form-group">
                <label for="batch">Batch:</label>
                <input type="text" id="batch" name="batch" value="<?php echo $item_data['batch']; ?>" required>
            </div>
            <div class="form-group">
                <label for="total">Total:</label>
                <input type="text" id="total" name="total" value="<?php echo $item_data['total']; ?>" required>
            </div>
            <div class="form-group">
                <label for="status_payment">Status Payment:</label>
                <input type="text" id="status_payment" name="status_payment" value="<?php echo $item_data['status_payment']; ?>" required>
            </div>
            <div class="form-group">
                <label for="status_barang">Status Barang:</label>
                <input type="text" id="status_barang" name="status_barang" value="<?php echo $item_data['status_barang']; ?>" required>
            </div>
            <div class="form-group">
                <label for="foto_arrived_wh_kr">Foto Arrived WH KR:</label>
                <input type="file" id="foto_arrived_wh_kr" name="foto_arrived_wh_kr" value="<?php echo $item_data['foto_arrived_wh_kr']; ?>" required>
            </div>
            <button type="submit" class="button">Update</button>
        </form>
    </div>
</body>
</html>
