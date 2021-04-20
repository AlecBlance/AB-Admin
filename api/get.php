<?php
    include 'conn.php';
    $page = $_GET['page'];
    $title = [
        'product' => ['record id', 'category', 'product', 'cost', 'stock', 'description',''],
        'supplier' => ['record id', 'supplier', 'First Name', 'last name', 'city', 'address',''],
        'customer' => ['record id', 'first name', 'last name', 'city', ''],
        'stockhistory' => ['record id', 'Product', 'Supplier', 'Quantity', 'Unit', 'Supplier Price', 'Date Supplied']
    ];
    if (isset($_GET['val']) && isset($_GET['field'])) {
        $field = $_GET['field'];
        $val = $_GET['val'];
        $sql = "SELECT * FROM tbl{$page} WHERE $field LIKE '%$val%' ORDER BY rec_id";
    } else if (isset($_GET['val'])) {
        $val = $_GET['val'];
        $sql = "SELECT tblstockhistory.rec_id, tblproduct.Product, tblsupplier.Supplier, Qty, tblstockhistory.Unit, SupplierPrice, DateSupplied FROM tblstockhistory, tblproduct,tblsupplier WHERE ProdID = tblproduct.rec_id and SupplierID = tblsupplier.rec_id and tblproduct.Product like '%$val%' ORDER BY rec_id";
    }
    else {
        $sql = "SELECT * FROM tbl{$page}";
        if ($page == 'stockhistory')
            $sql = " SELECT * FROM tbl{$page} ORDER BY DateSupplied"; 
    }
    $result = mysqli_query($conn, $sql);
?>
<thead>
    <tr>
        <?php
            if ($page != 'stockhistory'){
        ?>
        <th>
            <label class="au-checkbox">
                <input type="checkbox" class="checkAll">
                <span class="au-checkmark"></span>
            </label>
        </th>
        <?php
            }
            foreach($title[$page] as $value){
        ?>
        <th><?php echo $value;?></th>
        <?php }?>
    </tr>
</thead>
<tbody>
<?php
    while($row = mysqli_fetch_assoc($result)){
        if ($page == 'product') {
?>
<tr class="tr-shadow">
    <td>
        <label class="au-checkbox">
            <input type="checkbox" class="minicheck" value="<?php echo $row['rec_id']?>">
            <span class="au-checkmark"></span>
        </label>
    </td>
    <td><?php echo $row['rec_id']?></td>
    <td>
        <span class="block-email"><?php echo $row['Category']?></span>
    </td>
    <td class="desc"><?php echo $row['Product']?></td>
    <td><?php echo $row['Cost']?></td>
    <td>
        <span class="status--process"><?php echo $row['Stock']?></span>
    </td>
    <td><?php echo $row['Descr']?></td>
    <td>
        <div class="table-data-feature">
            <button class="item" data-toggle="modal" data-target="#myModal" onclick="edit(['<?php echo $row['rec_id']?>', '<?php echo $row['Category']?>', '<?php echo $row['Product']?>',  '<?php echo $row['Descr']?>', <?php echo $row['Cost']?>, <?php echo $row['Stock']?>])">
                <i class="zmdi zmdi-edit"></i>
            </button>
            <button class="item" onclick="deleted(<?php echo $row['rec_id']?>)">
                <i class="zmdi zmdi-delete"></i>
            </button>
            <button class="item" data-toggle="modal" data-target="#myModal1" onclick="addStock('<?php echo $row['rec_id']?>', '<?php echo $row['Product']?>')">
                <i class="zmdi zmdi-square-down"></i>
            </button>
        </div>
    </td>
</tr>
<tr class="spacer"></tr>
<?php 
        } else if ($page == 'supplier') {
?>
<tr class="tr-shadow">
    <td>
        <label class="au-checkbox">
            <input type="checkbox" class="minicheck" value="<?php echo $row['rec_id']?>">
            <span class="au-checkmark"></span>
        </label>
    </td>
    <td><?php echo $row['rec_id']?></td>
    <td>
        <span class="block-email"><?php echo $row['Supplier']?></span>
    </td>
    <td class="desc"><?php echo $row['Agent_FName']?></td>
    <td><?php echo $row['Agent_LName']?></td>
    <td><?php echo $row['City']?></td>
    <td><?php echo $row['Address']?></td>
    <td>
        <div class="table-data-feature">
            <button class="item" data-toggle="modal" data-target="#myModal" onclick="edit(['<?php echo $row['rec_id']?>', '<?php echo $row['Supplier']?>', '<?php echo $row['Agent_FName']?>', '<?php echo $row['Agent_LName']?>', '<?php echo $row['City']?>', '<?php echo $row['Address']?>'])">
                <i class="zmdi zmdi-edit"></i>
            </button>
            <button class="item" onclick="deleted(<?php echo $row['rec_id']?>)">
                <i class="zmdi zmdi-delete"></i>
            </button>
        </div>
    </td>
</tr>
<tr class="spacer"></tr>
<?php 
        } else if ($page == 'customer') {
?>
<tr class="tr-shadow">
    <td>
        <label class="au-checkbox">
            <input type="checkbox" class="minicheck" value="<?php echo $row['rec_id']?>">
            <span class="au-checkmark"></span>
        </label>
    </td>
    <td><?php echo $row['rec_id']?></td>
    <td class="desc"><?php echo $row['FName']?></td>
    <td><?php echo $row['LName']?></td>
    <td><?php echo $row['City']?></td>
    <td>
        <div class="table-data-feature">
            <button class="item" data-toggle="modal" data-target="#myModal" onclick="edit(['<?php echo $row['rec_id']?>', '<?php echo $row['FName']?>', '<?php echo $row['LName']?>', '<?php echo $row['City']?>'])">
                <i class="zmdi zmdi-edit"></i>
            </button>
            <button class="item" onclick="deleted(<?php echo $row['rec_id']?>)">
                <i class="zmdi zmdi-delete"></i>
            </button>
        </div>
    </td>
</tr>
<tr class="spacer"></tr>
<?php 
        } else if ($page == 'stockhistory') {
?>
<tr class="tr-shadow">
    <td><?php echo $row['rec_id']?></td>
    <td class="desc">
    <?php 
        if (!isset($_GET['val'])) {
            $proddid = $row['ProdID'];
            $sql = "SELECT Product FROM tblproduct WHERE rec_id=$proddid";
            $proddresult = mysqli_query($conn, $sql);
            $prodd = mysqli_fetch_assoc($proddresult);
            if ($prodd)
                echo $prodd['Product'];
            else 
                echo 'Deleted';
        } else {
            echo $row['Product'];
        }
    ?>
    </td>
    <td>
    <?php 
        if (!isset($_GET['val'])) {
            $suppid = $row['SupplierID'];
            $sql = "SELECT Supplier FROM tblsupplier WHERE rec_id=$suppid";
            $suppresult = mysqli_query($conn, $sql);
            $prodd = mysqli_fetch_assoc($suppresult);
            if ($prodd)
                echo $prodd['Supplier'];
            else 
                echo 'Deleted';
        } else {
            echo $row['Supplier'];
        }
    ?></td>
    <td><?php echo $row['Qty']?></td>
    <td><?php echo $row['Unit']?></td>
    <td><?php echo $row['SupplierPrice']?></td>
    <td><?php echo $row['DateSupplied']?></td>
</tr>
<tr class="spacer"></tr>
<?php
        }
    }
?>