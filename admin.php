<?php
include 'includes/session.php';
include 'includes/header.php';

$users = array();
$books = array();
$publishers = array();
$years = range(date('Y'), 1900);
$orders = array();

include 'includes/INIT.php';

try {
    $sql = "SELECT * FROM tbl_users";
    $result = $pdo->prepare($sql);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching user; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $users[] = array('ID' => $row['userID'], 'Fullname' => $row['Fullname'], 'Email' => $row['Email'], 'Address' => $row['Address1'], 'Town' => $row['Town'], 'Postcode' => $row['Postcode'], 'City' => $row['City'], 'Country' => $row['Country']);
}
try {
    $sql = "SELECT * from tbl_mybooks";
    $result = $pdo->prepare($sql);
    $result->execute();
}
catch(PDOException $e) {
    $error = 'Error fetching books; ' . $e->getMessage();
}
while ($row = $result->fetch())
{
    $books[] = array('ID' => $row['stockID'], 'Author' => $row['author'], 'Title' => $row['title'], 'Year'=> $row['year'], 'Publisher' => $row['publisherID'], 'Description' => $row['description'], 'Price' => $row['unitPrice']);
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
    $sql = "SELECT * from tbl_orders JOIN tbl_users ON tbl_orders.userID = tbl_users.userID";
    $result = $pdo->prepare($sql);
    $result->execute();
}
catch(PDOException $e) {
    $error = 'Error fetching orders; ' . $e->getMessage();
}
while ($row = $result->fetch())
{
    $orders[] = array('ID' => $row['orderID'], 'userID' => $row['userID'], 'book' => $row['bookID'], 'Quantity' => $row['Quantity'], 'User' => $row['Fullname'], 'Total' => $row['Total']);
}
if (isset($_SESSION['userID']))
{
    if ($aLevel!= 1) {
        header('location:index.php');
    }
}
else
{
    header('location:login.php');
}
include 'includes/nav.php';
?>
<div class="container-fluid">
    <div class="row admin">
        <div id="admin-content">
            <?php
            if (isset($_SESSION['error'])) {
                if ($_SESSION['error'] == "euserAdmin") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>User not updated</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "user3") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>User not deleted</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "book1") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Book already exists</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "book2") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Book anot updated</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "book3") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Book not deleted</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "genre1") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Genre already exists</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "genre2") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Genre not updated</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "genre3") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Genre not deleted</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "subgenre1") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Sub Genre already exists</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "subgenre2") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Sub genre not updated</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "subgenre3") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Sub genre not deleted</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "publisher1") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Publisher already exists</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "publisher2") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Publisher not updated</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "publisher3") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>Publisher not deleted</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                } else if ($_SESSION['error'] == "reg1") {
                    echo "<p class='regerror'>Passwords do not match.</p>";
                } else if ($_SESSION['error'] == "reg2") {
                    echo "<p class='regerror'>Passwords must contain at least one uppercase letter.</p>";
                } else if ($_SESSION['error'] == "reg1") {
                    echo "<p class='regerror'>Passwords must contain at least one lowercase letter.</p>";
                } else if ($_SESSION['error'] == "reg4") {
                    echo "<p class='regerror'>Passwords must contain at least one number.</p>";
                } else if ($_SESSION['error'] == "reg5") {
                    echo "<p class='regerror'>Passwords must be 8 characters or longer.</p>";
                } else if ($_SESSION['error'] == "reg6") {
                    echo "<p class='regerror'>The email addresses do not match.</p>";
                } else if ($_SESSION['error'] == "reg8") {
                    echo "<p class='regerror'>That email address in already in use.</p>";
                } else if ($_SESSION['error'] == "order2") {
                    echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>GOrder not deleted</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                }
            }
            ?>
            <div id="edit-delete"></div>
            <div class="col-md-3 col-md-offset-1 col-sm-5 col-sm-offset-1">
                <ul id='admin-menu'>
                    <li class="head">Admin Menu</li>
                    <li><a role="button" class="coll-toggle active" href='#' id="btn-add-users"><i class="fa fa-user-plus" aria-hidden="true"></i>Add Users</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-man-users"><i class="fa fa-users" aria-hidden="true"></i>Manage Users</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-add-genre"><i class="fa fa-folder" aria-hidden="true"></i>Add Genre</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-man-genre"><i class="fa fa-folder" aria-hidden="true"></i>Manage Genres</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-add-subgenre"><i class="fa fa-folder" aria-hidden="true"></i>Add Sub Genre</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-man-subgenre"><i class="fa fa-folder" aria-hidden="true"></i>Manage Sub Genres</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-add-publisher"><i class="fa fa-address-book" aria-hidden="true"></i>Add Publisher</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-man-publishers"><i class="fa fa-address-book" aria-hidden="true"></i>Manage Publishers</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-add-book"><i class="fa fa-book" aria-hidden="true"></i>Add Books</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-man-books"><i class="fa fa-book" aria-hidden="true"></i>Manage Books</a></li>
                    <li><a role="button" class="coll-toggle" href='#' id="btn-man-orders"><i class="fa fa-list" aria-hidden="true"></i>Manage Orders</a></li>
                    <li><a role="button" href='scripts/logout.php'><i class="fa fa-times" aria-hidden="true"></i>Logout</a></li>
                </ul>
            </div>
            <div class="col-md-7 col-sm-5">
                <div id="add-users" class="content active">
                    <h2>Add Users</h2>
                    <form action="scripts/reg_user.php" method="post">
                        <div class="form-group col-md-12">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="fullname" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" name="email1" id="email" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email2">Confirm Email</label>
                            <input type="email" name="email2" id="email2" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password1">Password</label>
                            <input type="password" name="password1" id="password1" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password2">Confirm Password</label>
                            <input type="password" name="password2" id="password2" class="form-control" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address1">Address</label>
                            <input type="text" class="form-control" id="address1" name="address1">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="town">Town</label>
                            <input type="text" class="form-control" id="town" name="town">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="postcode">Postcode</label>
                            <input type="text" class="form-control" id="postcode" name="postcode">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="country">Country</label>
                            <input type="text" class="form-control" id="country" name="country">
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" name="submit">Create Account</button>
                        </div>
                    </form>
                </div>
                <div id="man-users" class="content">
                    <h2>Users</h2>
                    <div class="table-responsive">
                        <?php
                            echo "<table class='table table-striped admin-table'><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Edit</th><th>Delete</th></tr></thead><tbody>";
                            foreach($users as $user):
                                echo "<tr><td>" . $user['ID'] . "</td><td>" . $user['Fullname'] . "</td><td>" . $user['Email'] .  "</td><td><form method='post' class='edit-user' onsubmit='return false;'><button type='submit' class='btnedituser' name='" . $user['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td>";
                                if($thisuser != $user['ID']) {
                                    echo "<td><form method='post' class='delete-user' onsubmit='return false;'><button type='submit' class='btndeleteuser' name='" . $user['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td>";
                                }
                                else {
                                    echo "<td></td>";
                                }
                                echo "</tr>";
                            endforeach;
                            echo "</tbody></table>";
                        ?>
                    </div>
                    <div class="table-mobile">
                        <?php
                            foreach($users as $user):
                                echo "<table class='table admin-table'><tr><th><h4 class='title'>User ID:</h4><p class='title'>" . $user['ID'] .  "</p></th></tr><tr><td><h4>Name:</h4><p>" . $user['Fullname']  . "</p></td></tr>"
                                . "<tr><td><h4>Email:</h4><p>" . $user['Email'] . "</p></td></tr><tr><td><h4>Edit:</h4><form method='post' class='edit-user' onsubmit='return false;'><button type='submit' class='btnedituser' name='" . $user['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td></tr>"
                                . "<tr><td><h4>Delete:</h4>";
                                if($thisuser != $user['ID']) {
                                    echo "<form method='post' class='delete-user' onsubmit='return false;'><button type='submit' class='btndeleteuser' name='" . $user['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form>";
                                }
                                else {
                                    echo "<p>N/A</p>";
                                }
                                echo "</td></tr></table>";
                            endforeach;
                        ?>
                    </div>
                </div>
                <div id="add-genre" class="content">
                    <h2>Add Genre</h2>
                    <form action="scripts/admin/add_genre.php" method="post">
                        <div class="form-group col-md-12">
                            <label for="genrename">Genre Name</label>
                            <input type="text" class="form-control" id="genrename" name="genrename" required>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" name="submit">Add Genre</button>
                        </div>
                    </form>
                </div>
                <div id="man-genres" class="content">
                    <h2>Genres</h2>
                    <div class="table-responsive">
                        <?php
                        echo "<table class='table table-striped admin-table'><thead><tr><th>Name</th><th>Edit</th><th>Delete</th></tr></thead><tbody>";
                        foreach($genres as $genre):
                            echo "<tr><td>" . $genre['Name'] . "</td><td><form method='post' class='edit-genre' onsubmit='return false;'><button type='submit' class='btneditgenre' name='" . $genre['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td><td><form method='post' class='delete-genre' onsubmit='return false;'><button type='submit' class='btndeletegenre' name='" . $genre['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td></tr>";
                        endforeach;
                        echo "</tbody></table>";
                        ?>
                    </div>
                    <div class="table-mobile">
                        <?php
                        foreach($genres as $genre):
                            echo "<table class='table admin-table'><tr><th><h4 class='title'>Genre ID:</h4><p class='title'>" . $genre['ID'] .  "</p></th></tr><tr><td><h4>Name:</h4><p>" . $genre['Name']  . "</p></td></tr>"
                                . "<tr><td><h4>Edit:</h4><form method='post' class='edit-genre' onsubmit='return false;'><button type='submit' class='btneditgenre' name='" . $genre['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td></tr>"
                                . "<tr><td><h4>Delete:</h4><form method='post' class='delete-genre' onsubmit='return false;'><button type='submit' class='btndeletegenre' name='" . $genre['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td></tr></table>";
                        endforeach;
                        ?>
                    </div>
                </div>
                <div id="add-subgenre" class="content">
                    <h2>Add Subgenre</h2>
                    <form action="scripts/admin/add_subgenre.php" method="post">
                        <div class="form-group col-md-6">
                            <label for="subgenrename">Subgenre Name</label>
                            <input type="text" class="form-control" id="subgenrename" name="subgenrename" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="genreref">Genre</label>
                            <select name="genreref" class="form-control" id="genreref">
                                <?php
                                    foreach($genres as $genre):
                                        echo "<option value='" . $genre['ID'] . "'>" . $genre['Name'] . "</option>";
                                    endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" name="submit">Add Subgenre</button>
                        </div>
                    </form>
                </div>
                <div id="man-subgenres" class="content">
                    <h2>Sub Genres</h2>
                    <div class="table-responsive">
                        <?php
                        echo "<table class='table table-striped admin-table'><thead><tr><th>ID</th><th>Name</th><th>Genre</th><th>Edit</th><th>Delete</th></tr></thead><tbody>";
                        foreach($subgenres as $subgenre):
                            echo "<tr><td>" . $subgenre['ID'] . "</td><td>" . $subgenre['Name'] . "</td><td>" . $subgenre['Genre'] . "</td><td><form method='post' class='edit-subgenre' onsubmit='return false;'><button type='submit' class='btneditsubgenre' name='" . $subgenre['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td><td><form method='post' class='delete-subgenre' onsubmit='return false;'><button type='submit' class='btndeletesubgenre' name='" . $subgenre['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td></tr>";
                        endforeach;
                        echo "</tbody></table>";
                        ?>
                    </div>
                    <div class="table-mobile">
                        <?php
                        foreach($subgenres as $subgenre):
                            echo "<table class='table admin-table'><tr><th><h4 class='title'>Subgenre ID:</h4><p class='title'>" . $subgenre['ID'] .  "</p></th></tr><tr><td><h4>Name:</h4><p>" . $subgenre['Name']  . "</p></td></tr>"
                                . "<tr><td><h4>Genre</h4><p>" . $subgenre['Genre'] . "</p></td></tr><tr><td><h4>Edit:</h4><form method='post' class='edit-subgenre' onsubmit='return false;'><button type='submit' class='btneditsubgenre' name='" . $subgenre['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td></tr>"
                                . "<tr><td><h4>Delete:</h4><form method='post' class='delete-subgenre' onsubmit='return false;'><button type='submit' class='btndeletesubgenre' name='" . $subgenre['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td></tr></table>";
                        endforeach;
                        ?>
                    </div>
                </div>
                <div id="add-publisher" class="content">
                    <h2>Add Publishers</h2>
                    <form action="scripts/admin/add_publisher.php" method="post">
                        <div class="form-group col-md-12">
                            <label for="publishername">Publisher Name</label>
                            <input type="text" class="form-control" id="publishername" name="publishername" required>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" name="submit">Add Publisher</button>
                        </div>
                    </form>
                </div>
                <div id="man-publishers" class="content">
                    <h2>Publishers</h2>
                    <div class="table-responsive">
                        <?php
                        echo "<table class='table table-striped admin-table'><thead><tr><th>ID</th><th>Name</th><th>Edit</th><th>Delete</th></tr></thead><tbody>";
                        foreach($publishers as $publisher):
                            echo "<tr><td>" . $publisher['ID'] . "</td><td>" . $publisher['Name'] . "</td><td><form method='post' class='edit-publisher' onsubmit='return false;'><button type='submit' class='btneditpublisher' name='" . $publisher['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td><td><form method='post' class='delete-publisher' onsubmit='return false;'><button type='submit' class='btndeletepublisher' name='" . $publisher['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td></tr>";
                        endforeach;
                        echo "</tbody></table>";
                        ?>
                    </div>
                    <div class="table-mobile">
                        <?php
                        foreach($publishers as $publisher):
                            echo "<table class='table admin-table'><tr><th><h4 class='title'>ID:</h4><p class='title'>" . $publisher['ID'] .  "</p></th></tr><tr><td><h4>Name:</h4><p>" . $publisher['Name']  . "</p></td></tr>"
                                . "<tr><td><h4>Edit:</h4><form method='post' class='edit-publisher' onsubmit='return false;'><button type='submit' class='btneditpublisher' name='" . $publisher['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td></tr>"
                                . "<tr><td><h4>Delete:</h4><form method='post' class='delete-publisher' onsubmit='return false;'><button type='submit' class='btndeletepublisher' name='" . $publisher['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td></tr></table>";
                        endforeach;
                        ?>
                    </div>
                </div>
                <div id="add-book" class="content">
                    <h2>Add Books</h2>
                    <form action="scripts/admin/add_book.php" method="post" enctype="multipart/form-data">
                        <div class="form-group col-md-6">
                            <label for="author">Author</label>
                            <input type="text" class="form-control" name="author" id="author">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="month">Month</label>
                            <select class="form-control" name="month" id="month">
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
                        <div class="form-group col-md-6">
                            <label for="year">Year</label>
                            <select class="form-control" name="year" id="year">
                                <?php
                                    foreach($years as $year):
                                        echo "<option>" . $year .  "</option>";
                                    endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pub-ref">Publisher</label>
                            <select class="form-control" name="pubref" id="pub-ref">
                                <?php
                                foreach($publishers as $publisher):
                                    echo "<option value='" . $publisher['ID'] . "'>" . $publisher['Name'] .  "</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="type">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option value="Paperback">Paperback</option>
                                <option value="Hardback">Hardback</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="bookImage" id="image">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="subref">Subgenre</label>
                            <select class="form-control" name="subref" id="subref">
                                <?php
                                foreach($subgenres as $subgenre):
                                    echo "<option value='" . $subgenre['ID'] . "'>" . $subgenre['Name'] .  "</option>";
                                endforeach;
                                ?>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea id="description" rows="12" cols="30" maxlength="2000" class="form-control" name="description"></textarea>
                            <p id="countleft"></p>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="quantity">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="price">Price Per Unit</label>
                            <input type="text" class="form-control" name="price" id="price">
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" name="submit">Add Book</button>
                        </div>
                    </form>
                </div>
                <div id="man-books" class="content">
                    <h2>Books</h2>
                    <div class="table-responsive">
                        <?php
                        echo "<table class='table table-striped admin-table'><thead><tr><th>Author</th><th>Title</th><th>Publisher</th><th>Description</th><th>Price</th><th>Edit</th><th>Delete</th></tr></thead><tbody>";
                        foreach($books as $book):
                            $author = $book['Author'];
                            if(strlen($author)> 15) {
                                $author=substr($author,0,15);
                                $author = $author."...";
                            }
                            $booktitle = $book['Title'];
                            if(strlen($booktitle)> 10) {
                                $booktitle=substr($booktitle,0,10);
                                $booktitle = $booktitle."...";
                            }
                            $description = $book['Description'];
                            if(strlen($description)> 10) {
                                $description=substr($description,0,10);
                                $description = $description."...";
                            }
                            echo "<tr><td>" . $author . "</td><td>" . $booktitle . "</td><td>" . $book['Publisher'] . "</td><td>" . $description. "</td><td>£" . $book['Price'] .  "</td><td><form method='post' class='edit-book' onsubmit='return false;'><button type='submit' class='btneditbook' name='" . $book['ID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td><td><form method='post' class='delete-book' onsubmit='return false;'><button type='submit' class='btndeletebook' name='" . $book['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td></tr>";
                        endforeach;
                        echo "</tbody></table>";
                        ?>
                    </div>
                </div>
                <div id="man-orders" class="content">
                    <h2>Orders</h2>
                    <div class="table-responsive">
                        <?php
                        echo "<table class='table table-striped admin-table'><thead><tr><th>Order ID</th><th>Book/s</th><th>Quantity/s</th><th>Customer</th><th>Total</th><th>Delete</th></tr></thead><tbody>";
                        foreach ($orders as $order):
                            echo "<tr><td>" . $order['ID'] . "</td><td>" . $order['book'] . "</td><td>" . $order['Quantity'] . "</td><td>" . $order['User'] . "</td><td>£" . $order['Total'] . "</td><td><form method='post' class='delete-order' onsubmit='return false;'><button type='submit' class='btndeleteorder' name='" . $order['ID'] . "'><i class='fa fa-remove' aria-hidden='true'></i></button></form></td></td></tr>";
                        endforeach;
                        echo "</tbody></table>";
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include 'includes/footer.php';
?>
