<?php
if ($_REQUEST['js_submit_value']) {
    $bookID = $_REQUEST['js_submit_value'];
}
$books = array();
$publishers = array();
$subgenres = array();
$years = range(date('Y'), 1900);

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
    $books[] = array('ID' => $row['stockID'], 'Author' => $row['author'], 'Month' => $row['month'], 'Title' => $row['title'], 'Year'=> $row['year'], 'Publisher' => $row['publisherID'], 'Type' => $row['type'], 'Subgenre' => $row['subgenreID'], 'Description' => $row['description'], 'Quantity' => $row['quantity'], 'Price' => $row['unitPrice'], 'Img' => $row['image']);
}
try {
    $sql = "SELECT * from tbl_publishers";
    $result = $pdo->prepare($sql);
    $result->execute();
}
catch(PDOException $e) {
    $error = 'Error fetching publishers; ' . $e->getMessage();
}
while ($row = $result->fetch())
{
    $publishers[] = array('ID' => $row['publisherid'], 'Name' => $row['publishername']);
}
try {
    $sql = "SELECT * FROM tbl_subgenre;";
    $result = $pdo->prepare($sql);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching sub genres; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $subgenres[] = array('ID' => $row['subgenreID'], 'Name' => $row['subgenreName'], 'Genre' => $row['genreID']);
}
?>
<div class="editbook" id="editbook">
    <div class="edit-container">
        <form action="scripts/admin/eBook.php" method="post" enctype="multipart/form-data">
            <div class="dialog-header">
                <button type="button" onclick="edit_book()" class="pull-right close">&times;</button>
                <h3>Update book</h3>
            </div>
            <div class="dialog-content clearfix">
                <?php foreach($books as $book): ?>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="fullname">Author</label>
                    <input type="text" class="form-control" name="author" id="author" value="<?php echo $book['Author']; ?>">
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user" for="title">Title</label>
                    <input type="text" value="<?php echo $book['Title']; ?>" name="title" id="title" class="form-control">
                </div>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="month">Month</label>
                    <select class="form-control" name="month" id="month">
                        <option value="<?php echo $book['Month']; ?>"><?php echo $book['Month']; ?></option>
                        <option value="Jan">Jan</option>
                        <option value="Feb">Feb</option>
                        <option value="Mar">Mar</option>
                        <option value="Apr">Apr</option>
                        <option value="May">May</option>
                        <option value="Jun">Jun</option>
                        <option value="Jul">Jul</option>
                        <option value="Aug">Aug</option>
                        <option value="Sep">Sep</option>
                        <option value="Oct">Oct</option>
                        <option value="Nov">Nov</option>
                        <option value="Dec">Dec</option>
                    </select>
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user" for="year">Year</label>
                    <select class="form-control" name="year" id="year">
                        <?php
                        foreach($years as $year):
                            echo "<option>" . $year .  "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="pubref">Publisher</label>
                    <select class="form-control" name="pubref" id="pub-ref">
                        <?php
                        foreach($publishers as $publisher):
                            echo "<option value='" . $publisher['ID'] . "'>" . $publisher['Name'] .  "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user" for="type">Type</label>
                    <select class="form-control" name="type" id="type">
                        <option value="Paperback">Paperback</option>
                        <option value="Hardback">Hardback</option>
                    </select>
                </div>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="image">New Image</label>
                    <input type="file" class="form-control" name="bookImage" id="image">
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user" for="subref">Subgenre</label>
                    <select class="form-control" name="subref" id="subref">
                        <?php
                        foreach($subgenres as $subgenre):
                            echo "<option value='" . $subgenre['ID'] . "'>" . $subgenre['Name'] .  "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="form-group col-sm-12">
                    <label class="e-user" for="description">Description</label>
                    <textarea id="description" rows="4" cols="30" maxlength="2000" class="form-control" name="description"><?php echo nl2br($book['Description']); ?></textarea>
                </div>
                <div class="form-group col-sm-6">
                    <label class="e-user" for="quantity">Quantity</label>
                    <input type="number" class="form-control" value="<?php echo $book['Quantity']; ?>" name="quantity" id="quantity">
                </div>
                <div class="form-group col-sm-6 second">
                    <label class="e-user" for="price">Price Per Unit</label>
                    <input type="text" class="form-control" value="<?php echo $book['Price']; ?>"  name="price" id="price">
                </div>
                <input type="hidden" value="<?php echo $bookID; ?>" name="bookID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="update-yes">Update</button>
                <button type="button" onclick="edit_book()" class="update-no">Cancel</button>
            </div>
        </form>
        <?php endforeach ?>
    </div>
</div>
