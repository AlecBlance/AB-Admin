<?php
    include 'conn.php';
    $page = $_GET['page'];
    if ($page == 'product') {
        $category = $_POST['category'];
        $product = $_POST['product'];
        $cost = $_POST['cost'];
        $description = $_POST['description'];
        $sql = "INSERT INTO tblproduct (Category, Product, Cost, Descr) VALUES ('$category', '$product', $cost, '$description')";
    } else if ($page == 'supplier'){
        $supplier = $_POST['supplier'];
        $first = $_POST['firstname'];
        $last = $_POST['lastname'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $sql = "INSERT INTO tblsupplier (Supplier, Agent_FName, Agent_LName, City, Address) VALUES ('$supplier', '$first', '$last', '$city', '$address')";
    } else if ($page == 'customer'){
        $first = $_POST['firstname'];
        $last = $_POST['lastname'];
        $city = $_POST['city'];
        $sql = "INSERT INTO tblcustomer (FName, LName, City) VALUES ('$first', '$last', '$city')";
    }
    mysqli_query($conn, $sql);
?>