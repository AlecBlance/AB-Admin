<?php
    include 'conn.php';
    $page = $_GET['page'];
    $sql = "SELECT COUNT(rec_id) as counted FROM tbl{$page}";
    $result = mysqli_query($conn, $sql);
    echo mysqli_fetch_assoc($result)['counted'];
?>