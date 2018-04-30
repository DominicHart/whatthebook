<?php
if ($_REQUEST['js_submit_value']) {
    $subgenreID = $_REQUEST['js_submit_value'];
}
$subgenres2 = array();

include '../includes/INIT.php';
try {
    $sql = "SELECT * FROM tbl_subgenre WHERE subgenreID = :subgenreID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':subgenreID', $subgenreID, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching subgenre; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $subgenres2[] = array('Name' => $row['subgenreName']);
}
?>
<div class="deletesubgenre" id="deletesubgenre" role="dialog">
    <div class="delete-container">
        <form action="scripts/admin/dSubGenre.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="delete_subgenre()" class="pull-right close">&times;</button>
                <h3>Are you sure?</h3>
            </div>
            <div class="dialog-content clearfix">
                <p>You are about to delete the sub genre: <?php foreach ($subgenres2 as $subgenres): echo $subgenres['Name'] . "!"; endforeach; ?></p>
                <input type="hidden" value="<?php echo $subgenreID; ?>" name="subgenreID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="delete-yes">Yes</button>
                <button type="button" onclick="delete_subgenre()" class="delete-no">Cancel</button>
            </div>
        </form>
    </div>
</div>