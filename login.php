<?php
include 'includes/session.php';

if (isset($_SESSION['userID']))
{
    header("location:index.php");
}

include 'includes/header.php';
?>
<div class="container-fluid">
    <div class="row login">
        <form action="scripts/login_action.php" method="post" autocomplete="off">
            <div class="icon-container">
                <i class="fa fa-user" aria-hidden="true"></i>
            </div>
            <?php
            if (isset($_SESSION['error'])) {
                if ($_SESSION['error'] == "login1") {
                    echo "<p class='log-error'>Error: <b>Incorrect username/password combination</b>.</p>";
                }
            }
            ?>
            <div class="form-group">
                <label for="email" class="sr-only">Email Address</label>
                <input type="email" name="email" id="email address" class="form-control" placeholder="Email Address" required autofocus>
            </div>
            <div class="form-group">
                <label for="password" class="sr-only"></label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required autocomplete="new-password">
            </div>
            <button type="submit" name="submit">Login</button>
            <p class="account-no">Not registered? <a href="register.php">Create an account</a></p>
        </form>
    </div>
</div>
</body>
</html>
