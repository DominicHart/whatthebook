<?php
/* Verifying with password_hash method */
/*if(isset($_POST['password'])) {
	$hash = '$2y$10$30rhEYP3SBWixbNGcftCxuNoT.pfXnowhprvsAMGby0nfAjk7AqoK'; // Hash is letter: t
	$password = $_POST['password'];
	if (password_verify($password, $hash)) {
		echo 'Password: ' . $password . "Hash: " . $hash;
	}
	else {
		echo 'Error';
	}
}*/
/* Manual hashing/salt for card details etc */
/*if(isset($_POST['password'])) {
	$password = $_POST['password'];
	$salt = 'f/dsf/5et_fgh/dsg';
	$password = hash('sha256', $salt.$password);
	echo "Password: " . $password;
}
/* Verifying with manual salting/hashing */
/*if(isset($_POST['password'])) {
	$hash = '9f96c23e5accea2a79564a4bf9f240395925f2c39cf211a3d0ea7473b2e68d8d';
	$password = $_POST['password'];
	$salt = 'f/dsf/5et_fgh/dsg';
	$password = hash('sha256', $salt.$password);
	if($hash == $password) {
		echo 'True';
	}
	else {
		echo 'False';
	}
}