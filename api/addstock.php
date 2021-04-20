<?php
    include 'conn.php';
    $prodid = $_POST['rec_id'];
    $quantity = $_POST['quantity'];
    $supplierid = $_POST['supplier'];
    $unit = $_POST['unit'];
    $price = $_POST['price'];
    $date = date("Y-m-d");
    $sql = "INSERT INTO tblstockhistory (ProdID, SupplierID, Qty, Unit, SupplierPrice, DateSupplied) VALUES ($prodid, $supplierid, $quantity, '$unit', $price, '$date')";
    mysqli_query($conn, $sql);

    $sql = "UPDATE tblproduct set Stock = Stock + $quantity WHERE rec_id = $prodid";
    mysqli_query($conn, $sql);
?>