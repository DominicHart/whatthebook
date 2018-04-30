<?php
if ($_REQUEST['js_submit_value']) {
    $publisherID = $_REQUEST['js_submit_value'];
}
$publishers2 = array();

include '../includes/INIT.php';
try {
    $sql = "SELECT * FROM tbl_publishers WHERE publisherid = :publisherid";
    $result = $pdo->prepare($sql);
    $result->bindParam(':publisherid', $publisherID, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching publisher; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $publishers2[] = array('ID' => $row['publisherid'], 'Name'=> $row['publishername']);
}
?>
?>
<div class="deletepublisher" id="deletepublisher" role="dialog">
    <div class="delete-container">
        <form action="scripts/admin/dPublisher.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="delete_publisher()" class="pull-right close">&times;</button>
                <h3>Are you sure?</h3>
            </div>
            <div class="dialog-content clearfix">
                <p>You are about to delete the publisher: <?php foreach ($publishers2 as $publishers): echo $publishers['Name'] . "!"; endforeach; ?></p>
                <input type="hidden" value="<?php echo $publisherID; ?>" name="publisherID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="delete-yes">Yes</button>
                <button type="button" onclick="delete_publisher()" class="delete-no">Cancel</button>
            </div>
        </form>
    </div>
</div>