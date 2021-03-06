<?php 
session_start();
$page_title = 'Add Product';
require ('mysqli_connect.php');
include ('header.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array(); // Initialize an error array.
	
	// Check for a product name:
	if (empty($_POST['productname'])) {
		$errors[] = 'You forgot to enter the product name.';
	} else {
		$pname = mysqli_real_escape_string($dbc, trim($_POST['productname']));
	}

	
	// Check for a vendor name:
	if (empty($_POST['V_Id'])) {
		$errors[] = 'You must select a vendor name.';
	} else {
		$V_Id = mysqli_real_escape_string($dbc, trim($_POST['V_Id']));
	}
	
	// Check for description:
	if (empty($_POST['description'])) {
		$errors[] = 'You forgot to enter the product description.';
	} else {
		$description = mysqli_real_escape_string($dbc, trim($_POST['description']));
	}
	
	// Check for cost:
	if (empty($_POST['cost'])) {
		$errors[] = 'You forgot to enter the product cost.';
	} else {
		$cost = mysqli_real_escape_string($dbc, trim($_POST['cost']));
	}
	
	// Check for an sell price:
	if (empty($_POST['sell_price'])) {
		$errors[] = 'You forgot to enter the product selling price.';
	} else {
		$sell_price = mysqli_real_escape_string($dbc, trim($_POST['sell_price']));
	}
	
	// Check for a quantity:
	if (empty($_POST['quantity'])) {
		$errors[] = 'You forgot to the quantity.';
	} else {
		$quantity = mysqli_real_escape_string($dbc, trim($_POST['quantity']));
	}
	
	// Check for a cost values to be in range:
	if ($_POST['cost']<0) {
		$errors[] = 'The cost of the product cannot be a negative value.';
	} 

	// Check for a sell_price values to be in range:
	if ($_POST['sell_price']<0) {
		$errors[] = 'The selling price of the product cannot be a negative value.';
	} 
	
	// Check to make sure sell price is not less than the cost:
	if ($_POST['sell_price']<$_POST['cost']) {
		$errors[] = 'The selling price of the product cannot be less than the cost of the product.';
	}
	
	// Check for a quantity values to be in range:
	if ($_POST['quantity']<=0) {
		$errors[] = 'The quantity of the product must be at least 1.';
	}

	//check for duplicate product names
		$duplicatenameq="SELECT name FROM Products_eordanis WHERE name = '$pname'";
		$duplicatenamer=@mysqli_query ($dbc, $duplicatenameq); // Run the query.
			if(mysqli_num_rows($duplicatenamer)>=1){
				$errors[] ="Product name already exists in the database";
			}//if there is a duplicate in the system



// Debugging message:
			//echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $duplicatenameq . ' <p></p>Query: ' . $duplicatenamer . '<p></p>Products_eordanis table name: ' . $producttablename . '</p>';

	if (empty($errors)) { // If everything's OK.
	
	
		//get user_id from session variable
		$user_id=$_SESSION['user_id'];
		
		//get vendor ID from vendors that matches vendorname
		// Make the query:
						$vendorquery = "SELECT V_Id FROM Vendors WHERE Name='$vendor_Name'";		
						$vendorresult = @mysqli_query ($dbc, $vendorquery); // Run the query.
					if ($vendorresult) { // If it ran OK.
						while ($vrowz = mysqli_fetch_array($vendorresult, MYSQLI_ASSOC)){ 
						$vendor_ID=$vrowz['V_Id'];
						}
					}
		
		// Add Product to database...
		
		// Make the insert query:
		$q = "INSERT INTO Products_eordanis (name, description, sell_price, cost, quantity, user_id, vendor_id)  VALUES ('$pname', '$description', '$sell_price', '$cost', '$quantity', '$user_id', '$V_Id')";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		if ($r) { // If it ran OK.
		
			// Print a message:
			echo '<h1>Thank you!</h1>
		<p>You now added the Product.</p><p><br /></p>';
		echo "<br><a href='add_product.php'>Click Here To Add Addtional Products</a><br>";
		echo "<br><a href='view_product.php'>View Products in Products Table</a><br><br><br><br><br><br><br><br><br><br>";	
		
		} else { // If it did not run OK.
			
			// Public message:
			echo '<h1>System Error</h1>
			<p class="error">Product could not be added due to a system error. We apologize for any inconvenience.</p>'; 

			
			// Debugging message:
			//echo '<p>' . mysqli_error($dbc) . '<br /><br />Query: ' . $q . '</p>';
						
		} // End of if ($r) IF.

		mysqli_close($dbc); // Close the database connection.

		// Include the footer and quit the script:
		include ('includes/footer.html'); 
		exit();
		
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
?>
<p></p><p><h1>Add Product</h1></p>
<form action="add_product.php" method="post">
	<p>Product Name: <input type="text" placeholder="Product Name" name="productname" size="30" maxlength="60" required="required" value="<?php if (isset($_POST['productname'])) echo $_POST['productname']; ?>" /></p>
	<p>Description: <input type="text" placeholder="Description" name="description" size="15" maxlength="30" required="required" value="<?php if (isset($_POST['description'])) echo $_POST['description']; ?>" /></p>
	<p>Cost: <input type="text" placeholder="Cost" name="cost" size="15" maxlength="30" required="required" value="<?php if (isset($_POST['cost'])) echo $_POST['cost']; ?>" /></p>
	<p>Sell Price: <input type="text" placeholder="Sell Price" name="sell_price" size="15" maxlength="20" required="required" value="<?php if (isset($_POST['sell_price'])) echo $_POST['sell_price']; ?>" /></p>
	<p>Quantity: <input type="text" placeholder="Quantity" name="quantity" size="10" maxlength="10" required="required" value="<?php if (isset($_POST['quantity'])) echo $_POST['quantity']; ?>"  /> </p>
	<p>Select Vendor:
			<select name="V_Id" required="required" >
					<option selected value="">---Please Select a Vendor---</option>
					<?php
						require ('mysqli_connect.php');
						//get vendor name from vendor table
						// Make the query:
						$vendorq = "SELECT V_Id,Name FROM CPS3740_2015S.Vendors ";		
						$vendorr = @mysqli_query ($dbc, $vendorq); // Run the query.
					if ($vendorr) { // If it ran OK.
						while ($vrow = mysqli_fetch_array($vendorr, MYSQLI_ASSOC)) 
						print '<option value="'.$vrow['V_Id'].'">'.$vrow['Name'].'</option>';
					}
					?>
					
					
					
		</select>
	</p>
	<p><input type="submit" name="submit" value="Add Product" /></p>
</form>
<?php include ('footer.html'); ?>
