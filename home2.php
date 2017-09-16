<?php
// This script retrieves the records from the logged in user from the users table.
session_start(); // Access the existing session.
require ('mysqli_connect.php');
$page_title = 'Home';

$userID=$_SESSION['user_id'];

include ('header.html');
echo '<p><h1>Home</h1></p>';


// Define the query:
$q = "SELECT * FROM Users WHERE id='$userID'";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:

echo '<table align="center" cellspacing="10" cellpadding="5" width="100%">';
// Fetch and print all the records....
$bg = '#eeeeee'; 
while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	$role=$row['role'];
	//get IP address
				if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
   					 $ip = $_SERVER['HTTP_CLIENT_IP'];
				} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  					  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
					} else {
   						$ip = $_SERVER['REMOTE_ADDR'];
							}

					//find domain name
					if ((strpos ($ip, "10.") === 0)||(strpos ($ip, "131.125.") === 0)){
						$domainName='Kean';
					} else {$domainName='Unknown';}
	
	
	$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		echo '<tr bgcolor="' . $bg . '">
<tr bgcolor="#eeeeee"><td align="left"><b>Last Name:</b></td><td align="left">' . $row['last_name'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>First Name:</b><td align="left">' . $row['first_name'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Login:</b></td><td align="left">' . $row['login'] . '</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Role:</b></td><td align="left">' . $row['role'] . '</td></tr>
<tr bgcolor="#eeeeee"><td align="left"><b>Address:</b></td><td align="left">' . $row['address'] . ", " .  $row['state'] . ", " . $row['zipcode'] .'</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>IP Address:</b></td><td align="left"> '.$ip.'</td></tr>
<tr bgcolor="#ffffff"><td align="left"><b>Domain:</b></td><td align="left">'.$domainName.'</td></tr>
';
} // End of WHILE loop.
echo '</table>';
				echo "<p><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='add_product.php'>Add Product</a>";
				echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='view_product.php'>View Products</a>";
				if($role=="staff"){
				echo "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='update_product.php'>Update Products</a><br><br><br></p>";
				}
mysqli_free_result ($r);
mysqli_close($dbc);
include ('footer.html');
?>