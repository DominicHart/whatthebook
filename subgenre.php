<?php
include 'includes/session.php';
include 'includes/header.php';
include 'includes/INIT.php';

$books = array();

try {
    $subgenreID = $_GET['id'];
    $sql = "SELECT * from tbl_mybooks JOIN tbl_subgenre ON tbl_mybooks.subgenreID = tbl_subgenre.subgenreID WHERE tbl_mybooks.subgenreID = :subgenreID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':subgenreID', $subgenreID, PDO::PARAM_INT);
    $result->execute();
}
catch(PDOException $e) {
    $error = 'Error fetching books; ' . $e->getMessage();
}
while ($row = $result->fetch())
{
    $books[] = array('ID' => $row['stockID'], 'Author' => $row['author'], 'Title' => $row['title'] , 'Year'=> $row['year'], 'Description' => $row['description'], 'Price' => $row['unitPrice'], 'Image' => $row['image'], 'Sub' => $row['subgenreName']);
}
if (empty($subgenreID)) {
    header('location:index.php');
}

include 'includes/nav.php';
?>
<div class="container-fluid">
    <div class="row title">
        <div class="col-md-12">
            <h2>Browse Products in <?php foreach ($books as $book): endforeach; if (!empty($books)) { echo $book['Sub']; } ?></h2>
            <p>Browse all of the book in the selected sub genre.</p>
        </div>
    </div>
    <div class="row subbooks">
        <div class="col-md-12">
            <div class="row browse">
                <?php
                if (empty($books)) {
                    echo "<h3>No books were found.</h3>";
                }
                else {
                    foreach ($books as $book):
                        $booktitle = $book['Title'];
                        if (strlen($booktitle) > 35) {
                            $booktitle = substr($booktitle, 0, 35);
                            $booktitle = $booktitle . "...";
                        }
                        echo "<div class='book col-sm-4 col-md-2'><div class='image'><img src='images/books/" . $book['Image'] . "' class='img-responsive'></div>" .
                            "<div class='details'><a class='book-title' href='book.php?id=" . $book['ID'] . "'>" . $booktitle .  "</a>" .
                            "<p class='price'>£" . $book['Price'] . "</p></div><a class='add-to' href='scripts/addcart.php?id=" . $book['ID'] . "' role='button'>Add to Cart</a></div>";
                    endforeach;
                }?>
            </div>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>
