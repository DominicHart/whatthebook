<?php
if ($_REQUEST['js_submit_value']) {
    $userID = $_REQUEST['js_submit_value'];
}
$users = array();

include '../includes/INIT.php';

try {
    $sql = "SELECT * FROM tbl_users WHERE userID = :userID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':userID', $userID, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching user; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $users[] = array('ID' => $row['userID'], 'Name' => $row['Fullname']);
}
?>
<div class="deleteuser" id="deleteuser" role="dialog">
    <div class="delete-container">
        <form action="scripts/admin/dUser.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="delete_user()" class="pull-right close">&times;</button>
                <h3>Are you sure?</h3>
            </div>
            <div class="dialog-content clearfix">
                <p>You are about to delete user <?php foreach ($users as $user): echo $user['Name']; endforeach; ?>!</p>
                <input type="hidden" value="<?php echo $userID; ?>" name="userID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="delete-yes">Yes</button>
                <button type="button" onclick="delete_user()" class="delete-no">Cancel</button>
            </div>
        </form>
    </div>
</div>
