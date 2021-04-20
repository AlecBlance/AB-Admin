<?php
    include 'conn.php';
    $page = $_GET['page'];
    $rec_id = $_POST['id'];
    for ($i = 0 ; $i < count($rec_id); $i++) {
        $sql = "DELETE FROM tbl{$page} WHERE rec_id={$rec_id[$i]};";
        mysqli_query($conn, $sql);
    }
?>