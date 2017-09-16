<?php 
require ('mysqli_connect.php');
session_start();


$userID=$_SESSION['user_id'];


			
//query database for records matching login and password
		$q = "SELECT * FROM Users WHERE id='$userID'";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		// Check the result:
		if (mysqli_num_rows($r) == 1) {
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$role = $row['role'];
				$address = $row['address'];
				$zipcode = $row['zipcode'];
				$login =$row['login'];
				$password=$row['password'];
				$state = $row['state'];
				$id = $row['id'];
				
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

					
			}//end fetch results while
						
				//IF login AND PASSWORD ARE CORRECT SET THE LOG-IN SESSION
				include ('header.html'); 
				echo "<p></p>";
				echo "<p><br>Welcome user $first_name , $last_name from IP: $ip</b></p>";
				echo "<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspYou are a $role.</p>";
				echo "<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspYou are from $domainName domain.</p>";
				echo "<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspYou address is: $address, $state $zipcode</p>";
				echo "<p><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='http://www.ncbi.nlm.nih.gov/pubmed/?term=$keywords' target='_blank'>Click Here For Your Pubmed Search results</a></h2></p>";
				echo "<p><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='add_product.php'>Add Product</a></p>";
				echo "<p><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='view_product.php'>View Products</a></p>";
				if($role=="staff"){
				echo "<p><br>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp<a href='update_product.php'>Update Products</a><br><br><br></p>";
				}
				include ('footer.html');
	
mysqli_free_result ($r);
mysqli_close($dbc);
?>