<?php

if ( $_SERVER['REQUEST_METHOD']=='GET' && realpath(__FILE__) == realpath( $_SERVER['SCRIPT_FILENAME'] ) ) {
    /* choose the appropriate page to redirect users */
    die(header('location: /assignment2/404.php'));
}

$genres = array();
$subgenres = array();

include 'INIT.php';

try {
    $sql = "SELECT * FROM tbl_genre;";
    $result = $pdo->prepare($sql);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching genres; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $genres[] = array('ID' => $row['GenreID'], 'Name' => $row['GenreName']);
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
if (isset($_SESSION['userID'])) {
    try {
        $sql = "SELECT * FROM tbl_cart WHERE userID = '$thisuser'";
        $result = $pdo->query($sql);
        $result->execute();
        $cartCount = $result->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (PDOException $e) {
        echo "Error !: " . $e->getMessage() . "<br>";
        exit();
    }
}
?>
<div class="head-content">
<header>
    <div class="container-fluid">
        <div class="row header">
            <div class="col-md-4 head-mobile">
                <ul>
                    <li><a href="#"><i class="fa fa-mobile" aria-hidden="true"></i>07895 745388</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <img src="images/logo.png" class="img img-responsive" alt="logo" width="300" height="107">
            </div>
            <div class="col-md-4 head-cart">
                <ul>
                    <li><a href="cart">(<?php if (isset($_SESSION['userID'])) {echo count($cartCount);} else {echo "0";} ?>) items in cart</a></li>
                </ul>
            </div>
        </div>
    </div>
</header>
<nav class="navbar navbar-default navbar-static">
    <div class="container-fluid">
        <div class="navbar-header">
            <div class="navbar-brand">
                <a class="brand" href="index">what the book?</a>
                <div class="collapsed-content">
                    <ul>
                        <li><a href="#"><i class="fa fa-mobile" aria-hidden="true"></i>07895 745388</a></li>
                        <li><a href="cart">(<?php if (isset($_SESSION['userID'])) {echo count($cartCount);} else {echo "0";} ?>) items in cart</a></li>
                    </ul>
                </div>
            </div>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-haspopup="true" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle Navigation</span>
                <span class = "icon-bar top-bar"></span>
                <span class = "icon-bar middle-bar"></span>
                <span class = "icon-bar bottom-bar"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse" id="navbar">
            <ul class="nav navbar-nav">
                <li><a href="index" accesskey="1">Home</a></li>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Books&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="books" accesskey="2">View All</a></li>
                        <?php
                            foreach($genres as $genre):
                                echo "<li class='dropdown-submenu'><a href='#' class='dropdown-toggle' role='button'>" . $genre['Name'] . "</a>"
                                        . "<ul class='dropdown-menu'>";
                                        foreach($subgenres as $subgenre):
                                            if ($subgenre['Genre'] == $genre['ID']) {
                                                echo "<li><a tabindex='-1' href='subgenre?id=" . $subgenre['ID'] . "'>" . $subgenre['Name'] . "</a></li>";
                                            }
                                        endforeach;
                                        echo "</ul>"
                                      . "</li>";
                            endforeach;
                        ?>
                    </ul>
                </li>
                <li><a href="about" accesskey="3">About Us</a></li>
                <li><a href="contact" accesskey="4">Contact Us</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (isset($_SESSION['userID'])) {?>
                    <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $fullname; ?>&nbsp<span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="cart?userid=<?php echo $thisuser; ?>" accesskey="4">View Cart</a></li>
                            <li><a href="account?userid=<?php echo $thisuser; ?>" accesskey="5">Account Settings</a></li>
                            <?php
                            if ($aLevel == 1) {
                                echo "<li><a href='admin' accesskey='5'>Admin Panel</a></li>";
                            }
                            ?>
                            <li><a href="scripts/logout.php" accesskey="6">Logout</a></li>
                        </ul>
                    </li>
                <?php }
                else { ?>
                <li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Account&nbsp;<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="login" accesskey="7">Login</a></li>
                        <li><a href="register" accesskey="8">Register</a></li>
                    </ul>
                </li>
                    <?php } ?>
            </ul>
        </div>
    </div>
</nav>
</div>