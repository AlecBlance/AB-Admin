<?php
    include 'conn.php';
    $sql = "SELECT * FROM tblsupplier ORDER BY Supplier";
    $result = mysqli_query($conn, $sql);
?>
<option value="0">Please select</option>
<?php
    while($row = mysqli_fetch_assoc($result)){
?>
<option value="<?php echo$row['rec_id']?>"><?php echo $row['Supplier']?></option>
<?php
    }
?>