<?php
if ($_REQUEST['js_submit_value']) {
    $cardID = $_REQUEST['js_submit_value'];
}
$cards = array();

$startyear = date("Y");
$endyear = date("Y") + 19;
$years = range($startyear, $endyear);

include '../includes/INIT.php';
try {
    $sql = "SELECT cardType, securityNo, cardName, validTo FROM tbl_cards WHERE cardID = :cardID";
    $result = $pdo->prepare($sql);
    $result->bindParam(':cardID', $cardID, PDO::PARAM_INT);
    $result->execute();
}
catch (PDOException $e) {
    $error = 'Error fetching card; ' . $e->getMessage();
}
while ($row = $result->fetch()) {
    $cards[] = array('Type'=> $row['cardType'], 'security' => $row['securityNo'], 'Name' => $row['cardName'], 'Expiry' => $row['validTo']);
}
?>
<div class="editcard" id="editcard">
    <div class="edit-container">
        <form action="scripts/eCard.php" method="post">
            <div class="dialog-header">
                <button type="button" onclick="edit_card()" class="pull-right close">&times;</button>
                <h3>Update your card</h3>
            </div>
            <div class="dialog-content clearfix">
                <?php foreach($cards as $card): ?>
                <div class="form-group">
                    <label for="cardtype" class="sr-only">Card Type</label>
                    <select class="form-control" name="cardType" id="cardtype">
                        <option value="<?php echo $card['Type']; ?>" selected><?php echo $card['Type']; ?></option>
                        <option value="Visa/Delta/Electron">Visa/Delta/Electron</option>
                        <option value="Mastercard/Eurocard">Mastercard/Eurocard</option>
                        <option value="Amnerican Express">American Express</option>
                        <option value="Solo/Maestro">Solo/Maestro</option>
                        <option value="Maestro">Maestro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="cardNumber" class="sr-only">Card Number</label>
                    <input type="text" maxlength="16" class="form-control" name="cardNumber" id="cardNumber" placeholder="Leave blank if card number if the same...">
                </div>
                <div class="form-group">
                    <label for="securityNo" class="sr-only">Card Number</label>
                    <input type="text" maxlength="3" class="form-control" name="securityNo" id="securityNo" value="<?php echo $card['security']; ?>">
                </div>
                <div class="form-group">
                    <label for="cardName" class="sr-only">Cardholder's Name</label>
                    <input type="text" maxlength="100" class="form-control" name="cardName" id="cardName" value="<?php echo $card['Name']; ?>">
                </div>
                <div class="form-group expiry">
                    <?php
                    //Split expiry into month and year
                    $split = explode("/", $card['Expiry']);
                    $vMonth = $split[0];
                    $vYear = $split[1];
                    ?>
                    <label for="expMonth" class="expLabel" class="sr-only">Expiry</label>
                    <select name="expMonth" class="form-control expiry" id="expMonth">
                        <option><?php echo $vMonth ?></option>
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
                    <select name="expYear" class="form-control expiry" id="expYear">
                        <option><?php echo $vYear; ?></option>
                        <?php
                        foreach($years as $year):
                            echo "<option value='" . $year . "'>" . $year . "</option>";
                        endforeach;
                        ?>
                    </select>
                </div>
                <input type="hidden" value="<?php echo $cardID; ?>" name="cardID">
            </div>
            <div class="dialog-buttons">
                <button type="submit" name="submit" class="update-yes">Update</button>
                <button type="button" onclick="edit_card()" class="update-no">Cancel</button>
            </div>
        </form>
        <?php endforeach ?>
    </div>
</div>
