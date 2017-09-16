<?php 
session_start();
$page_title = 'Search Product';
require ('mysqli_connect.php');
include ('simpleheader.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

	$errors = array(); // Initialize an error array.
	
	// Check for a search term:
	if (empty($_GET['search'])) {
		$errors[] = 'You forgot to enter a search term.';
	} else {
		$search = mysqli_real_escape_string($dbc, trim($_GET['search']));
	}
	
	if (empty($errors)) { // If everything's OK.
	
		// search for product in the database...
		
		
		// Make the query:
		if($search=="*"){
		$q="SELECT id, name, description, sell_price, cost, quantity, user_id, vendor_id FROM Products_eordanis";	
		}
		else {
		$q="SELECT id, name, description, sell_price, cost, quantity, user_id, vendor_id FROM Products_eordanis WHERE  name LIKE '%" . $search . "%' OR description LIKE '%" . $search . "%'"; 		
		}
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if (mysqli_num_rows($r) >= 1) { // If it ran OK.
		
			// Print a message:
			echo '<p><h1>Search Results:</h1></p>';
		
			// Table header:
 			echo '<table align="center" cellspacing="10" cellpadding="5" width="100%">
			<tr>
				<td align="left"><b><a href="search_product.php">ID</a></b></td>
				<td align="left"><b><a href="search_product.php">Name</a></b></td>
				<td align="left"><b><a href="search_product.php">Descrition</a></b></td>
				<td align="left"><b><a href="search_product.php">Sell Price</a></b></td>
				<td align="left"><b><a href="search_product.php">Cost</a></b></td>
				<td align="left"><b><a href="search_product.php">Quantity</a></b></td>
				<td align="left"><b><a href="search_product.php">User ID</a></b></td>
				<td align="left"><b><a href="search_product.php">Vendor ID</a></b></td>
			</tr>
			';

			// Fetch and print all the records....
			$bg = '#eeeeee'; 
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
				echo '<tr bgcolor="' . $bg . '">
				<td align="left">' . $row['id'] . '</td>
				<td align="left">' . $row['name'] . '</td>
				<td align="left">' . $row['description'] . '</td>
				<td align="left">' . $row['sell_price'] . '</td>
				<td align="left">' . $row['cost'] . '</td>
				<td align="left">' . $row['quantity'] . '</td>
				<td align="left">' . $row['user_id'] . '</td>
				<td align="left">' . $row['vendor_id'] . '</td>			
				</tr>
				';
			} // End of WHILE loop.

			echo '</table>';
		}//if r ran ok
			else { //if r did not run ok
				// Public message:
				echo '<br><h1>System Error</h1>
				<p class="error">No record found with the search keywords: '.$search. '</p>'; 
		}
	} else { // Report the errors.
		echo "<br>";
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " - $msg<br />\n";
		}
		echo '</p><p>Please try again.</p>';
		
	} // End of if (empty($errors)) IF.
	
	mysqli_close($dbc); // Close the database connection.

} // End of the main Submit conditional.
include ('footer.html');
?>