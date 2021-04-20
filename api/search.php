<?php
    include 'conn.php';
    $field = $_GET['field'];
    $val = $_GET['val'];
    $sql = "SELECT * FROM tblproduct WHERE $field LIKE '%$val%' ORDER BY rec_id";
    $result = mysqli_query($conn, $sql);
?>
<tr class="thead">
    <th><input type="checkbox" class="checkAll"></th>
    <th class="sl">RECORD ID</th>
    <th>CATEGORY</th>
    <th>PRODUCT</th>
    <th>COST</th>
    <th>STOCK</th>
    <th>DESCRIPTION</th>
    <th>ACTION</th>
</tr>
<?php while($row = mysqli_fetch_assoc($result)) {?>
<tr class="entry">
    <td><input type="checkbox" class="minicheck" value="<?php echo $row['rec_id']?>"></td>
    <td class="sl"><?php echo $row['rec_id']?></td>
    <td><?php echo $row['Category']?></td>
    <td><?php echo $row['Product']?></td>
    <td><?php echo $row['Cost']?></td>
    <td><?php echo $row['Stock']?></td>
    <td><?php echo $row['Descr']?></td>
    <td>
        <div class="action">
        <div class="edit" onclick="edit(<?php echo $row['rec_id']?>, '<?php echo $row['Category']?>', '<?php echo $row['Product']?>', <?php echo $row['Cost']?>, '<?php echo $row['Stock']?>', '<?php echo $row['Descr']?>')">
            <img src="./images/edit.png">
        </div>
        <div class="delete" onclick="deleted(<?php echo $row['rec_id']?>)">
            <img src="./images/delete.png">
        </div>
        </div>
    </td>
</tr>
<?php }?>