<?php
session_start();
include 'classes/Database.php';
include 'classes/Item.php';

$database = new Database();
$db = $database->getConnection();

$item = new Item($db);
$stmt = $item->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <link rel="stylesheet" href="css/landing.css">
</head>
<body>
    <nav>
        <div class="container">
            <a href="index.php" class="logo">SilentStar</a>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <?php if (!isset($_SESSION['username'])): ?>
                    <a href="login.php">Login as Admin</a>
                <?php else: ?>
                    <a href="logout.php">Logout</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Main content -->
    <div class="container">
        <h2>Item List</h2>
        <a href="create.php">add item</a>
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th>Batch</th>
                    <th>Total</th>
                    <th>Status Payment</th>
                    <th>Status Barang</th>
                    <th>Foto Arrived WH KR</th>
                    <?php if (isset($_SESSION['username'])): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['tanggal']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_barang']); ?></td>
                        <td><?php echo htmlspecialchars($row['batch']); ?></td>
                        <td><?php echo htmlspecialchars($row['total']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_payment']); ?></td>
                        <td><?php echo htmlspecialchars($row['status_barang']); ?></td>
                        <td> 
                            <?php if (!empty($row['foto_arrived_wh_kr'])): ?>
                                <?php echo '<img src="' . $row["foto_arrived_wh_kr"] . '" alt="Image" style="width:200px; height:auto; margin:10px;">';?>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>
                        <?php if (isset($_SESSION['username'])): ?>
                            <td class="actions">
                                <a href="update.php?id=<?php echo $row['id']; ?>">Edit</a>
                                <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
