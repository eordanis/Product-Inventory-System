<?php
// This file contains the database access information. 
// This file also establishes a connection to MySQL, 
// selects the database, and sets the encoding.

// Set the database access information as constants:
DEFINE ('DB_USER', 'eordanis');
DEFINE ('DB_PASSWORD', '0691609');
DEFINE ('DB_HOST', 'imc.kean.edu');
DEFINE ('DB_NAME', 'CPS3740_2015S');



// Make the connection:
$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

// Set the encoding...
mysqli_set_charset($dbc, 'utf8');