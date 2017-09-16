<?php 
// This page lets the user logout.
// This version uses sessions.
$page_title = 'Logout';
session_start(); // Access the existing session.

// If no session variable exists, redirect the user:
if (!isset($_SESSION['user_login'])) {

	// Need the functions:
	// Set the page title and include the HTML header:
	
	
} else { // Cancel the session:

	$_SESSION = array(); // Clear the variables.
	session_destroy(); // Destroy the session itself.
	setcookie ('PHPSESSID', '', time()-3600, '/', '', 0, 0); // Destroy the cookie.

}
include ('header.html');

$page_title = 'Logged Out!';


// Print a customized message:
echo "<p></p><p><h1>Logged Out</h1></p>
<p><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspYou are now logged out!<br><br><br></p><br><br><br>";
include ('footer.html');
?>