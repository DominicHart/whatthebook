<?php
if ($_REQUEST['js_submit_value']) {
    $bookID = $_REQUEST['js_submit_value'];
}
$books = array();

include '../includes/INIT.php';
try {
    $sql = "SELECT * FROM tbl_mybooks WHERE stockID = :bookID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':bookID', $bookID, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching book; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $books[] = array('Title'=> $row['title']);
}
?>
<div class="deletebook" id="deletebook" role="dialog">
    <div class="delete-container">
        <form action="scripts/admin/dBook.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="delete_book()" class="pull-right close">&times;</button>
                <h3>Are you sure?</h3>
            </div>
            <div class="dialog-content clearfix">
                <p>You are about to delete the book: <?php foreach ($books as $book): echo $book['Title']  ; endforeach; ?>!</p>
                <input type="hidden" value="<?php echo $bookID; ?>" name="bookID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="delete-yes">Yes</button>
                <button type="button" onclick="delete_book()" class="delete-no">Cancel</button>
            </div>
        </form>
    </div>
</div>