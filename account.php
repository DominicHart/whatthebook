<?php
include 'includes/session.php';
include 'includes/header.php';

$users = array();
$cards = array();

$startyear = date("Y");
$endyear = date("Y") + 19;
$years = range($startyear, $endyear);

include 'includes/INIT.php';

try {
    $thisaccount = $_GET['userid'];
    $sql = "SELECT * FROM tbl_users WHERE userID = :userid";
    $result = $pdo->prepare($sql);
    $result->bindParam(':userid', $thisaccount, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching user; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $users[] = array('Fullname' => $row['Fullname'], 'Email' => $row['Email'], 'Address' => $row['Address1'], 'Town' => $row['Town'], 'Postcode' => $row['Postcode'], 'City' => $row['City'], 'Country' => $row['Country']);
}
try {
    $thisaccount = $_GET['userid'];
    $sql = "SELECT * FROM tbl_cards WHERE userID = :userid";
    $result = $pdo->prepare($sql);
    $result->bindParam(':userid', $thisaccount, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching cards; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $cards[] = array('CardID' => $row['cardID'], 'CardNo' => $row['cardNo'], 'CardName' => $row['cardName'], 'CardType' => $row['cardType'], 'ValidTo' => $row['validTo']);
}
if (isset($_SESSION['userID']))
{
    if ($thisuser != $thisaccount) {
        header('location:account?userid=' . $thisuser . '');
    }
}
else
{
    header('location:login');
}
include 'includes/nav.php';
?>
<div class="container-fluid">
    <div class="row account">
                <div class="col-md-8 col-md-offset-2">
                    <h2>Manage your account</h2>
                    <div class="tabs">
                        <?php
                        if (isset($_SESSION['error'])) {
                            if ($_SESSION['error'] == "eCard1") {
                                echo "<p class='c-error'>Error: <b>Month does not exist</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p>";
                            } else if ($_SESSION['error'] == "eCard2") {
                                echo "<p class='c-error'>Error: <b>Year is invalid</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p>";
                            } else if ($_SESSION['error'] == "eCard3") {
                                echo "<p class='c-error'>Error: <b>Card type invalid</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p>";
                            } else if ($_SESSION['error'] == "euserAdmin") {
                                echo "<div class='col-md-7 col-md-offset-4'><p class='a-error'>Error: <b>User not updated</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p></div>";
                            } else if ($_SESSION['error'] == "eUser1") {
                                echo "<p class='c-error'>Error: <b>Passwords do not match</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p>";
                            } else if ($_SESSION['error'] == "eUser2") {
                                echo "<p class='c-error'>Error: <b>Passwords must contain at least one uppercase letter</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p>";
                            } else if ($_SESSION['error'] == "eUser1") {
                                echo "<p class='c-error'>Error: <b>Passwords must contain at least one lowercase letter</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p>";
                            } else if ($_SESSION['error'] == "eUser4") {
                                echo "<p class='c-error'>Error: <b>Passwords must contain at least one number</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p>";
                            } else if ($_SESSION['error'] == "eUser5") {
                                echo "<p class='c-error'>Error: <b>Passwords must be 8 characters or longer</b>. Try again or <a href='scripts/reset.php'>refresh</a>.</p>";
                            }
                        }
                        ?>
                        <ul class="nav nav-pills">
                            <li class="active"><a data-toggle="tab" href="#details"><i class="fa fa-user" aria-hidden="true"></i>User details</a></li>
                            <li><a data-toggle="tab" href="#add-cards"><i class="fa fa-credit-card" aria-hidden="true"></i>Add Cards</a></li>
                            <li><a data-toggle="tab" href="#edit-cards"><i class="fa fa-credit-card" aria-hidden="true"></i>Edit Cards</a></li>
                        </ul>
                        <div class="tab-content clearfix">
                            <div class="tab-pane active" id="details">
                                <form action="scripts/eUser2.php" method="post">
                                    <h3>Update details</h3>
                                    <?php foreach($users as $user): ?>
                                    <div class="form-group">
                                        <label for="fullname"><i class="fa fa-user" aria-hidden="true"></i>Name</label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" value="<?php echo $user['Fullname']; ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label><i class="fa fa-envelope" aria-hidden="true"></i>Email Address</label>
                                        <p>You cannot change your email address.</p>
                                        <input type="text" value="<?php echo $user['Email']; ?>" class="form-control non-edit" disabled required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password1"><i class="fa fa-lock" aria-hidden="true"></i>Password</label>
                                        <p>Only complete to change your password.</p>
                                        <input type="password" class="form-control" name="password1" id="password1" placeholder="Enter new password">
                                    </div>
                                    <div class="form-group">
                                        <label for="password2"><i class="fa fa-lock" aria-hidden="true"></i>Confirm Password</label>
                                        <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirm new password">
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" value="<?php echo $user['Address']; ?>" class="form-control" name="address" id="address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="town">Town</label>
                                        <input type="text" value="<?php echo $user['Town']; ?>" class="form-control" name="town" id="town" required>
                                    </div>
                                        <div class="form-group">
                                            <label for="postcode">Postcode</label>
                                            <input type="text" value="<?php echo $user['Postcode']; ?>" class="form-control" name="postcode" id="postcode" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="town">City</label>
                                            <input type="text" value="<?php echo $user['City']; ?>" class="form-control" name="city" id="city" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="country">Country</label>
                                            <input type="text" value="<?php echo $user['Country']; ?>" class="form-control" name="country" id="country" required>
                                        </div>
                                        <input type="hidden" value="<?php echo $thisaccount; ?>" name="userID" required>
                                    <?php endforeach; ?>
                                    <button class="submit" type="submit" name="submit">Submit</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="add-cards">
                                <form action="scripts/addcard.php" method="post">
                                    <h3>Add Card</h3>
                                    <div class="form-group">
                                        <label for="cardType">Card Type</label>
                                        <select class="form-control" name="cardType" id="cardType" required>
                                            <option value="Visa/Delta/Electron">Visa/Delta/Electron</option>
                                            <option value="Mastercard/Eurocard">Mastercard/Eurocard</option>
                                            <option value="Amnerican Express">American Express</option>
                                            <option value="Solo/Maestro">Solo/Maestro</option>
                                            <option value="Maestro">Maestro</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cardNumber">Card Number</label>
                                        <input type="text" maxlength="16" class="form-control" name="cardNumber" id="cardNumber" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="securityNo">Security Code</label>
                                        <input type="text" maxlength="3" class="form-control" name="securityNo" id="securityNo" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="cardName">Cardholder's Name</label>
                                        <p>Enter the name as shown on the card.</p>
                                        <input type="text" maxlength="100" class="form-control" name="cardName" id="cardName" required>
                                    </div>
                                    <div class="form-group expiry">
                                        <label for="expMonth" class="expLabel">Expiry</label>
                                        <select name="expMonth" class="form-control expiry" id="expMonth" required>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                        </select>
                                        <select name="expYear" class="form-control expiry" id="expMonth" required>
                                            <?php
                                            foreach($years as $year):
                                                echo "<option value='" . $year . "'>" . $year . "</option>";
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                    <button class="submit clearfix" type="submit" name="submit">Submit</button>
                                </form>
                            </div>
                            <div class="tab-pane" id="edit-cards">
                                <h3>Update Cards</h3>
                                <?php
                                    echo "<div class='table-responsive'><table class='table table-striped'><tr><th>Type</th><th>Name</th><th>Expiry</th><th>Edit</th><th>Delete</th></tr>";
                                    foreach($cards as $card):
                                        echo "<tr><td>" . $card['CardType'] . "</td><td>" . $card['CardName'] . "</td><td>" . $card['ValidTo'] . "</td><td><form method='post' action='' class='edit-card' onsubmit='return false;'><button type='submit' class='btneditcard' name='" . $card['CardID'] . "'><i class='fa fa-pencil' aria-hidden='true'></i></button></form></td><td><form method='post' action='' class='delete-card' onsubmit='return false;'><button type='submit' class='btndeletecard' name='" . $card['CardID'] . "'><i class='fa fa-trash' aria-hidden='true'></i></button></form></td></tr>";
                                    endforeach;
                                    echo "</table></div>"
                                ?>
                                <div id="edit-delete"></div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
<?php include 'includes/footer.php'; ?>
           