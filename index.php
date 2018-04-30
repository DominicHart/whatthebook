<?php
include 'includes/session.php';
include 'includes/header.php';
include 'includes/INIT.php';

$books = array();

try {
    $sql = "SELECT * from tbl_mybooks ORDER BY rand() LIMIT 6";
    $result = $pdo->prepare($sql);
    $result->execute();
}
catch(PDOException $e) {
    $error = 'Error fetching books; ' . $e->getMessage();
}
while ($row = $result->fetch())
{
    $books[] = array('ID' => $row['stockID'], 'Author' => $row['author'], 'Title' => $row['title'] , 'Year'=> $row['year'], 'Description' => $row['description'], 'Price' => $row['unitPrice'], 'Image' => $row['image']);
}
include 'includes/nav.php';
?>
<div class="container-fluid">
    <div class="row intro">
        <div class="content">
            <h2>High quality but affordable</h2>
            <h3>Choose the book you want from a range of genres</h3>
            <a role="button" href="books.php">Browse Products</a>
        </div>
    </div>
    <div class="row books" id="books">
        <div class="col-md-12">
            <h2>Just a few of our products</h2>
            <div class="row browse">
                <?php
                foreach($books as $book):
                    $booktitle = $book['Title'];
                    if(strlen($booktitle)> 35) {
                        $booktitle=substr($booktitle,0,35);
                        $booktitle = $booktitle."...";
                    }
                    echo "<div class='book col-sm-4 col-md-2'><div class='image'><img src='images/books/" . $book['Image'] . "' class='img-responsive'></div>" .
                        "<div class='details'><a class='book-title' href='book.php?id=" . $book['ID'] . "'>" . $booktitle .  "</a>" .
                        "<p class='price'>£" . $book['Price'] . "</p></div><a class='add-to' href='scripts/addcart.php?id=" . $book['ID'] . "' role='button'>Add to Cart</a></div>";
                endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
