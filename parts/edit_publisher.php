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
<div class="editpublisher" id="editpublisher">
    <div class="edit-container">
        <form action="scripts/admin/ePublisher.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="edit_publisher()" class="pull-right close">&times;</button>
                <h3>Update publisher</h3>
            </div>
            <div class="dialog-content clearfix">
                <?php foreach($publishers2 as $publishers): ?>
                <div class="form-group col-sm-12">
                    <label class="e-user" for="name">Name</label>
                    <input type="text" value="<?php echo $publishers['Name']; ?>" class="form-control" id="name" name="name">
                </div>
                <input type="hidden" value="<?php echo $publishers['ID']; ?>" name="publisherID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="update-yes">Update</button>
                <button type="button" onclick="edit_publisher()" class="update-no">Cancel</button>
            </div>
        </form>
        <?php endforeach ?>
    </div>
</div>