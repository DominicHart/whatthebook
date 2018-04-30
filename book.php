<?php
include 'includes/session.php';
include 'includes/header.php';
include 'includes/INIT.php';

$books = array();

try {
    $bookID = $_GET['id'];
    $sql = "SELECT * from tbl_mybooks JOIN tbl_subgenre ON tbl_mybooks.subgenreID = tbl_subgenre.subgenreID WHERE tbl_mybooks.stockID = :bookID ";
    $result = $pdo->prepare($sql);
    $result->bindParam(':bookID', $bookID, PDO::PARAM_INT);
    $result->execute();
}
catch(PDOException $e) {
    $error = 'Error fetching book; ' . $e->getMessage();
}
while ($row = $result->fetch())
{
    $books[] = array('ID' => $row['stockID'], 'Author' => $row['author'], 'Title' => $row['title'] , 'Year'=> $row['year'], 'Description' => $row['description'], 'Price' => $row['unitPrice'], 'Image' => $row['image'], 'Sub' => $row['subgenreName']);
}

if (empty($bookID)) {
    header('location:index.php');
}

include 'includes/nav.php';
?>
<div class="container-fluid">
    <div class="row title">
        <div class="col-md-12">
            <h2><?php foreach ($books as $book): endforeach; if (!empty($books)) { echo $book['Title']; } ?></h2>
            <p>All of the details for this book can be found on this page.</p>
        </div>
    </div>
    <div class="row thisbook">
        <?php
        if (empty($books)) {
            echo "<h3>No books were found.</h3>";
        }
        else {
            foreach ($books as $book):
                echo "<div class='book'><div class='image'><img src='images/books/" . $book['Image'] . "' class='img-responsive'></div>" .
                    "<div class='details'><h3>" . $book['Title'] . "</h3><p class='author'>" . $book['Author'] . "</p><p>" . nl2br($book['Description']) . "</p><p class='price'>£" . $book['Price'] . "</p>" .
                    "<a class='add-to' href='scripts/addcart.php?id=" . $book['ID'] . "' role='button'>Add to Cart</a></div></div>";
            endforeach;
        }?>
    </div>
</div>
<?php
include 'includes/footer.php';
?>
