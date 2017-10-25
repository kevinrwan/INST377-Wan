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
</style>


<script>

// function validateForm() {
//     // you can write a code for validating your forms (if you want).
// }

</script>
</head>
<body>

<?php

// Generating a form with loop
echo "<h1>Form:</h1>";
$arr = array("First Name" => "first_name", "Last Name" => "last_name", "Email" => "email", "Address" => "address", "City" => "city");
echo "<form action='form_display.php' method='POST'>";


foreach ($arr as $key => $value) {

	$type = "text";
	// if input title is an email, changes $type to email type
	if($key == "Email") {
		$type = "email";
	}

	echo "".$key.": <input type='".$type."' name='".$value."' value='".$fetch[$value]."'><br>";
}
echo "<input type='submit' value='Submit'>";
echo "</form>";
?>


</body>
</html>


<?php
// Close the connection.
mysqli_close($conn);
?>