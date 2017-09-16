<?php 
require ('mysqli_connect.php');
session_start();
 $errors = array(); // Initialize an error array.

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	// Validate the username
	if (empty($_POST['login'])) {
	$errors[]= "- You forgot to enter your Login ID."; die ;
	} else {
		$l=$_POST['login'];
	}
	
	
	// Validate the password:
	if (empty($_POST['password'])) {
		$errors[]= "- You forgot to enter your password."; die ;
	} else {
		$p=$_POST['password'];
	}
	
	
	// Validate the keywords:
	if (empty($_POST['keywords'])) {
		$errors[]= "- You forgot to enter your a keyword."; die ;
	} else {
		$keywords=$_POST['keywords'];
	}
	
}//end form submission

	if ((!empty($l))&&(!empty($p))){
		
		//query database for records matching login and password
		$q = "SELECT id, login, password, role, last_name, first_name, address, zipcode, state FROM Users WHERE login='$l' AND password='$p'";		
		$r = @mysqli_query ($dbc, $q); // Run the query.
		
		// Check the result:
		if (mysqli_num_rows($r) == 1) {
			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$role = $row['role'];
				$_SESSION['role'] = $row['role'];
				$address = $row['address'];
				$zipcode = $row['zipcode'];
				$login =$row['login'];
				$password=$row['password'];
				$state = $row['state'];
				$id = $row['id'];
				$_SESSION['user_id'] = $row['id'];
				
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
					
					
					//set cookie to user login id and expire in 1 day
					$cookie_name = "loginID";
					$cookie_value = "$login";
					setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
					
					//set session id to user login
					$_SESSION['user_login'] ='$login';
					
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
						
		}//end if password and login match
			
			else if (mysqli_num_rows($r) == 0){ //if there are no matches
			     
				
				//check for login match 
				$lq="SELECT login FROM Users WHERE login = '$l'";
				$lr=@mysqli_query ($dbc, $lq); // Run the query.
			
				if(mysqli_num_rows($lr)==0){
					$errors[] =  "<br>- The login  does not exist on file.</br>"; 	
				}
						//check for login match 
						$lpq="SELECT login, password FROM Users WHERE login = '$l' AND password != '$p'";
						$lpr=@mysqli_query ($dbc, $lpq); // Run the query.
			
						if(mysqli_num_rows($lpr)==1){
						$errors[] = "<br>- The password does not match what is on file.</br>"; 
						}
				
				// Report the errors.
				include ('simpleheader.html');
		echo "<br>";
		echo '<h1>Error!</h1>
		<p class="error">The following error(s) occurred:<br />';
		foreach ($errors as $msg) { // Print each error.
			echo " $msg";
		}
		echo '</p><p><b>Please try again.</b></p>';
?>	

<br>
		<h2> Welcome to Stephanie Eordanidis' CPS3740 site.</h2> 
		<br>
		<h4>Please enter keywords to search on Pubmed</h4>
		<form action= "post.php" method="post">
		<p><br>Keywords: <input type="text" name="keywords" id="keywords" required="required">&nbsp&nbsp(Can Be Multiple Words)</p>
		<p><br>Login ID: &nbsp&nbsp<input type="text" name="login" id="login" required="required"></p>
		<p><br>Password: <input type="password" name="password" id="password" required="required">&nbsp&nbsp<input type="submit" value="Submit"></p>
		<br>			
<?php 				
				include ('footer.html');
			}	//end else if there are no matches
																																																																																																																																																
	}//end if $l and $p is not empty
	
mysqli_free_result ($r);
mysqli_close($dbc);
?>