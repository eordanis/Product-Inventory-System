<?php
// This script retrieves all the records from the Products_eordanis table.
// This new version allows the results to be sorted in different ways.

session_start();
require ('mysqli_connect.php');
$page_title = 'View  All The Current Products ';
include ('header.html');

echo '<p></p><p><h1>View All Current Products & Related Information</h1></p>';

// Number of records to show per page:
$display = 10;

// Determine how many pages there are...
if (isset($_GET['p']) && is_numeric($_GET['p'])) { // Already been determined.
	$pages = $_GET['p'];
} else { // Need to determine.
 	// Count the number of records:
	$q = "SELECT COUNT(id) FROM Products_eordanis";
	$r = @mysqli_query ($dbc, $q);
	$row = @mysqli_fetch_array ($r, MYSQLI_NUM);
	$records = $row[0];
	
	// Calculate the number of pages...
	if ($records > $display) { // More than 1 page.
		$pages = ceil ($records/$display);
	} else {
		$pages = 1;
	}
} // End of p IF.

// Determine where in the database to start returning results...
if (isset($_GET['s']) && is_numeric($_GET['s'])) {
	$start = $_GET['s'];
} else {
	$start = 0;
}


// Determine the sort...
// Default is by name.
$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'pn';

// Determine the sorting order:
switch ($sort) {
	case 'pid':
		$order_by = 'id ASC';
		break;
	case 'pn':
		$order_by = 'name ASC';
		break;
	case 'pd':
		$order_by = 'description ASC';
		break;
	case 'psp':
		$order_by = 'sell_price ASC';
		break;
	case 'pc':
		$order_by = 'cost ASC';
		break;
	case 'pq':
		$order_by = 'quantity ASC';
		break;
	case 'puid':
		$order_by = 'user_id ASC';
		break;
	case 'pvid':
		$order_by = 'vendor_id ASC';
		break;
	default:
		$order_by = 'name ASC';
		$sort = 'pn';
		break;
}
	
// Define the query:
$q = "SELECT id, name, description, sell_price, cost, quantity, user_id, vendor_id FROM Products_eordanis ORDER BY $order_by LIMIT $start, $display";		
$r = @mysqli_query ($dbc, $q); // Run the query.

// Table header:
echo '<table align="center" cellspacing="10" cellpadding="5" width="100%">
<tr>
	<td align="left"><b><a href="view_product.php?sort=pid">ID</a></b></td>
	<td align="left"><b><a href="view_product.php?sort=pn">Name</a></b></td>
	<td align="left"><b><a href="view_product.php?sort=pd">Descrition</a></b></td>
	<td align="left"><b><a href="view_product.php?sort=psp">Sell Price</a></b></td>
	<td align="left"><b><a href="view_product.php?sort=pc">Cost</a></b></td>
	<td align="left"><b><a href="view_product.php?sort=pq">Quantity</a></b></td>
	<td align="left"><b><a href="view_product.php?sort=puid">User ID</a></b></td>
	<td align="left"><b><a href="view_product.php?sort=pvid">Vendor ID</a></b></td>
	
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
mysqli_free_result ($r);
mysqli_close($dbc);


// Make the links to other pages, if necessary.
if ($pages > 1) {
	
	echo '<br /><p>';
	$current_page = ($start/$display) + 1;
	
	// If it's not the first page, make a Previous button:
	if ($current_page != 1) {
		echo '<a href="view_product.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
	}
	
	// Make all the numbered pages:
	for ($i = 1; $i <= $pages; $i++) {
		if ($i != $current_page) {
			echo '<a href="view_product.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
		} else {
			echo $i . ' ';
		}
	} // End of FOR loop.
	
	// If it's not the last page, make a Next button:
	if ($current_page != $pages) {
		echo '<a href="view_product.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
	}
	
	echo '</p>'; // Close the paragraph.
	
} // End of links section.

include ('footer.html');
?>