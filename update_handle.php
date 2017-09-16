<?php 
session_start();
require ('mysqli_connect.php');
include ('header.html');

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// assign each post value to variable array
	for($i=0;$i<count($_POST["product_id"]);$i++)  {
  $product_id[$i]=$_POST["product_id"][$i];
  $product_name[$i]=$_POST["product_name"][$i];
  $description[$i]=$_POST["description"][$i];
  $sell_price[$i]=$_POST["sell_price"][$i];
  $cost[$i]=$_POST["cost"][$i];
  $quantity[$i]=$_POST["quantity"][$i];
  $user_id[$i]=$_POST["user_id"][$i];
  $vendor_id[$i]=$_POST["vendor_id"][$i];
}

	// UPDATE description value in the database
		for($i=0;$i<count($product_id);$i++)  {
			// Make the query:
			$desq = "UPDATE Products_eordanis SET description='$description[$i]' WHERE id='$product_id[$i]' AND name='$product_name[$i]' AND user_id='$user_id[$i]' AND vendor_id='$vendor_id[$i]'";
			$desr = @mysqli_query ($dbc, $desq);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			
			}
		}
		
		
		// UPDATE sell_price value in the database
		for($i=0;$i<count($product_id);$i++)  {
			// Make the query:
			$spq = "UPDATE Products_eordanis SET sell_price='$sell_price[$i]' WHERE id='$product_id[$i]' AND name='$product_name[$i]' AND user_id='$user_id[$i]' AND vendor_id='$vendor_id[$i]'";
			$spr = @mysqli_query ($dbc, $spq);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
			

			}
		}
		
		// UPDATE cost value in the database
		for($i=0;$i<count($product_id);$i++)  {
			// Make the query:
			$cq = "UPDATE Products_eordanis SET cost='$cost[$i]' WHERE id='$product_id[$i]' AND name='$product_name[$i]' AND user_id='$user_id[$i]' AND vendor_id='$vendor_id[$i]'";
			$cr = @mysqli_query ($dbc, $cq);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			}
		}
		
		// UPDATE quantity value in the database
		for($i=0;$i<count($product_id);$i++)  {
			// Make the query:
			$qq = "UPDATE Products_eordanis SET quantity='$quantity[$i]' WHERE id='$product_id[$i]' AND name='$product_name[$i]' AND user_id='$user_id[$i]' AND vendor_id='$vendor_id[$i]'";
			$qr = @mysqli_query ($dbc, $qq);
			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

			}
		}
	
				// Print a message:
				echo '<p><h1>Product Information Has Been Sucessfully Updated.</h1></p>';
				echo '<p><h2>Click the Link Below to Update Additional Products.</h2></p>';
				echo "<p><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='update_product.php'>Update Products</a><br><br><br></p>";
				
} // End Main submission conditional
	
	
    include ('footer.html');
	mysqli_close($dbc); // Close the database connection.
?>