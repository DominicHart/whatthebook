<?php
if ($_REQUEST['js_submit_value']) {
    $genreID = $_REQUEST['js_submit_value'];
}
$genres2 = array();

include '../includes/INIT.php';
try {
    $sql = "SELECT * FROM tbl_genre WHERE GenreID = :genreID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':genreID', $genreID, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching genre; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $genres2[] = array('ID' => $row['GenreID'], 'Name'=> $row['GenreName']);
}
?>
<div class="editgenre" id="editgenre">
    <div class="edit-container">
        <form action="scripts/admin/eGenre.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="edit_genre()" class="pull-right close">&times;</button>
                <h3>Update genre</h3>
            </div>
            <div class="dialog-content clearfix">
                <?php foreach($genres2 as $genres): ?>
                <div class="form-group col-md-12">
                    <label class="e-user" for="name">Name</label>
                    <input type="text" value="<?php echo $genres['Name']; ?>" class="form-control" id="name" name="name">
                </div>
                <input type="hidden" value="<?php echo $genres['ID']; ?>" name="genreID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="update-yes">Update</button>
                <button type="button" onclick="edit_genre()" class="update-no">Cancel</button>
            </div>
        </form>
        <?php endforeach ?>
    </div>
</div>
