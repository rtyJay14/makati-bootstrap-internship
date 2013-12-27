<?php
// connect to the database
include "libs/db_connect.php";

// get the search term
$search_term = isset($_REQUEST['term']) ? $_REQUEST['term'] : "";

// write your query to search for data
$query = "SELECT 
			id, country, place 
		FROM 
			place 
		WHERE 
			country LIKE \"%{$search_term}%\" OR 
			place LIKE \"%{$search_term}%\" 
		LIMIT 0,10";
		
$stmt = $con->prepare( $query );
$stmt->execute();

// get the number of records returned
$num = $stmt->rowCount();

if($num>0){ 

	// this array will become JSON later
	$data = array();
	
	// loop through the returned data
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		extract($row);
		
		$data[] = array(
			'label' => $country . " " . $place,
			'value' => $id
		);
	}
	
	// convert the array to JSON
	echo json_encode($data);
		
}

//if no records found, display nothing
else{
    die();
}
?>