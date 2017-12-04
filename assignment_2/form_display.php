<?php
$server = "localhost";
$username = "root";
$password = "root";
$db = "sakila";

// Create connection
$conn = mysqli_connect($server, $username, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//echo "Connected successfully<br><br>";

// Part 1, Query to DB using PHP
$sql = 'SELECT * FROM `customer` INNER JOIN address on address.address_id = customer.address_id INNER JOIN city ON city.city_id = address.city_id ORDER BY last_name LIMIT 1 OFFSET 9';
$result = mysqli_query ($conn, $sql);
$fetch = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>
<head>	
<style>
	div {
		margin-top: 20px;
		margin-bottom: 20px;
	}
    table {
        font-size: 10;
        font-family: georgia;
        background-color: #daebe8;
        border: 2px solid darkgreen;
        width: 100%;
    }

    tr {
        font-size: 13;
        font-family: Helvetica;
        text-decoration: underline;
        text-decoration-color: darkgreen;
        color: darkred;        
        border: 1px solid black;
    } 

    td {
        font-size: 10;
        font-family: georgia;
        border: 1px solid black;
        width: 100%;
        padding: 5px;
    }
</style>


</head>
<body>

<table>

<?php 
// The code that you recieve input data from the form goes to here.

$arr = array("First Name" => "first_name", "Last Name" => "last_name", "Email" => "email", "Address" => "address", "City" => "city");


foreach($arr as $key => $value) {

	$showValue = $fetch[$value];
	$change = "exist";

	//If user changed the form input, $showValue stores the new value to put in the table 
	if($_POST[$value] != $fetch[$value]) {
		$showValue = $_POST[$value];
	}

	//If title is an address, queries address table to see if there is an existing address in the database.
	//Same for city, and customer tables. If query returns no rows, $change value is set to new and 3rd column
	//value is updated.
	if($value == "address") {	
		$add = "SELECT * FROM `address` WHERE address = '".$_POST['address']."'";
		$adResult = mysqli_query ($conn, $add);
		$adRows = mysqli_num_rows($adResult);

		if($adRows == 0) {
			$change = "new";
		}


	} elseif($value == "city") {

		$cit = "SELECT * FROM `city` WHERE city = '".$_POST['city']."'";
		$citResult = mysqli_query ($conn, $cit);
		$citRows = mysqli_num_rows($citResult);

		if($citRows == 0) {
			$change = "new";
		}

	} else {
		$fn = "SELECT * FROM `customer` WHERE ".$value." = '".$_POST[$value]."'";
		$fnResult = mysqli_query ($conn, $fn);
		$firstRows = mysqli_num_rows($fnResult);
		
		if($firstRows == 0) {
			$change = "new";
		}

	}

	//generates tags for table rows and columns
	echo "<tr><td>".$key."</td><td>".$showValue."</td><td>".$change."</td></tr>";
}

?>

</table>

</body>
</html>