<?php
if ($_REQUEST['js_submit_value']) {
    $orderID = $_REQUEST['js_submit_value'];
}
$orders = array();

include '../includes/INIT.php';
try {
    $sql = "SELECT * FROM tbl_orders WHERE orderID = :orderID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':orderID', $orderID, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching book; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $orders[] = array('ID' => $row['orderID']);
}
?>
<div class="deleteorder" id="deleteorder" role="dialog">
    <div class="delete-container">
        <form action="scripts/admin/dOrder.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="delete_order()" class="pull-right close">&times;</button>
                <h3>Are you sure?</h3>
            </div>
            <div class="dialog-content clearfix">
                <p>You are about to delete order: <?php foreach ($orders as $order): echo $order['ID'] . " <b>(Not Recommended)</b>"; endforeach; ?>!</p>
                <input type="hidden" value="<?php echo $orderID; ?>" name="orderID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="delete-yes">Yes</button>
                <button type="button" onclick="delete_order()" class="delete-no">Cancel</button>
            </div>
        </form>
    </div>
</div>