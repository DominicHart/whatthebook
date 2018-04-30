<?php
include 'includes/session.php';
include 'includes/header.php';
include 'includes/INIT.php';

include 'includes/nav.php';
?>
<div class="container-fluid">
    <div class="row contact">
        <div class="col-md-8 col-md-offset-2">
            <h2>Contact Us</h2>
            <form method="post" action="">
                <h3>Complete the form</h3>
                <div class="form-group">
                    <label for="name" class="sr-only">Name</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user" aria-hidden="true"></i></span>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Enter your name" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="sr-only">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon2"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                        <input type="text" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="sr-only">Email</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3"><i class="fa fa-exclamation-circle" aria-hidden="true"></i></span>
                        <select name="issue" class="form-control" required>
                            <option value="payment">Payment Issue</option>
                            <option value="delivery">Delivery Issue</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="sr-only">Description</label>
                    <div class="input-group">
                        <span class="input-group-addon" id="basic-addon4"><i class="fa fa-list" aria-hidden="true"></i></span>
                        <textarea id="description" rows="12" cols="30" maxlength="2000" class="form-control" name="description" placeholder="Please describe your issue..."></textarea>
                    </div>
                    <p id="countleft"></p>
                </div>
                <button type="submit" name="submit">SUBMIT</button>
            </form>
        </div>
    </div>
</div>
<?php
include 'includes/footer.php';
?>