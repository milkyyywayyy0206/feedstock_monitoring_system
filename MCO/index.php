<?php
include 'db/conn.php';

$total_items = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM products"))['total'];
$low_stock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as lowstock FROM products WHERE quantity <= 5 AND quantity > 0"))['lowstock'];
$oos = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as oos FROM products WHERE quantity = 0"))['oos'];
?>

<!DOCTYPE html>
<html>
<head>
<title>StockFeed Monitoring System</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    background:#f4f6f9;
}

.header{
    background:linear-gradient(135deg,#0d6efd,#00c6ff);
    color:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}

.card-stat{
    border:none;
    border-radius:12px;
    color:white;
}

.blue{ background:#0d6efd; }
.orange{ background:#f39c12; }
.red{ background:#e74c3c; }

.table{
    background:white;
    border-radius:10px;
    overflow:hidden;
}

.form-box{
    background:white;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.05);
}

</style>
</style>
</head>

<body>

<div class="container mt-4">

<div class="header">
<h2>📦 StockFeed Monitoring System</h2>
<p class="mb-0">Inventory Dashboard</p>
</div>

<!-- stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card card-stat blue text-center p-3">
            <h6>Total Items</h6>
            <h2><?php echo $total_items; ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-stat orange text-center p-3">
            <h6>Low Stock</h6>
            <h2><?php echo $low_stock; ?></h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card card-stat red text-center p-3">
            <h6>Out of Stock</h6>
            <h2><?php echo $oos; ?></h2>
        </div>
    </div>
</div>

<?php if (isset($_GET['insert'])): ?>
<div class="alert alert-success">Product Added Successfully!</div>
<?php endif; ?>

<?php if (isset($_GET['delete'])): ?>
<div class="alert alert-danger">Product Deleted Successfully!</div>
<?php endif; ?>

<h4>Available Products</h4>

<table class="table table-bordered">
<tr class="table-dark">
<th>Name</th>
<th>Category</th>
<th>Quantity</th>
<th>Status</th>
</tr>

<?php
$result = mysqli_query($conn, "SELECT * FROM products");

while ($row = mysqli_fetch_assoc($result)) {

    if ($row['quantity'] == 0) {
        $status = "<span class='badge bg-danger'>Out</span>";
    } elseif ($row['quantity'] <= 5) {
        $status = "<span class='badge bg-warning text-dark'>Low</span>";
    } else {
        $status = "<span class='badge bg-success'>OK</span>";
    }

    echo "<tr>
            <td><a href='item_details.php?id={$row['id']}'>{$row['product_name']}</a></td>
            <td>{$row['category']}</td>
            <td>{$row['quantity']} sacks</td>
            <td>$status</td>
          </tr>";
}
?>
</table>

<br>

<div class="form-box">
<h4>Add New Product</h4>

<form action="includes/processes.php" method="POST">

<div class="mb-2">
<label>Product Name</label>
<input class="form-control" type="text" name="product_name" required>
</div>

<div class="mb-2">
<label>Category</label>
<input class="form-control" type="text" name="category" required>
</div>

<div class="mb-2">
<label>Quantity</label>
<input class="form-control" type="number" name="quantity" required>
</div>

<div class="mb-2">
<label>Price</label>
<input class="form-control" type="number" step="0.01" name="price" required>
</div>

<button class="btn btn-primary w-100" type="submit" name="add_product">
Add Product
</button>

</form>
</div>

</div>
</body>
</html>