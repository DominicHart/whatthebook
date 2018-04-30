<?php
if ($_REQUEST['js_submit_value']) {
    $genreID = $_REQUEST['js_submit_value'];
}
$genres = array();

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
    $genres[] = array('Name'=> $row['GenreName']);
}
?>
<div class="deletegenre" id="deletegenre" role="dialog">
    <div class="delete-container">
        <form action="scripts/admin/dGenre.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="delete_genre()" class="pull-right close">&times;</button>
                <h3>Are you sure?</h3>
            </div>
            <div class="dialog-content clearfix">
                <p>You are about to delete the genre: <?php foreach ($genres as $genre): echo $genre['Name'] . ", and all associated sub genres! <b>(Not Recommended)</b>" ; endforeach; ?></p>
                <input type="hidden" value="<?php echo $genreID; ?>" name="genreID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="delete-yes">Yes</button>
                <button type="button" onclick="delete_genre()" class="delete-no">Cancel</button>
            </div>
        </form>
    </div>
</div>
