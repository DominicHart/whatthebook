<?php
if ($_REQUEST['js_submit_value']) {
    $thisaccount = $_REQUEST['js_submit_value'];
}
$users2 = array();

include '../includes/INIT.php';
try {
    $sql = "SELECT * FROM tbl_users WHERE userID = :userID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':userID', $thisaccount, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching user; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $users2[] = array('ID' => $row['userID'], 'Fullname' => $row['Fullname'], 'Email' => $row['Email'], 'Address' => $row['Address1'], 'Town' => $row['Town'], 'Postcode' => $row['Postcode'], 'City' => $row['City'], 'Country' => $row['Country']);
}
?>
<div class="edituser" id="edituser">
    <div class="edit-container">
        <form action="scripts/admin/eUser.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="edit_user()" class="pull-right close">&times;</button>
                <h3>Update user</h3>
            </div>
            <div class="dialog-content clearfix">
            <?php foreach($users2 as $users): ?>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="fullname">Name</label>
                    <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $users['Fullname']; ?>">
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user">Email Address</label>
                    <input type="text" value="<?php echo $users['Email']; ?>" class="form-control">
                </div>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="password1">Password</label>
                    <input type="password" class="form-control" name="password1" id="password1">
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user" for="password2">Confirm Password</label>
                    <input type="password" class="form-control" name="password2" id="password2">
                </div>
                <div class="form-group col-sm-12">
                    <label class="e-user" for="address">Address</label>
                    <input type="text" value="<?php echo $users['Address']; ?>" class="form-control" name="address" id="address">
                </div>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="town">Town</label>
                    <input type="text" value="<?php echo $users['Town']; ?>" class="form-control" name="town" id="town">
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user" for="postcode">Postcode</label>
                    <input type="text" value="<?php echo $users['Postcode']; ?>" class="form-control" name="postcode" id="postcode">
                </div>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="town">City</label>
                    <input type="text" value="<?php echo $users['City']; ?>" class="form-control" name="city" id="city">
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user" for="country">Country</label>
                    <input type="text" value="<?php echo $users['Country']; ?>" class="form-control" name="country" id="country">
                </div>
                <div class="form-group col-sm-12">
                    <label class="e-user" for="level">Access Level</label>
                    <select name="level" id="level" class="form-control">
                        <option value="0">Regular</option>
                        <option value="1">Admin</option>
                    </select>
                </div>
                <input type="hidden" value="<?php echo $thisaccount; ?>" name="userID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="update-yes">Update</button>
                <button type="button" onclick="edit_user()" class="update-no">Cancel</button>
            </div>
        </form>
        <?php endforeach ?>
    </div>
</div>
