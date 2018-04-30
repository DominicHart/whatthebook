<?php
if ($_REQUEST['js_submit_value']) {
    $cardID = $_REQUEST['js_submit_value'];
}
$cards = array();

include '../includes/INIT.php';

try {
    $sql = "SELECT * FROM tbl_cards WHERE cardID = :cardID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':cardID', $cardID, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching card; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $cards[] = array('ID' => $row['cardID']);
}
?>
<div class="deletecard" id="deletecard" role="dialog">
    <div class="delete-container">
        <form action="scripts/dCard.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="delete_card()" class="pull-right close">&times;</button>
                <h3>Are you sure?</h3>
            </div>
            <div class="dialog-content clearfix">
            <p>You are about to delete your card (<?php echo $cardID; ?>).</p>
            <input type="hidden" value="<?php echo $cardID; ?>" name="cardID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="delete-yes">Yes</button>
                <button type="button" onclick="delete_card()" class="delete-no">Cancel</button>
            </div>
        </form>
    </div>
</div>

