<?php
include 'includes/session.php';

if (isset($_SESSION['userID']))
{
	header("location:index.php");
}

include 'includes/header.php';
?>
<div class="container-fluid">
	<div class="row register">
		<form action="scripts/reg_user.php" method="post">
			<h2>Register</h2>
			<?php
			if (isset($_SESSION['error'])) {
				if ($_SESSION['error'] == "reg1") {
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
				}
			}
			?>
			<div class="tabs">
				<ul class="nav nav-pills">
					<li class="active"><a data-toggle="tab" href="#account"><i class="fa fa-key" aria-hidden="true"></i>Account</a></li>
					<li><a data-toggle="tab" href="#address"><i class="fa fa-map-marker" aria-hidden="true"></i>Address</a></li>
				</ul>
				<div class="tab-content clearfix">
					<div class="tab-pane active" id="account">
						<div class="form-group">
							<label for="name" class="sr-only">Name</label>
							<input type="text" class="form-control" id="name" name="fullname" placeholder="Full Name" required>
						</div>
						<div class="form-group">
							<label for="email" class="sr-only">Email</label>
							<input type="email" name="email1" id="email" class="form-control" placeholder="Email Address" required>
						</div>
						<div class="form-group">
							<label for="email2" class="sr-only">Confirm Email</label>
							<input type="email" name="email2" id="email2" class="form-control" placeholder="Confirm Email" required>
						</div>
						<div class="form-group">
							<label for="password1" class="sr-only">Password</label>
							<input type="password" name="password1" id="password1" class="form-control" placeholder="Password" required>
						</div>
						<div class="form-group">
							<label for="password2" class="sr-only">Confirm Password</label>
							<input type="password" name="password2" id="password2" class="form-control" placeholder="Confirm Password" required>
						</div>
					</div>
					<div class="tab-pane" id="address">
						<div class="form-group">
							<label for="address1" class="sr-only">Address</label>
							<input type="text" class="form-control" id="address1" name="address1" placeholder="House number/name">
						</div>
						<div class="form-group">
							<label for="town" class="sr-only">Town</label>
							<input type="text" class="form-control" id="town" name="town" placeholder="Town">
						</div>
						<div class="form-group">
							<label for="postcode" class="sr-only">Postcode</label>
							<input type="text" class="form-control" id="postcode" name="postcode" placeholder="Postcode">
						</div>
						<div class="form-group">
							<label for="city" class="sr-only">City</label>
							<input type="text" class="form-control" id="city" name="city" placeholder="City">
						</div>
						<div class="form-group">
								<label for="country" class="sr-only">Country</label>
							<input type="text" class="form-control" id="country" name="country" placeholder="Country">
						</div>
					</div>
				</div>
			</div>
			<button type="submit" name="submit">Create Account</button>
			<p class="account-yes">Already have an account? <a href="login.php">Login</a></p>
		</form>
	</div>
</div>
<script src="js/bootstrap.min.js"></script>
</body>
</html>