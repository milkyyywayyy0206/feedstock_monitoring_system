<?php
include 'db/conn.php';

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM products WHERE id = $id");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    echo "Product not found!";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Item Details</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{ background:#f4f6f9; }

.header{
    background:linear-gradient(135deg,#198754,#20c997);
    color:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}

.box{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:20px;
}
</style>
</head>

<body>

<div class="container mt-4">

<div class="header">
<h2>📄 Item Details</h2>
</div>

<?php if (isset($_GET['update'])): ?>
<div class="alert alert-success">Product Updated!</div>
<?php endif; ?>

<?php if (isset($_GET['stock'])): ?>
<div class="alert alert-info">Stock Added!</div>
<?php endif; ?>

<div class="box">
<h4>Edit Product</h4>

<form action="includes/processes.php" method="POST">

<input type="hidden" name="id" value="<?php echo $product['id']; ?>">

<input class="form-control mb-2" type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>
<input class="form-control mb-2" type="text" name="category" value="<?php echo $product['category']; ?>" required>
<input class="form-control mb-2" type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

<p><strong>Current Quantity:</strong> <?php echo $product['quantity']; ?> sacks</p>

<button class="btn btn-success w-100" type="submit" name="update_product">Update</button>

</form>
</div>

<div class="box">
<h4>Add Stock</h4>

<form action="includes/processes.php" method="POST">
<input type="hidden" name="id" value="<?php echo $product['id']; ?>">
<input class="form-control mb-2" type="number" name="quantity" placeholder="Quantity to add" required>
<button class="btn btn-primary w-100" type="submit" name="add_stock">Add Stock</button>
</form>
</div>

<a class="btn btn-danger w-100 mb-2"
href="includes/processes.php?process=delete_product&id=<?php echo $product['id']; ?>"
onclick="return confirm('Delete this product?')">
Delete Product
</a>

<a class="btn btn-secondary w-100" href="index.php">Back to Dashboard</a>

</div>
</body>
</html>