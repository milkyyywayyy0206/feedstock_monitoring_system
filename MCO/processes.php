<?php
include '../db/conn.php';


// ================= ADD PRODUCT =================
if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $quantity = intval($_POST['quantity']);
    $price = floatval($_POST['price']);

    $insert = "INSERT INTO products (product_name, category, quantity, price)
               VALUES ('$name', '$category', '$quantity', '$price')";

    mysqli_query($conn, $insert);
    header("Location: ../index.php?insert=success");
    exit();
}


// ================= ADD STOCK =================
if (isset($_POST['add_stock'])) {

    $id = intval($_POST['id']);
    $quantity = intval($_POST['quantity']);

    $update = "UPDATE products 
               SET quantity = quantity + $quantity 
               WHERE id = $id";

    mysqli_query($conn, $update);
    header("Location: ../item_details.php?id=$id&stock=success");
    exit();
}


// ================= UPDATE PRODUCT =================
if (isset($_POST['update_product'])) {

    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $price = floatval($_POST['price']);

    $update = "UPDATE products 
               SET product_name='$name',
                   category='$category',
                   price='$price'
               WHERE id=$id";

    mysqli_query($conn, $update);
    header("Location: ../item_details.php?id=$id&update=success");
    exit();
}


// ================= DELETE PRODUCT =================
if (isset($_GET['process']) && $_GET['process'] == "delete_product") {

    $id = intval($_GET['id']);

    $delete = "DELETE FROM products WHERE id = $id";
    mysqli_query($conn, $delete);

    header("Location: ../index.php?delete=success");
    exit();
}
?>