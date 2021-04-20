<?php
    include 'conn.php';
    $page = $_GET['page'];
    $rec_id = $_POST['rec_id'];
    if ($page == 'product') {
        $category = $_POST['category'];
        $product = $_POST['product'];
        $cost = $_POST['cost'];
        $description = $_POST['description'];
        $sql = "UPDATE tblproduct SET Category = '$category', Product= '$product', Cost = $cost, Descr = '$description' WHERE rec_id = $rec_id";
    } else if ($page == 'supplier'){
        $supplier = $_POST['supplier'];
        $first = $_POST['firstname'];
        $last = $_POST['lastname'];
        $city = $_POST['city'];
        $address = $_POST['address'];
        $sql = "UPDATE tblsupplier SET Supplier = '$supplier', Agent_FName= '$first', Agent_LName = '$last', City = '$city', Address = '$address' WHERE rec_id = $rec_id";
    } else if ($page == 'customer'){
        $first = $_POST['firstname'];
        $last = $_POST['lastname'];
        $city = $_POST['city'];
        $sql = "UPDATE tblcustomer SET FName= '$first', LName = '$last', City = '$city' WHERE rec_id = $rec_id";
    }
    mysqli_query($conn, $sql);
?>