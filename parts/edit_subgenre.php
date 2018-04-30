<?php
if ($_REQUEST['js_submit_value']) {
    $subgenreID = $_REQUEST['js_submit_value'];
}
$genres2 = array();
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
    $subgenres2[] = array('ID' => $row['subgenreID'], 'Name'=> $row['subgenreName']);
}
try {
    $sql = "SELECT * FROM tbl_genre;";
    $result = $pdo->prepare($sql);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching genres; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $genres2[] = array('ID' => $row['GenreID'], 'Name' => $row['GenreName']);
}
?>
<div class="editsubgenre" id="editsubgenre">
    <div class="edit-container">
        <form action="scripts/admin/eSubGenre.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="edit_subgenre()" class="pull-right close">&times;</button>
                <h3>Update subgenre</h3>
            </div>
            <div class="dialog-content clearfix">
                <?php foreach($subgenres2 as $subgenres): ?>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="name">Name</label>
                    <input type="text" value="<?php echo $subgenres['Name']; ?>" class="form-control" id="name" name="name">
                </div>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="genreref">Genre</label>
                    <select name="genreref" class="form-control" id="genreref">
                        <?php
                        foreach($genres2 as $genres):
                            echo "<option value='" . $genres['ID'] . "'>" . $genres['Name'] . "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <input type="hidden" value="<?php echo $subgenres['ID']; ?>" name="subgenreID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="update-yes">Update</button>
                <button type="button" onclick="edit_subgenre()" class="update-no">Cancel</button>
            </div>
        </form>
        <?php endforeach ?>
    </div>
</div>